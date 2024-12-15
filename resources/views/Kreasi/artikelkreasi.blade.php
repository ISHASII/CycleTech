<<<<<<< HEAD
@extends('Layout.kreasiapp')
=======
<<<<<<< HEAD
@extends('Layout.kreasiapp')
=======
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cycle Tech</title>
    <link rel="icon" type="image/x-icon" href="/images/logo 2.png">
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script>
        function toggleExtraCards() {
            const moreButton = document.getElementById('moreButton');
            const extraCards = document.getElementById('extraCards');

            moreButton.addEventListener('click', function () {
                extraCards.classList.toggle('hidden');
                moreButton.textContent = extraCards.classList.contains('hidden') ? 'Lebih Banyak' : 'Lebih Sedikit';
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            toggleExtraCards();
        });
    </script>
</head>
<body>
    <!-- header -->
    <nav class="bg-gradient-to-r from-birumuda to-krem shadow-lg fixed top-0 w-full h-18 z-50">
        <div class="container mx-auto flex items-center justify-between py-4 px-6 md:px-10">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/logo 2.png') }}" alt="Logo" class="w-10 h-10 rounded-full">
                <h1 class="text-xl font-semibold text-hulk">Cycle Tech</h1>
            </div>

            <!-- Centered Navigation Links for Desktop -->
            <ul class="hidden lg:flex items-center space-x-6 font-medium text-gray-700">
                <li><a href="{{ route('dashboard.nasabah') }}" class="text-black hover:text-old-hulk">Beranda</a></li>
                <li><a href="{{ route('kelola.sampah') }}" class="hover:text-old-hulk">Kelola Sampah</a></li>
                <li>
                    <div class="relative inline-block text-left">
                        <button id="desktopKreasiButton" type="button" class="text-white bg-green-700 rounded-lg hover:bg-old-hulk inline-flex justify-center w-full px-4 py-2">
                            Kreasi
                        </button>
                        <div id="desktopKreasiDropdown" class="absolute right-0 z-10 hidden mt-2 w-20 rounded-md bg-green-200 shadow-lg">
                            <div class="py-1">
                                <a href="{{ route('kreasi') }}" class="block px-4 py-2 text-sm text-gray-700 bg-green-200 hover:bg-green-300">Kreasi</a>
                                <a href="{{ route('kreasiku') }}" class="block px-4 py-2 text-sm text-gray-700 bg-green-200 hover:bg-green-300">Kreasiku</a>
                            </div>
                        </div>
                    </div>
                </li>
                <li><a href="{{ route('tentang.kami') }}" class="hover:text-green-700">Tentang Kami</a></li>
            </ul>

            @php
                use App\Models\Notification;
                $notifications = Notification::latest()->take(5)->get(); // Ambil 5 notifikasi terbaru
            @endphp

            <!-- Notification Dropdown -->
            <div class="flex flex-row space-x-6">
                <!-- Notification Dropdown -->
                <div class="relative mt-2 lg:mt-0">
                    <!-- Notification Icon -->
                    <button id="notificationButton" class="relative focus:outline-none mt-2">
                        <img src="https://cdn.jsdelivr.net/npm/bootstrap-icons/icons/bell.svg" alt="Notification" class="w-6 h-6">
                        @if($notifications->where('read_status', false)->count() > 0)
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
                                {{ $notifications->where('read_status', false)->count() }}
                            </span>
                        @endif
                    </button>

                    <!-- Dropdown -->
                    <div id="notificationDropdown" class="absolute right-0 mt-2 w-72 bg-white rounded-lg shadow-lg border border-gray-200 z-50 hidden">
                        <div class="p-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold">Notifikasi</h3>
                        </div>
                        <ul class="divide-y divide-gray-200">
                            @forelse($notifications as $notification)
                                <li class="p-4 flex items-start">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">{{ $notification->message }}</p>
                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </li>
                            @empty
                                <li class="p-4">
                                    <p class="text-sm text-gray-500 text-center">Tidak ada notifikasi baru</p>
                                </li>
                            @endforelse

                            <form action="{{ route('notifications.mark-read') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-sm text-blue-700 hover:underline px-6 py-2">Tandai semua sebagai sudah dibaca</button>
                            </form>
                        </ul>
                    </div>
                </div>
                    <!-- Hamburger Icon (only visible on smaller screens) -->
                    <li class="lg:hidden flex items-center">
                        <button id="mobileMenuToggle" class="text-black active:text-hulk focus:outline-none mt-2">
                            <i class="bi bi-list text-3xl"></i>
                        </button>
                    </li>

                    <!-- Profile Icon (only visible on larger screens) -->
                    <li class="hidden lg:flex items-center">
                        <a href="{{ route('profile.nasabah') }}">
                            <img src="{{ auth('nasabah')->check() && auth('nasabah')->user()->photo ? asset('storage/' . auth('nasabah')->user()->photo) : 'https://via.placeholder.com/40' }}"
                            alt="Profile"
                            class="w-10 h-10 rounded-full border border-gray-300">

                        </a>
                    </li>
                    
                    <!-- logout -->
                    <li class="hidden lg:flex items-center">
                        <button id="logoutButton" type="button" class="text-gray-600 hover:text-red-600 focus:outline-none">
                            <img src="https://cdn.jsdelivr.net/npm/bootstrap-icons/icons/box-arrow-right.svg" alt="Logout" class="w-6 h-6">
                        </button>
                    </li>
                </div>
            </div>

            <!-- Dropdown Menu for Mobile -->
            <ul id="mobileDropdownMenu" class="lg:hidden hidden flex-col px-4 items-center space-y-4 bg-white border-t border-gray-200 py-4 font-medium text-gray-700">
                <li><a href="{{ route('dashboard.nasabah') }}" class="hover:text-hulk">Beranda</a></li>
                <li><a href="{{ route('kelola.sampah') }}" class="hover:text-hulk">Kelola Sampah</a></li>
                <li><a href="{{ route('kreasi') }}" class="hover:text-hulk">Kreasi</a></li>
              	<li><a href="{{ route('kreasiku') }}" class="hover:text-hulk">Kreasiku</a></li>
                <li><a href="{{ route('tentang.kami') }}" class="hover:text-hulk">Tentang Kami</a></li>
                <li><a href="{{ route('profile.nasabah') }}" class="hover:text-hulk">Profil</a></li>
                <li>
                    <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-red-600 focus:outline-none">
                            <img src="https://cdn.jsdelivr.net/npm/bootstrap-icons/icons/box-arrow-right.svg" alt="Logout" class="w-6 h-6">
                        </button>
                    </form>
                </li>
            </ul>
    </nav>

    <!-- Modal -->
    <div id="logoutModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-lg max-w-sm w-full p-6">
            <h2 class="text-lg font-semibold text-gray-800">Konfirmasi Logout</h2>
            <p class="text-gray-600 mt-2">Apakah Anda yakin ingin logout?</p>
            <div class="flex justify-end mt-4 space-x-4">
                <button id="cancelLogout" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                    Batal
                </button>
                <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Dropdown Notification
        document.getElementById('notificationButton').addEventListener('click', function () {
            const dropdown = document.getElementById('notificationDropdown');
            dropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', (event) => {
            if (!event.target.closest('#notificationButton') && !event.target.closest('#notificationDropdown')) {
                notificationDropdown.classList.add('hidden');
            }
        });

        // Desktop Kreasi Dropdown
        const desktopKreasiButton = document.getElementById('desktopKreasiButton');
        const desktopKreasiDropdown = document.getElementById('desktopKreasiDropdown');

        desktopKreasiButton.addEventListener('click', () => {
            desktopKreasiDropdown.classList.toggle('hidden');
        });

        // Mobile Menu Toggle
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mobileDropdownMenu = document.getElementById('mobileDropdownMenu');

        mobileMenuToggle.addEventListener('click', () => {
            mobileDropdownMenu.classList.toggle('hidden');
        });

        // Show Modal
        document.getElementById('logoutButton').addEventListener('click', function () {
            document.getElementById('logoutModal').classList.remove('hidden');
        });

        // Hide Modal
        document.getElementById('cancelLogout').addEventListener('click', function () {
            document.getElementById('logoutModal').classList.add('hidden');
        });
    </script>
>>>>>>> baa65628154ff9a58268be167bb2c9b5b72110a8
>>>>>>> 8fcbca0a90afe9395a317b845ac72dde2e131c71

@section('content')
    <!-- artikel -->
    <div class="max-w-3xl mx-auto p-4 mt-24">
        <!-- Breadcrumb -->
        <nav class="text-lg text-gray-600 mb-4">
            <a href="{{ route('kreasi')}}" class="hover:underline">Kreasi</a> >
            <span class="text-gray-800">{{ $kreasi->judul_kreasi }}</span>
        </nav>
        <!-- Main Card -->
        <div class="max-w-4xl mx-auto p-6 bg-white border border-hulk rounded-lg shadow-lg ">

            <!-- Header Image -->
            <div class="flex justify-center mb-6">
                <img src="{{ asset('storage/' . $kreasi->foto_kreasi) }}" alt="{{ $kreasi->judul_kreasi }}" class="w-40 h-40 rounded-full border-4 border-hulk shadow-lg">
            </div>

            <!-- Content -->
            <div class="max-w-3xl mx-auto py-5">
                <!-- Judul -->
                <h1 class="text-2xl font-bold text-green-700 mb-4 text-center">{{ $kreasi->judul_kreasi }}</h1>

                <!-- Informasi Detail -->
                <div class="text-gray-600 space-y-2">
                    <!-- Penulis -->
                    <div>
                        <span class="font-semibold text-black">Penulis:</span> {{ $kreasi->author }}
                    </div>

                    <!-- Kategori -->
                    <div>
                        <span class="font-semibold text-black">Kategori:</span> {{ $kreasi->kategori_kreasi ?? 'Kategori tidak ditemukan' }}
                    </div>

                    <!-- Tanggal -->
                    <div>
                        <span class="font-semibold text-black">Diterbitkan:</span>
                        {{ \Carbon\Carbon::parse($kreasi->tanggal)->format('d M Y') }}
                    </div>
                </div>
            </div>

            <!-- Alat dan Bahan -->
            <h2 class="text-lg font-semibold text-hulk mb-3">Alat dan Bahan:</h2>
            <ul class="list-disc pl-6 text-gray-700 mb-6">
                {!! nl2br(e($kreasi->alat_bahan)) !!}
            </ul>

            <!-- Langkah-Langkah -->
            <h2 class="text-lg font-semibold text-hulk mb-3">Langkah-langkah:</h2>
            <ol class="list-decimal pl-6 text-gray-700">
                {!! nl2br(e($kreasi->langkah)) !!}
            </ol>
        </div>
    </div>

    <!-- Similar Creations Section -->
    <div class="px-40 mb-6">
    @if($kreasiSerupa->isNotEmpty())
        <h2 class="flex justify-center text-center text-2xl font-extrabold text-gray-800 mb-4 mt-8">Kreasi Serupa</h2>
        <div class="flex flex-col lg:flex-row justify-center items-center gap-8 mt-12 hover:outerline-old-hulk ">
            @foreach($kreasiSerupa->take(2) as $item)
                <div class="bg-gradient-to-b from-birumuda border hover:border-old-hulk to-krem p-6 rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-300 w-[300px] h-[400px]">
                    <a href="{{ route('artikel.kreasi', $item->id) }}">
                        <h3 class="text-md lg:text-xl font-bold text-gray-800 mb-2">{{ $item->judul_kreasi }}</h3>
                        <img src="{{ asset('storage/' . $item->foto_kreasi) }}" alt="{{ $item->judul_kreasi }}" class="w-full h-48 object-cover rounded-t-lg overlay:hidden">
                        <p class="text-gray-600 mt-2">Oleh {{ $item->author }}</p>
                    </a>
                </div>
            @endforeach
        </div>
        @else
        <p class="text-center text-gray-600 mt-8">Tidak ada kreasi serupa ditemukan.</p>
    @endif
    </div>
@endsection
    