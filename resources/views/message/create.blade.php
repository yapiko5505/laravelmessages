<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            投稿の新規作成            
        </h2>
        <x-message :message="session('message')" /> 
    </x-slot>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mx-4 sm:p-8">
                <form method="post" action="{{route('message.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="md:flex items-center mt-8">
                        <div class="w-full flex flex-col">
                        <label for="title" class="font-semibold leading-none mt-4">件名</label>
                        @error('title')
                            <p class="text-danger" style="color:red">{{$message}}</p>
                        @enderror
                        <input type="text" name="title" class="w-auto py-2 placeholder-gray-300 border border-gray-300 rounded-md" id="title" value="{{old('title')}}" placeholder="Enter Title">
                        </div>
                    </div>
    
                    <div class="w-full flex flex-col">
                        <label for="content" class="font-semibold leading-none mt-4">内容</label>
                        @error('content')
                            <p class="text-danger" style="color:red">{{$message}}</p>
                        @enderror
                        <textarea name="content" class="w-auto py-2 placeholder-gray-300 border border-gray-300 rounded-md" id="content" cols="30" rows="10">{{old('content')}}</textarea>
                    </div>
    
                    <div class="w-full flex flex-col">
                        <label for="file" class="font-semibold leading-none mt-4">ファイル(1MBまで) </label>
                        <div>
                        <input id="file" type="file" name="file">
                        </div>
                    </div>

                    <x-primary-button class="myclass">
                        送信する
                    </x-primary-button>
                    
                </form>
            </div>
        </div>

</x-app-layout>