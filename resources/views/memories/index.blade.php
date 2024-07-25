<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('旅行の思い出') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ route('memories.create') }}" class="btn btn-primary mb-4">
                        <svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        新規作成
                    </a>
                    <div class="grid grid-cols-1 gap-6">
                        @foreach ($memories as $memory)
                            <div class="memory-card bg-white shadow-md rounded-lg overflow-hidden mb-6">
                                <div class="memory-card-header bg-blue-500 text-white py-2 px-4">
                                    <h3 class="text-lg font-bold">{{ $memory->title }}</h3>
                                </div>
                                <div class="memory-card-body p-4">
                                    <div class="mb-4">
                                        <p><strong>目的地:</strong> {{ $memory->destination }}</p>
                                        <p><strong>期間:</strong> {{ $memory->nights }}泊{{ $memory->days }}日</p>
                                        <p><strong>出発時間:</strong> {{ $memory->departure_time }}</p>
                                        <p><strong>出発地:</strong> {{ $memory->departure_location }}</p>
                                    </div>
                                    <div class="flex flex-col lg:flex-row">
                                        <div class="lg:w-1/2 mb-4 lg:mb-0">
                                            <div class="grid grid-cols-1 gap-4">
                                                <div class="border border-gray-300 p-4 rounded-lg">
                                                    <h4 class="font-semibold">タイムスケジュール</h4>
                                                    <p class="font-poppins whitespace-pre-wrap">{!! convertLinks($memory->schedule) !!}</p>
                                                </div>
                                                <div class="border border-gray-300 p-4 rounded-lg mt-4">
                                                    <h4 class="font-semibold">感想</h4>
                                                    <p class="font-poppins">{{ $memory->thoughts }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="lg:w-1/2">
                                            <div class="grid grid-cols-1 gap-4">
                                                @foreach (json_decode($memory->images) as $image)
                                                    <div class="square-image-container">
                                                        <img src="{{ asset('storage/' . $image) }}" alt="image" class="square-image rounded-lg">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="memory-card-footer p-4 bg-gray-100 flex justify-end space-x-4">
                                    <button class="memory-modal-toggle btn btn-secondary" data-target="#modal-{{ $memory->id }}">
                                        <svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0h-4m-6 0H3"></path>
                                        </svg>
                                        詳細
                                    </button>
                                    <a href="{{ route('memories.edit', $memory) }}" class="btn btn-success">
                                        <svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0h-4m-6 0H3"></path>
                                        </svg>
                                        編集
                                    </a>
                                    <form action="{{ route('memories.destroy', $memory) }}" method="POST" class="inline-block delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            削除
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- モーダルウィンドウ -->
                            <div id="modal-{{ $memory->id }}" class="memory-modal fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 hidden">
                                <div class="memory-modal-content bg-white p-6 rounded-lg shadow-lg max-w-4xl w-full">
                                    <button class="memory-modal-close btn btn-danger">&times;</button>
                                    <div class="mb-4">
                                        <h3 class="text-lg font-bold mb-4">{{ $memory->title }}</h3>
                                        <p><strong>目的地:</strong> {{ $memory->destination }}</p>
                                        <p><strong>期間:</strong> {{ $memory->nights }}泊{{ $memory->days }}日</p>
                                        <p><strong>出発時間:</strong> {{ $memory->departure_time }}</p>
                                        <p><strong>出発地:</strong> {{ $memory->departure_location }}</p>
                                    </div>
                                    <div class="flex flex-col lg:flex-row">
                                        <div class="lg:w-1/2 mb-4 lg:mb-0">
                                            <div class="grid grid-cols-1 gap-4">
                                                <div class="border border-gray-300 p-4 rounded-lg">
                                                    <h4 class="font-semibold">タイムスケジュール</h4>
                                                    <p class="font-poppins whitespace-pre-wrap">{!! convertLinks($memory->schedule) !!}</p>
                                                </div>
                                                <div class="border border-gray-300 p-4 rounded-lg mt-4">
                                                    <h4 class="font-semibold">感想</h4>
                                                    <p class="font-poppins">{{ $memory->thoughts }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="lg:w-1/2">
                                            <div class="grid grid-cols-1 gap-4">
                                                @foreach (json_decode($memory->images) as $image)
                                                    <div class="square-image-container">
                                                        <img src="{{ asset('storage/' . $image) }}" alt="image" class="square-image rounded-lg">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
        .memory-card {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 24px;
        }
        .memory-card-header {
            background-color: #3b82f6;
            color: white;
            padding: 8px 16px;
        }
        .memory-card-body {
            padding: 16px;
            font-family: 'Poppins', sans-serif;
        }
        .memory-card-footer {
            padding: 16px;
            background-color: #f3f4f6;
        }
        .square-image-container {
            position: relative;
            width: 100%;
            padding-bottom: 100%; /* 1:1 ratio */
        }
        .square-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .memory-modal {
            display: none; /* 初期は非表示 */
            align-items: center;
            justify-content: center;
            z-index: 50;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .memory-modal.show {
            display: flex; /* 表示する際はフレックスレイアウト */
        }
        .memory-modal-content {
            background-color: white;
            padding: 24px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 640px;
            width: 100%;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 600;
            transition: all 0.2s ease-in-out;
        }
        .btn-primary {
            background-color: #3b82f6;
            color: white;
        }
        .btn-primary:hover {
            background-color: #2563eb;
        }
        .btn-secondary {
            background-color: #6b7280;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #4b5563;
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

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modalToggles = document.querySelectorAll('.memory-modal-toggle');
            modalToggles.forEach(toggle => {
                toggle.addEventListener('click', () => {
                    const modal = document.querySelector(toggle.dataset.target);
                    modal.classList.toggle('show');
                });
            });

            const modals = document.querySelectorAll('.memory-modal');
            modals.forEach(modal => {
                const closeBtn = modal.querySelector('.memory-modal-close');
                closeBtn.addEventListener('click', () => {
                    modal.classList.remove('show');
                });
            });

            window.addEventListener('click', (event) => {
                modals.forEach(modal => {
                    if (event.target === modal) {
                        modal.classList.remove('show');
                    }
                });
            });

            const deleteForms = document.querySelectorAll('.delete-form');
            deleteForms.forEach(form => {
                form.addEventListener('submit', (e) => {
                    if (!confirm('本当に削除しますか？')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
</x-app-layout>