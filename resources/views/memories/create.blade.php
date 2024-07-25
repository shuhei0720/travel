<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('旅行の思い出作成') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($errors->any())
                        <div class="mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="text-red-500">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('memories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="title" class="block font-medium text-sm text-gray-700">{{ __('題名') }}</label>
                            <input id="title" class="block mt-1 w-full" type="text" name="title" required autofocus />
                        </div>

                        <div class="mb-4">
                            <label for="destination" class="block font-medium text-sm text-gray-700">{{ __('目的地') }}</label>
                            <input id="destination" class="block mt-1 w-full" type="text" name="destination" />
                        </div>

                        <div class="mb-4 flex">
                            <div class="mr-4">
                                <label for="nights" class="block font-medium text-sm text-gray-700">{{ __('泊数') }}</label>
                                <select id="nights" name="nights" class="block mt-1 w-full">
                                    @for ($i = 0; $i <= 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div>
                                <label for="days" class="block font-medium text-sm text-gray-700">{{ __('日数') }}</label>
                                <select id="days" name="days" class="block mt-1 w-full">
                                    @for ($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="departure_time" class="block font-medium text-sm text-gray-700">{{ __('出発時間') }}</label>
                            <select id="departure_time" name="departure_time" class="block mt-1 w-full">
                                @for ($i = 0; $i < 24; $i++)
                                    <option value="{{ sprintf('%02d:00', $i) }}">{{ sprintf('%02d:00', $i) }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="departure_location" class="block font-medium text-sm text-gray-700">{{ __('出発地') }}</label>
                            <input id="departure_location" class="block mt-1 w-full" type="text" name="departure_location" />
                        </div>

                        <div class="mb-4">
                            <label for="schedule" class="block font-medium text-sm text-gray-700">{{ __('タイムスケジュール') }}</label>
                            <textarea id="schedule" name="schedule" rows="4" class="block mt-1 w-full"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="thoughts" class="block font-medium text-sm text-gray-700">{{ __('感想') }}</label>
                            <textarea id="thoughts" name="thoughts" rows="4" class="block mt-1 w-full"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="images" class="block font-medium text-sm text-gray-700">{{ __('画像（複数可）') }}</label>
                            <input id="images" type="file" name="images[]" multiple class="block mt-1 w-full" />
                            <p class="text-sm text-gray-600 mt-2">複数の画像をアップロードできます。CtrlまたはCmdキーを押しながら画像を選択してください。</p>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="ml-4 px-4 py-2 bg-blue-600 text-white rounded-lg">
                                {{ __('保存') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>