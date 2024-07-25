<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('旅行の思い出編集') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('memories.update', $memory) }}" method="POST" enctype="multipart/form-data" id="memory-form">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="title" class="block text-gray-700">題名</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $memory->title) }}" class="block mt-1 w-full">
                        </div>

                        <div class="mb-4">
                            <label for="destination" class="block text-gray-700">目的地</label>
                            <input type="text" name="destination" id="destination" value="{{ old('destination', $memory->destination) }}" class="block mt-1 w-full">
                        </div>

                        <div class="mb-4">
                            <label for="nights" class="block text-gray-700">泊数</label>
                            <input type="number" name="nights" id="nights" value="{{ old('nights', $memory->nights) }}" class="block mt-1 w-full">
                        </div>

                        <div class="mb-4">
                            <label for="days" class="block text-gray-700">日数</label>
                            <input type="number" name="days" id="days" value="{{ old('days', $memory->days) }}" class="block mt-1 w-full">
                        </div>

                        <div class="mb-4">
                            <label for="departure_time" class="block text-gray-700">出発時間</label>
                            <input type="time" name="departure_time" id="departure_time" value="{{ old('departure_time', $memory->departure_time) }}" class="block mt-1 w-full">
                        </div>

                        <div class="mb-4">
                            <label for="departure_location" class="block text-gray-700">出発地</label>
                            <input type="text" name="departure_location" id="departure_location" value="{{ old('departure_location', $memory->departure_location) }}" class="block mt-1 w-full">
                        </div>

                        <div class="mb-4">
                            <label for="schedule" class="block text-gray-700">タイムスケジュール</label>
                            <textarea name="schedule" id="schedule" class="block mt-1 w-full" rows="5">{{ old('schedule', $memory->schedule) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="thoughts" class="block text-gray-700">感想</label>
                            <textarea name="thoughts" id="thoughts" class="block mt-1 w-full" rows="5">{{ old('thoughts', $memory->thoughts) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="images" class="block text-gray-700">画像</label>
                            <input type="file" name="images[]" id="images" multiple class="block mt-1 w-full">
                            @if($memory->images)
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-4" id="existing-images">
                                    @foreach (json_decode($memory->images) as $index => $image)
                                        <div class="relative image-container" data-image="{{ $image }}">
                                            <img src="{{ asset('storage/' . $image) }}" alt="image" class="w-full h-32 object-cover rounded-lg">
                                            <button type="button" class="absolute top-0 right-0 m-2 p-1 bg-red-500 text-white rounded-full delete-image" data-image="{{ $image }}">×</button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="flex justify-end mt-4">
                            <button type="submit" class="btn btn-success">更新</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
        .btn {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 600;
            transition: all 0.2s ease-in-out;
        }
        .btn-success {
            background-color: #10b981;
            color: white;
        }
        .btn-success:hover {
            background-color: #059669;
        }
        .btn-danger {
            background-color: #ef4444;
            color: white;
        }
        .btn-danger:hover {
            background-color: #dc2626;
        }
        .font-poppins {
            font-family: 'Poppins', sans-serif;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const deleteButtons = document.querySelectorAll('.delete-image');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const imageContainer = this.closest('.image-container');
                    const image = this.dataset.image;

                    fetch('{{ route('memories.deleteImage', $memory) }}', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({ image }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            imageContainer.remove();
                        } else {
                            alert('画像の削除に失敗しました。');
                        }
                    })
                    .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>
</x-app-layout>