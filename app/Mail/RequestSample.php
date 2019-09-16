<?php

namespace App\Mail;

use App\EmailTemplate;
use App\Sample;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Config;
use CountryState;

class RequestSample extends Mailable
{

    use Queueable,
        SerializesModels;

    public $sample;
    public $template;
    public $template_attributes;
    public $mail_contents;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Sample $sample, EmailTemplate $template)
    {
        $this->sample = $sample;
        $this->user = $sample->getUser;
        $this->template = $template;
        $this->template_attributes = $template->getEmailTemplateAttributes()->where('attr_key', '<>', 'main_body')->get();
        $this->mail_contents = $template->getEmailTemplateAttributes()->where('attr_key', 'main_body')->first()->attr_val;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->populate_data();
        return $this->subject($this->template->subject)->view('emails.sample_request.sample-request');
    }

    protected function populate_data()
    {
        if ($this->sample) {
            $this->mail_contents = str_replace("{%APP_NAME%}", config('app.name'), $this->mail_contents);
            $this->mail_contents = str_replace("{%FULL_NAME%}", $this->user->first_name . " " . $this->user->last_name, $this->mail_contents);
            $this->mail_contents = str_replace("{%FIRST_NAME%}", $this->user->first_name, $this->mail_contents);
            $this->mail_contents = str_replace("{%LAST_NAME%}", $this->user->last_name, $this->mail_contents);
            $this->mail_contents = str_replace("{%EMAIL%}", $this->user->email, $this->mail_contents);
            $this->mail_contents = str_replace("{%PHONE_NUMBER%}", $this->user->phone_no, $this->mail_contents);
            $this->mail_contents = str_replace("{%GENDER%}", $this->user->gender == 0 ? 'Male' : 'Female', $this->mail_contents);
            $template_blocks = $this->template_attributes;
            foreach ($template_blocks as $template_block) {
                switch ($template_block->attr_key) {
                    case 'company_block':
                        $block_contents = str_replace('{%COMPANY%}', $this->sample->company, $template_block->attr_val);
                        $this->mail_contents = str_replace("{%COMPANY_BLOCK%}", $block_contents, $this->mail_contents);
                        break;

                    case 'address_block':
                        $states = CountryState::getStates('US');
                        $countries = CountryState::getCountries();
                        $block_contents = '';
                        if ($this->sample->street) {
                            $street_address = $this->sample->street;
                            if ($this->sample->street2) {
                                $street_address .= (", " . $this->sample->street2);
                            }
                            $block_contents = str_replace('{%STREET_ADDRESS%}', $street_address, $template_block->attr_val);
                            $block_contents = str_replace('{%CITY%}', $this->sample->city, $block_contents);
                            $block_contents = str_replace('{%STATE%}', isset($states[$this->sample->state]) ? $states[$this->sample->state] : $this->sample->state, $block_contents);
                            $block_contents = str_replace('{%POSTAL_CODE%}', $this->sample->postal_code, $block_contents);
                            $block_contents = str_replace('{%COUNTRY%}', isset($countries[$this->sample->country]) ? $countries[$this->sample->country] : $this->sample->country, $block_contents);
                        }
                        $this->mail_contents = str_replace("{%ADDRESS_BLOCK%}", $block_contents, $this->mail_contents);
                        break;
                    case 'product_1_block':
                        $block_contents = str_replace('{%PRODUCT_1_NAME%}', $this->sample->getProduct1->getParsedName(), $template_block->attr_val);
                        $this->mail_contents = str_replace("{%PRODUCT_1_BLOCK%}", $block_contents, $this->mail_contents);
                        break;
                    case 'product_2_block':
                        $block_contents = '';
                        if ($this->sample->getProduct2) {
                            $block_contents = str_replace('{%PRODUCT_2_NAME%}', $this->sample->getProduct2->getParsedName(), $template_block->attr_val);
                        }
                        $this->mail_contents = str_replace("{%PRODUCT_2_BLOCK%}", $block_contents, $this->mail_contents);
                        break;

                    case 'weight_block':
                        $block_contents = '';
                        if ($this->sample->weight) {
                            $weights = Config::get('constants.WEIGHTS');
                            $block_contents = str_replace('{%WEIGHT%}', $weights[$this->sample->weight], $template_block->attr_val);
                        }
                        $this->mail_contents = str_replace("{%DOG_WEIGHT_BLOCK%}", $block_contents, $this->mail_contents);
                        break;


                    default:
                        // do nothing
                }
            }
        }
    }

}
