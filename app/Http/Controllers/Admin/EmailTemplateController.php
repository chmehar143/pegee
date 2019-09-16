<?php

namespace App\Http\Controllers\Admin;

use App\EmailTemplate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\EmailTemplateRequest;
use Illuminate\Support\Facades\Config;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $data['email_templates'] = EmailTemplate::orderBy('template_type')->get();
        $data['page'] = 'email_templates';
        return view('admin.email_template.index', $data);
        //
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
     * @param  \App\EmailTemplate $emailTemplate
     * @return \Illuminate\Http\Response
     */
    public function show(EmailTemplate $emailTemplate)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EmailTemplate $emailTemplate
     * @return \Illuminate\Http\Response
     */
    public function edit(EmailTemplate $emailTemplate)
    {
        $data = [];
        $data['email_template'] = $emailTemplate;
        $data['email_template_attributes'] = $emailTemplate->getEmailTemplateAttributes;
        $data['hints'] = [];

        $data['page'] = 'email_templates';
        return view('admin.email_template.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\EmailTemplate $emailTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(EmailTemplateRequest $request, EmailTemplate $emailTemplate)
    {
        $emailTemplate->subject = $request->get('subject');
        $emailTemplate->is_active = $request->get('is_active', 0);
        $emailTemplate->save();

        $attr_keys = $request->get('attr_key');
        $attr_vals = $request->get('attr_val');
        for ($i = 0; $i < count($attr_keys); $i++) {
            $email_template_attribute = $emailTemplate->getEmailTemplateAttributes()->where('attr_key', $attr_keys[$i])->first();
            if ($email_template_attribute) {
                $email_template_attribute->attr_val = $attr_vals[$i];
                $email_template_attribute->save();
            }
        }
        return redirect()->route('email_templates.index')->with('success', 'Email Template updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EmailTemplate $emailTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmailTemplate $emailTemplate)
    {
        //
    }

}
