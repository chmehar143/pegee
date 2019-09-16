<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Sample;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Requests\SampleRequest;
use CountryState;
use Illuminate\Support\Facades\Config;
use App\Mail\Welcome;
use App\Mail\RequestSample;
use Illuminate\Support\Facades\Session;
use App\EmailTemplate;
use App\MetaTag;
use Illuminate\Support\Facades\Log;

class SampleController extends Controller
{

    public function index(Request $request)
    {
        $data = [];
        $message = '';
        $success = true;
        $already_submitted = false;
        $data['selected_product'] = $request->get('product', "");
        $data['products'] = Product::getProductsForFreeSamples();
        if (Auth::check()) {
            $sample = Auth::user()->getSample;
            if ($sample != null) {
                $success = false;
                $already_submitted = true;
                $data['sample'] = $sample;
                $data['sampleUser'] = $sample->getUser;
            }

        }
        if (count($data['products']) == 0 && !$already_submitted) {
            $success = false;
            Session::flash('error', 'No products available for free samples, Please try again later');
        }



        $data['title'] = 'Free Sample Request';
        $data['page'] = 'sample';
        $data['states'] = CountryState::getStates('US');
        $data['countries'] = CountryState::getCountries();
        $data['weights'] = Config::get('constants.WEIGHTS');
        $data['success'] = $success;
        $data['message'] = $message;
        $data['already_submitted'] = $already_submitted;
        $meta_tags = MetaTag::getMetas('sample-page', 1);
        $data['meta_tags'] = $meta_tags;
        return view('sample.index', $data);
    }

    /**
     *
     * @param SampleRequest $request
     */
    public function sampleRequest(SampleRequest $request)
    {
        //if user is already logged in
        $new_user = false;
        if (Auth::check()) {
            $user = Auth::user();
            if (!$user->phone_no || ($user->phone_no && $user->phone_no != $request->input('phone_no'))) {
                $user->phone_no = $request->input('phone_no');
            }
        } else {
            $user = new User();
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');
            $user->password = bcrypt($request->input('password'));
            $user->gender = $request->input('gender');
            $user->phone_no = $request->input('phone_no');
            $user->status = 1;
            $new_user = true;
        }
        $user->save();
        $already_submitted = $user->getSample;
        if ($already_submitted) {
            return redirect()->route('sample.request');
        } else {
            $sample = new Sample();
            $sample->company = $request->input('company');
            $sample->street = $request->input('street');
            $sample->street2 = $request->input('street_2');
            $sample->city = $request->input('city');
            $sample->state = $request->input('state');
            $sample->postal_code = $request->input('postal_code');
            $sample->country = $request->input('country');
            $sample->currently_using = $request->input('currently_using');
            $sample->product_id = $request->input('product1');
            $sample->product_id2 = $request->input('product2');
            $sample->weight = $request->input('weight');
            $sample->user_id = $user->id;
            $sample->save();
            if ($new_user) {
                /**
                 * check if template of email exists send email
                 */
                $customer_welcome_email_template = EmailTemplate::where('template_type', EmailTemplate::CUSTOMER_WELCOME)
                    ->where('is_active', 1)
                    ->first();
                if($customer_welcome_email_template) {
                    if (env('MAIL_SAMPLE_REQUEST_USERNAME') && env('MAIL_SAMPLE_REQUEST_PASSWORD')) {
                        if(env('MAIL_SAMPLE_REQUEST_FROM')){
                            Config::set('mail.from', [
                                'address' => env('MAIL_SAMPLE_REQUEST_FROM'),
                                'name' => env('MAIL_FROM_NAME'),
                            ]);
                        }
                        Config::set('mail.username', env('MAIL_SAMPLE_REQUEST_USERNAME'));
                        Config::set('mail.password', env('MAIL_SAMPLE_REQUEST_PASSWORD'));
                    }
                    try{
                        \Mail::to($user)->send(new Welcome($user, $customer_welcome_email_template));
                    } catch (\Exception $e) {
                        Log::warning($e->getMessage());
                    }
                }
            }

            $customer_sample_request_email_template = EmailTemplate::where('template_type', EmailTemplate::CUSTOMER_SAMPLE_REQUEST_EMAIL)
                ->where('is_active', 1)
                ->first();
            if($customer_sample_request_email_template){
                try{

                    \Mail::to($user)->send(new RequestSample($sample, $customer_sample_request_email_template));
                } catch (\Exception $e) {
                    Log::warning($e->getMessage());
                }
            }

            $admin_sample_request_email_template = EmailTemplate::where('template_type', EmailTemplate::ADMIN_SAMPLE_REQUEST_EMAIL)
                ->where('is_active', 1)
                ->first();
            if($admin_sample_request_email_template){
                try{
                    \Mail::to(env('PAYMENT_APPROVED_EMAIL'))->send(new RequestSample($sample, $admin_sample_request_email_template));
                } catch (\Exception $e) {
                    Log::warning($e->getMessage());
                }
            }

            return redirect()->route('sample.request')->with('success', 'Your sample request has been submitted succuessfully!');

        }
    }

}
