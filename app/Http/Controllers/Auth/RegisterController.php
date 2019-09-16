<?php

namespace App\Http\Controllers\Auth;

use App\EmailTemplate;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use File;
use Intervention\Image\Facades\Image;
use App\Mail\Welcome;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class RegisterController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Register Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users as well as their
      | validation and creation. By default this controller uses a trait to
      | provide this functionality without requiring any additional code.
      |
     */

use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/homepage';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm() {
        return view('auth.register', ['title' => 'Sign Up']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users,email',
                    'password' => 'required|string|min:6|confirmed',
                    'profile_picture' => 'image|mimes:jpeg,png,jpg|max:2048',
                    'phone_no' => 'max:14',
                    'gender' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data) {
        $file_name = "";
        $user = User::create([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
                    'profile_picture' => $file_name,
                    'phone_no' => $data['phone_no'],
                    'gender' => $data['gender'],
                    'status' => 1,
        ]);
        if (isset($data['profile_picture'])) {
            $thumbnail_path = public_path('uploads/propic/thumbnail/');
            $original_path = public_path('uploads/propic/original/');
            $file_name = 'user_' . $user->id . '_' . str_random(32) . '.' . $data['profile_picture']->extension();
            File::makeDirectory($thumbnail_path, $mode = 0755, true, true);
            File::makeDirectory($original_path, $mode = 0755, true, true);
            Image::make($data['profile_picture'])
                    ->resize(261, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save($original_path . $file_name)
                    ->resize(90, 90)
                    ->save($thumbnail_path . $file_name);

            $user->update(['profile_picture' => $file_name]);
        }
        /**
         * check if template of email exists send email
        */
        $email_template = EmailTemplate::where('template_type', EmailTemplate::CUSTOMER_WELCOME)
            ->where('is_active', 1)
            ->first();
        if($email_template){
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
                \Mail::to($user)->send(new Welcome($user, $email_template));
            } catch (\Exception $e) {
                Log::warning($e->getMessage());
            }
        }

        return $user;
    }

}
