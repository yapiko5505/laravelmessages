<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            投稿一覧
        </h2>

        <x-message :message="session('message')" />

    </x-slot>

    {{-- 投稿一覧表示用のコード --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{$user->name}}さん、どうぞ。
        @foreach ($messages as $message)
            <div class="mx-4 sm:p-8">
                <div class="mt-4">
                    <div class="bg-white w-full  rounded-2xl px-10 py-8 shadow-lg hover:shadow-2xl transition duration-500">
                        <div class="mt-4">
                            <div class="flex">
                                <div class="rounded-full w-12 h-12">
                                    <!-- アバター表示 -->
                                    <img src="{{asset('storage/avatar/'.($message->user->avatar??'user_default.jpg'))}}">
                                </div>
                                <h1 class="text-lg text-gray-700 font-semibold hover:underline cursor-pointer">
                                    <a href="{{route('message.show', $message)}}">{{$message->title}}</a>
                                </h1>
                            </div>
                            <hr class="w-full">
                            <p class="mt-4 text-gray-600 py-4">{{Str::limit($message->content, 100, '...')}}</p>
                            <div class="text-sm font-semibold flex flex-row-reverse">
                                <p>{{$message->user->name}} • {{$message->created_at->diffForHumans()}}</p>
                            </div>
                            <!-- コメント部分 -->
                            <hr class="w-full mb-2">
                            @if($message->comments->count())
                            <span class="badge">
                                返信{{$message->comments->count()}}件
                            </span>
                            @else
                            <span>コメントはまだありません。</span>
                            @endif
                            <a href="{{route('message.show', $message)}}" style="color:white;">
                                <x-primary-button class="myclass float-right">コメントする</x-primary-button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <br>
        {{$messages->links()}}
    </div>   
</x-app-layout>
