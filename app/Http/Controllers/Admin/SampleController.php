<?php

namespace App\Http\Controllers\Admin;

use App\EmailTemplate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Sample;
use App\Product;
use Illuminate\Support\Facades\Config;
use CountryState;
use App\ModelFilters\AdminFilters\SampleFilter;
use App\Mail\RequestSample;
use Illuminate\Support\Facades\Log;

class SampleController extends Controller
{

    /**
     * Admin authentication
     */
    public function __construct()
    {
        $this->middleware('admin.auth')->except('logout');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        $data['samples'] = Sample::filter($request->all(), SampleFilter::class)->orderBy('id', 'desc')->paginateFilter(10);
        $data['products'] = Product::where('product_status', 1)->get();
        $data['weights'] = Config::get('constants.WEIGHTS');
        $data['approved'] = Config::get('constants.ISAPPROVED');
        $data['states'] = CountryState::getStates('US');
        $data['countries'] = CountryState::getCountries();
        $data['page'] = 'index-samples';
        return view('admin.sample.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sample_request = Sample::findOrFail($id);
        $user = $sample_request->getUser;
        $data['approved'] = Config::get('constants.ISAPPROVED');
        $data['weights'] = Config::get('constants.WEIGHTS');
        $data['user'] = $user;
        $data['page'] = 'index-samples';
        $data['states'] = CountryState::getStates('US');
        $data['countries'] = CountryState::getCountries();
        $data['sample_request'] = $sample_request;
        return view('admin.sample.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     *
     * @param type $id
     * @return type
     */
    public function approveSample($id)
    {
        if ($id != "") {
            $sample = Sample::findOrFail($id);
            $sample->is_approved = 1;
            $sample->save();

            $customer_sample_request_approved_email_template = EmailTemplate::where('template_type', EmailTemplate::CUSTOMER_SAMPLE_REQUEST_APPROVED_EMAIL)
                ->where('is_active', 1)
                ->first();
            if ($customer_sample_request_approved_email_template) {
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
                try {
                    \Mail::to($sample->getUser->email)->send(new RequestSample($sample, $customer_sample_request_approved_email_template));
                } catch (\Exception $e) {
                    Log::warning($e->getMessage());
                }
            }
            return redirect()->route('samples.index')->with('success', 'Sample request approved successfully! & Approved email sent to customer');
        } else {
            return redirect()->route('samples.index')->with('error', 'Some error occour!');
        }
    }

}
