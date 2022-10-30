<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            プロフィール変更
        </h2>

        <x-message :message="session('message')" />

    </x-slot>

    <div class="font-sans text-gray-900 antialiased">
        <div class="w-full md:w-1/2 mx-auto p-6">

        <form method="POST" action="{{ route('profile.update', $user) }}" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />

                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)" required />
            </div>

            <!-- Avatar -->
            <div class="mt-4">
                <x-input-label for="avatar" :value="__('プロフィール画像（任意・1MBまで）')" />
                <div class="rounded-full w-36">
                    <img src="{{asset('storage/avatar/'.($user->avatar??'user_default.jpg'))}}">
                </div>

                <x-text-input id="avatar" class="block mt-1 w-full rounded-none" type="file" name="avatar" :value="old('avatar')" />

            </div>

            <!-- Password -->
            <!-- requiredを削除 -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <!-- requiredを削除 -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="myclass">
                    {{ __('送信する') }}
                </x-primary-button>
            </div>
        </form>
        </div>
    </div>
</x-app-layout>