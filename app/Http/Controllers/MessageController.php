<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Comment;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages=Message::orderBy('created_at', 'desc')->simplepaginate(3);
        $user=auth()->user();
        return view('message.index', compact('messages', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('message.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            ['title' => 'required|max:255',
            'content' => 'required|max:1000'],
            ['title.required' => '件名を入力してください。',
            'content.required' => '内容を入力してください。']
        );

        $message=new Message();
        $message->title=$request->title;
        $message->content=$request->content;
        $message->user_id=auth()->user()->id;
        if(request('file')){
            $original = request()->file('file')->getClientOriginalName();
            //日時追加
            $name = date('Ymd_His').'_'.$original;
            request()->file('file')->move('storage/files', $name);
            $message->file = $name;
        }
        $message->save();
        return redirect()->route('message.create')->with('message', '投稿を作成しました。');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        return view('message.show', compact('message'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        return view('message.edit', compact('message'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        $request->validate(
            ['title' => 'required|max:255',
            'content' => 'required|max:1000'],
            ['title.required' => '件名を入力してください。',
            'content.required' => '内容を入力してください。']
        );
       
        $message->title=$request->title;
        $message->content=$request->content;
        $message->user_id=auth()->user()->id;
        if(request('file')){
            $original = request()->file('file')->getClientOriginalName();
            //日時追加
            $name = date('Ymd_His').'_'.$original;
            request()->file('file')->move('storage/files', $name);
            $message->file = $name;
        }
        $message->save();
        return redirect()->route('message.show', $message)->with('message', '投稿を更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        $message->comments()->delete();
        $message->delete();
        return redirect()->route('message.index')->with('message', '投稿を削除しました。');
    }

    public function mymessage()
    {
        $user=auth()->user()->id;
        $messages=Message::where('user_id', $user)->orderBy('created_at', 'desc')->simplepaginate(3);
        return view('message.mymessage', compact('messages'));
    }

    public function mycomment()
    {
        $user=auth()->user()->id;
        $comments=Comment::where('user_id', $user)->orderBy('created_at', 'desc')->simplepaginate(3);
        return view('message.mycomment', compact('comments'));
    }
}
