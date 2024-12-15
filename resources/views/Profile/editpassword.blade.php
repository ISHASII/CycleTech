<<<<<<< HEAD
@extends('Layout.profileapp')
=======
<<<<<<< HEAD
@extends('Layout.profileapp')
=======
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cycle Tech</title>
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    @vite('resources/css/app.css')
    <link rel="icon" type="image/x-icon" href="/images/logo 2.png">
</head>

<body class="bg-blue-50 min-h-screen flex flex-col">
    <nav class="bg-gradient-to-r from-birumuda to-krem shadow-lg fixed top-0 w-full h-18 z-50">
        <div class="container mx-auto flex items-center justify-between py-4 px-6 md:px-10">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/logo 2.png') }}" alt="Logo" class="w-10 h-10 rounded-full">
                <h1 class="text-xl font-semibold text-hulk">Cycle Tech</h1>
            </div>

            <!-- Centered Navigation Links for Desktop -->
            <ul class="hidden lg:flex items-center space-x-6 font-medium text-gray-700">
                <li><a href="{{ route('dashboard.nasabah') }}" class="text-black hover:text-hulk">Beranda</a></li>
                <li><a href="{{ route('kelola.sampah') }}" class="hover:text-old-hulk">Kelola Sampah</a></li>
                <li>
                    <div class="relative inline-block text-left">
                        <button id="desktopKreasiButton" type="button" class="text-black hover:text-old-hulk">
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

    <!-- Modal logout -->
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
    <section class="p-8 flex justify-center mt-16">
        <div class="w-full max-w-lg bg-white border border-hulk rounded-lg p-6">
            <h3 class="font-semibold text-lg mb-6">Ubah Kata Sandi Anda</h3>

            <!-- Tampilkan pesan sukses -->
            @if (session('success'))
                <div class="mb-4 text-green-600 font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Tampilkan pesan error -->
            @if ($errors->any())
                <div class="mb-4 text-red-600 font-medium">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Ubah Kata Sandi -->
            <form method="POST" action="{{ route('profile.updatePassword') }}">
                @csrf

                <!-- Current Password -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Kata sandi saat ini</label>
                    <div class="flex items-center border border-hulk rounded-lg p-2">
                        <span class="text-hulk mr-2">
                            <i class="bi bi-lock-fill"></i>
                        </span>
                        <input type="password" name="current_password" class="w-full border-none focus:outline-none" placeholder="Kata sandi saat ini" required>
                    </div>
                </div>

                <!-- New Password -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Kata sandi baru</label>
                    <div class="flex items-center border border-hulk rounded-lg p-2">
                        <span class="text-hulk mr-2">
                            <i class="bi bi-lock-fill"></i>
                        </span>
                        <input type="password" name="new_password" class="w-full border-none focus:outline-none" placeholder="Kata sandi baru" required>
                    </div>
                </div>

                <!-- Confirm New Password -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Konfirmasi kata sandi baru</label>
                    <div class="flex items-center border border-hulk rounded-lg p-2">
                        <span class="text-hulk mr-2">
                            <i class="bi bi-lock-fill"></i>
                        </span>
                        <input type="password" name="new_password_confirmation" class="w-full border-none focus:outline-none" placeholder="Konfirmasi kata sandi baru" required>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex space-x-4">
                    <button type="submit" class="px-6 py-2 bg-hulk text-white rounded-full hover:bg-old-hulk font-semibold">
                        Ubah
                    </button>
                    <a href="{{ route('profile.keamanan') }}" id="backButton" class="px-6 py-2 border-2 border-old-hulk text-hulk rounded-full hover:bg-old-hulk font-semibold hover:text-white">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </section>
  
  	<script>
    // Variabel untuk memantau apakah form telah diubah
    let isFormChanged = false;
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> 8fcbca0a90afe9395a317b845ac72dde2e131c71

    // Tambahkan event listener pada semua input di dalam form
    document.querySelectorAll('form input').forEach(input => {
        input.addEventListener('input', function () {
            isFormChanged = true; // Tandai bahwa form telah diubah
        });
    });

    // Tombol "Kembali"
    document.getElementById('backButton').addEventListener('click', function (event) {
        // Mencegah navigasi default
        event.preventDefault();

        if (isFormChanged) {
            // Jika form telah diubah, tampilkan konfirmasi
            const userConfirmed = confirm('Apakah Anda yakin ingin kembali tanpa menyimpan perubahan?');
            if (userConfirmed) {
                // Jika pengguna setuju, navigasikan ke halaman target
                window.location.href = this.href;
            }
        } else {
            // Jika form tidak diubah, navigasikan langsung
            window.location.href = this.href;
        }
    });

  </script>
<<<<<<< HEAD
=======
>>>>>>> baa65628154ff9a58268be167bb2c9b5b72110a8

    // Tambahkan event listener pada semua input di dalam form
    document.querySelectorAll('form input').forEach(input => {
        input.addEventListener('input', function () {
            isFormChanged = true; // Tandai bahwa form telah diubah
        });
    });

    // Tombol "Kembali"
    document.getElementById('backButton').addEventListener('click', function (event) {
        // Mencegah navigasi default
        event.preventDefault();

        if (isFormChanged) {
            // Jika form telah diubah, tampilkan konfirmasi
            const userConfirmed = confirm('Apakah Anda yakin ingin kembali tanpa menyimpan perubahan?');
            if (userConfirmed) {
                // Jika pengguna setuju, navigasikan ke halaman target
                window.location.href = this.href;
            }
        } else {
            // Jika form tidak diubah, navigasikan langsung
            window.location.href = this.href;
        }
    });

  </script>
>>>>>>> 8fcbca0a90afe9395a317b845ac72dde2e131c71
  @endsection
