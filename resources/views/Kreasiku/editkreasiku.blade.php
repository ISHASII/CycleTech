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
    @vite('resources/css/app.css')
    <link rel="icon" type="image/x-icon" href="/images/logo 2.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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
    <section class="max-w-4xl mx-auto mt-20 p-8 bg-white rounded-lg shadow-lg">
        <header class="mb-6">
            <h1 class="text-3xl font-semibold text-gray-800 mb-2">Edit Kreasimu</h1>
            <p class="text-gray-600">
                Tunjukkan kreativitasmu! Unggah karya daur ulangmu dan bergabunglah dengan para pencinta lingkungan lainnya.
            </p>
        </header>

        <!-- Form Update -->
        <form action="{{ route('kreasi.update', $kreasi->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Gambar Kreasi -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2" for="fileToUpload">Gambar Kreasi</label>
                <div class="border-2 border-dashed border-hulk rounded-lg h-64 flex items-center justify-center mb-6">
                    @if ($kreasi->foto_kreasi)
                        <img src="{{ asset('storage/' . $kreasi->foto_kreasi) }}" alt="Foto Kreasi" class="object-cover w-24 h-24 rounded-lg">
                    @else
                        <div class="text-gray-500 flex flex-col items-center">
                            <i class="bi bi-image text-3xl"></i>
                            <span>Preview Gambar</span>
                        </div>
                    @endif
                </div>
                <input type="file" name="fileToUpload" id="fileToUpload" class="mt-4 block w-full border-2 border-hulk focus:outline-none focus:ring-2 focus:ring-old-hulk rounded-md p-3">
            </div>

            <!-- Judul Kreasi dan Nama Penulis -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="judul" class="block text-sm font-medium text-gray-700">Judul Kreasi</label>
                    <input type="text" name="judul" id="judul" value="{{ $kreasi->judul_kreasi }}" required class="w-full border-2 border-hulk focus:outline-none focus:ring-2 focus:ring-old-hulk rounded-md p-3">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Penulis</label>
                    <input type="text" value="{{ auth('nasabah')->user()->name }}" disabled class="w-full border-2 border-hulk focus:outline-none focus:ring-2 focus:ring-old-hulk rounded-md p-3 cursor-not-allowed">
                </div>
            </div>

            <!-- Kategori dan Tanggal -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                    <input type="text" name="kategori" id="kategori" value="{{ $kreasi->kategori_kreasi }}" required class="w-full border-2 border-hulk focus:outline-none focus:ring-2 focus:ring-old-hulk rounded-md p-3">
                </div>

                <div>
                    <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ $kreasi->tanggal }}" required class="w-full border-2 border-hulk focus:outline-none focus:ring-2 focus:ring-old-hulk rounded-md p-3">
                </div>
            </div>

            <!-- Alat dan Bahan -->
            <div>
                <label for="alat_bahan" class="block text-sm font-medium text-gray-700">Alat dan Bahan</label>
                <textarea name="alat_bahan" id="alat_bahan" rows="5" required class="w-full border-2 border-hulk focus:outline-none focus:ring-2 focus:ring-old-hulk rounded-md p-3">{{ $kreasi->alat_bahan }}</textarea>
            </div>

            <!-- Langkah-langkah -->
            <div>
                <label for="langkah" class="block text-sm font-medium text-gray-700">Langkah-langkah</label>
                <textarea name="langkah" id="langkah" rows="5" required class="w-full border-2 border-hulk focus:outline-none focus:ring-2 focus:ring-old-hulk rounded-md p-3">{{ $kreasi->langkah }}</textarea>
            </div>

            <!-- Tombol Perbarui -->
            <div class="flex justify-end items-end">
                <button type="submit" class="w-[150px] bg-hulk text-white py-2 px-6 rounded-lg hover:bg-old-hulk focus:ring-2 focus:ring-green-400">
                    Perbarui
                </button>    
            </div>
        </form>
        <div class="flex justify-end items-end">
            <form action="{{ route('kreasi.destroy', $kreasi->id) }}" method="POST" class="mt-4" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kreasi ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-[150px] bg-white text-red-500 py-2 px-6 rounded-lg border-2 border-red-500 hover:text-white hover:bg-red-600 focus:ring-red-400">
                    Hapus
                </button>
            </form> 
        </div> 
    </section>


    <script>
        function openModal() {
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        function handleDelete(event) {
            event.preventDefault(); // Prevent form submission to handle redirection manually

            // Simulate successful deletion (replace with an actual AJAX request if needed)
            setTimeout(() => {
                // Redirect to the "Kreasiku" page after deletion
                window.location.href = "{{ route('kreasiku') }}";
            }, 500); // Simulated delay for UX
        }
    </script>

    <script>
            const dropdownButton = document.getElementById('dropdownButton');
            const dropdownMenu = document.getElementById('dropdownMenu');

            dropdownButton.addEventListener('click', () => {
                dropdownMenu.classList.toggle('hidden');
            });

            document.addEventListener('click', (e) => {
                if (!e.target.closest('#dropdownButton') && !e.target.closest('#dropdownMenu')) {
                dropdownMenu.classList.add('hidden');
                }
            });

            function previewImage(event) {
                const preview = document.getElementById('previewImage');
                const file = event.target.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                    };

                    reader.readAsDataURL(file);
                }
            }
    </script>
@endsection
