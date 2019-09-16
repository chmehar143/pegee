<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Welcome extends Mailable
{

    use Queueable,
        SerializesModels;

    public $user;
    public $template;
    public $template_attribute;
    public $mail_contents;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $template)
    {
        $this->user = $user;
        $this->template = $template;
        $this->template_attribute = $template->getEmailTemplateAttributes()->first();
        $this->mail_contents = $this->template_attribute->attr_val;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->populate_data();
        return $this->subject($this->template->subject)->view('emails.welcome-mail');
    }

    protected function populate_data()
    {
        if ($this->user) {
            $this->mail_contents = str_replace("{%FIRST_NAME%}", $this->user->first_name, $this->mail_contents);
            $this->mail_contents = str_replace("{%LAST_NAME%}", $this->user->last_name, $this->mail_contents);
            $this->mail_contents = str_replace("{%FULL_NAME%}", $this->user->first_name . " " . $this->user->last_name, $this->mail_contents);
            $this->mail_contents = str_replace("{%APP_NAME%}", config('app.name'), $this->mail_contents);
            $this->mail_contents = str_replace("{%EMAIL%}", $this->user->email, $this->mail_contents);
            $this->mail_contents = str_replace("{%GENDER%}", $this->user->gender == 0 ? 'Male' : 'Female', $this->mail_contents);
            $this->mail_contents = str_replace("{%PHONE_NUMBER%}", $this->user->phone_no, $this->mail_contents);
        }
    }

}
