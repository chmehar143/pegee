<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactUsRequest;
use Mail;
use Illuminate\Support\Facades\Log;

class ContactUsController extends Controller
{

    /**
     *
     * @param \App\Http\Controllers\ContactUsRequest $request
     * @param Mail
     */
    public function contactUs(ContactUsRequest $request)
    {
        $fromName = $request->get('name');
        $fromMail = $request->get('email');
        $fromSubject = $request->get('subject');
        $frombodyMessage = $request->get('bodyMessage');
        try {

            Mail::send('contact-us.contact-us', array(
                'name' => $fromName,
                'email' => $fromMail,
                'subject' => $fromSubject,
                'bodyMessage' => $frombodyMessage
            ), function ($message) use ($fromMail, $fromSubject) {
                $message->from('contactus@petpads.net');
                $message->to('customer@petpads.net', 'Admin')->subject($fromSubject);
            });
        } catch (\Exception $e) {
            Log::warning($e->getMessage());
        }
        return redirect()->route('static-page', ['slug' => 'contact-us'])->with('success', 'We will be in touch shortly.');
    }

}
