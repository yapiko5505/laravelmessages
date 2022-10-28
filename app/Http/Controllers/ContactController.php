<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactForm;
use App\Models\Contact;

class ContactController extends Controller
{
    public function create()
    {
        return view('contact.create');
    }

    public function store(Request $request)
    {
        $inputs=request()->validate(
            ['title'=>'required|max:255',
            'email'=>'required|email|max:255',
            'content'=>'required|max:1000'],
            ['title.required' => '件名を入力してください。',
            'email.required' => 'メールアドレスを入力してください。',
            'content.required' => '内容を入力してください。']
        );
        Contact::create($inputs);

        Mail::to(config('mail.admin'))->send(new ContactForm($inputs));
        Mail::to($inputs['email'])->send(new ContactForm($inputs));
        
        return back()->with('message', 'メールを送信したのでご確認ください。');
    }
}
