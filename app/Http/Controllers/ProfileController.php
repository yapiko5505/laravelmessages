<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Role;

class ProfileController extends Controller
{
    public function index() {
        $users = User::all();
        return view('profile.index', compact('users'));
    }

    public function edit(User $user) {
        $this->authorize('update', $user);
        $roles=Role::all();
        return view('profile.edit', compact('user', 'roles'));
    }

    public function update(User $user, Request $request) {
        $this->authorize('update', $user);

        // バリデーション
         $request->validate(
            ['name'=>'required|max:255',
             'email'=>['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)]],
             ['name.required' => 'ネームを入力してください。',
             'email.required' => 'メールアドレスを入力してください。']
            );

        // パスワードの設定
        if(!isset($user['password'])) {
            unset($user['password']);
        } else {
            $user['password'] = Hash::make($user['password']);
        }

        // アバターの設定
        if(isset($user['avatar'])) {
            if($user->avatar!=='user_default.jpg') {
                $oldavatar='public/avatar/'.$user->avatar;
                Storage::delete($oldavatar);
            }
            $name=request()->file('avatar')->getClientOriginalName();
            $avatar=date('Ymd_His').'_'.$name;
            request()->file('avatar')->storeAs('public/avatar', $avatar);
            $user->avatar->$name;

        }
        $user->save();
        return back()->with('message', '情報を更新しました。');
    }

    public function delete(User $user) {
        $user->roles()->detach();
        if($user->avatar!=='user_default.jpg'){
            $oldavatar='public/avatar'.$user->avatar;
            Storage::delete($oldavatar);
        }
        $user->delete();
        return back()->with('message', '情報を削除しました。');
    }
}
