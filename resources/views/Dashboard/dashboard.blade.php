<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cycle Tech</title>
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="icon" type="image/x-icon" href="/images/logo 2.png">
    @vite('resources/css/app.css')
</head>

<body class="bg-blue-50">
    <nav class="bg-gradient-to-r from-birumuda to-krem shadow-lg fixed top-0 w-full h-18 z-50">
        <div class="container mx-auto flex items-center justify-between py-4 px-6 md:px-10">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/logo 2.png') }}" alt="Logo" class="w-10 h-10 rounded-full">
                <h1 class="text-xl font-semibold text-hulk">Cycle Tech</h1>
            </div>

            <!-- Centered Navigation Links for Desktop -->
            <ul class="hidden lg:flex items-center space-x-6 font-medium text-gray-700">
                <li><a href="{{ route('dashboard.nasabah') }}" class="text-white bg-green-700 rounded-lg hover:bg-old-hulk inline-flex justify-center w-full px-4 py-2">Beranda</a></li>
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


    <!-- Hero Section -->
    <section class="bg-white py-10 mt-16">
        <div class="container mx-auto text-left px-4 flex flex-col text-justify max-w-5xl">
            <img src="{{ asset('images/beranda 1.png') }}" alt="Recycle Bins" class="w-full max-w-5xl mx-auto rounded-lg shadow-lg">
            <p class="text-gray-600 mt-4 mx-auto"><span class="text-3xl font-bold text-gray-800 mt-8"> Cycle Tech </span>hadir untuk membantumu mengubah sampah menjadi sesuatu yang berharga. Kami menyediakan berbagai solusi kreatif untuk mendaur ulang limbah, mengedukasi masyarakat tentang pengelolaan sampah, dan membantu menciptakan lingkungan yang lebih bersih. Bergabunglah dengan kami dalam perjalanan menuju keberlanjutan dan jadilah bagian dari perubahan positif di komunitasmu!</p>
        </div>
    </section>

    <!-- Informasi Fitur Deteksi -->
    <section class="bg-gradient-to-b from-white via-birumuda to-krem py-8 md:py-16">
        <div class="container mx-auto flex flex-col items-center justify-between px-4 md:px-32">
            <div class="text-center mb-6">
                <h2 class="text-2xl md:text-3xl font-bold mb-4">Mau Melatih Kreatifitasmu?</h2>
                <p class="text-md md:text-lg text-gray-600">Ayo deteksi jenis sampahmu dan ubah menjadi barang berguna!</p>
            </div>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('deteksi.sampah') }}" class="border-2 ease-in duration-150 bg-hulk border-hulk text-white py-2 px-8 rounded-3xl hover:bg-gradient-to-r from-black to-old-hulk">Mulai Deteksi!</a>
            </div>
        </div>
    </section>

    <!-- Artikel & Informasi Section -->
    <section class="bg-gradient-to-b from-krem to-white py-16">
        <div class="container mx-auto text-center px-32">
            <h2 class="text-2xl font-bold text-center text-gray-800">Artikel & Informasi</h2>
            <!-- Card Artikel -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mt-8">
                @forelse ($articles as $article)
                    <a href="{{ route('detail.artikel', $article->id) }}" class="block">
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden h-[350px] hover:shadow-xl transition-shadow duration-300">
                            <img src="{{ asset('storage/' . $article->foto) }}" alt="{{ $article->judul_artikel }}" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="font-bold text-gray-700">{{ $article->judul_artikel }}</h3>
                                <p class="text-gray-600 mt-2">{{ Str::limit($article->isi, 70) }}</p>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="text-gray-600">Belum ada artikel tersedia.</p>
                @endforelse
            </div>
        </div>
    </section>

   <!-- Mitra Kami Section -->
   <section class="bg-white py-12">
    <div class="container mx-auto px-6 lg:px-24">
        <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-8">Rekomendasi Pengelola Sampah</h2>
        <div class="grid lg:grid-cols-4 sm:grid-cols-2 gap-8">
            <a href="https://apsiumkmsampah.id/" class="block" target="_blank">
                <div class="bg-white shadow-lg rounded-lg h-[240px] overflow-hidden hover:shadow-2xl border border-grey hover:border-hulk transition-shadow duration-300">
                    <img src="{{ asset('images/apsi.png') }}" alt="APSI" class="w-[240px] h-[133px]">
                    <div class="p-4">
                        <h3 class="font-bold text-gray-700 text-lg">APSI</h3>
                        <p class="text-gray-600 mt-2 text-sm">Asosiasi Pengusaha Sampah Indonesia</p>
                    </div>
                </div>
            </a>
            <a href="https://www.adupi.org/" class="block" target="_blank">
                <div class="bg-white shadow-lg rounded-lg h-[240px] overflow-hidden hover:shadow-2xl border border-grey hover:border-hulk transition-shadow duration-300">
                    <img src="{{ asset('images/adupi.png') }}" alt="ADUPI" class="w-[240px] h-[133px]">
                    <div class="p-4">
                        <h3 class="font-bold text-gray-700 text-lg">ADUPI</h3>
                        <p class="text-gray-600 mt-2 text-sm">Asosiasi Daur Ulang Plastik Indonesia</p>
                    </div>
                </div>
            </a>
            <a href="https://ibcsd.or.id/" class="block" target="_blank">
                <div class="bg-white shadow-lg rounded-lg h-[240px] overflow-hidden hover:shadow-2xl border border-grey hover:border-hulk transition-shadow duration-300">
                    <img src="{{ asset('images/ibcsd.png') }}" alt="IBCS" class="w-[240px] h-[133px]">
                    <div class="p-4">
                        <h3 class="font-bold text-gray-700 text-lg">IBCSD</h3>
                        <p class="text-gray-600 mt-2 text-sm">Indonesia Business Council for Sustainable Development</p>
                    </div>
                </div>
            </a>
            <a href="https://repurpose.global/" class="block" target="_blank">
                <div class="bg-white shadow-lg rounded-lg h-[240px] overflow-hidden hover:shadow-2xl border border-grey hover:border-hulk transition-shadow duration-300">
                    <img src="{{ asset('images/repurpose.png') }}" alt="Repurpose" class="w-[240px] h-[133px]">
                    <div class="p-4">
                        <h3 class="font-bold text-gray-700 text-lg">RePurpose Global</h3>
                        <p class="text-gray-600 mt-2 text-sm">Global Plastic Action Platform </p>
                    </div>
                </div>
            </a>
        </div>
        </div>
    </section>


    <!-- Footer -->
    <section>
        <footer class="bg-gradient-to-t from-birumuda to-krem py-10">
            <div class="container mx-auto flex flex-col md:flex-row justify-between items-center md:px-32 px-24">
                <div class="md:w-1/3 mb-6 md:mb-0">
                    <div class="flex items-center">
                        <img src="{{ asset('images/logo 2.png') }}" alt="Cycle Tech Logo" class="w-10 h-10 mr-3">
                        <h2 class="text-lg font-bold text-hulk">Cycle Tech</h2>
                    </div>
                    <p class="mt-4 text-sm hidden md:block">
                        Cycle Tech adalah platform inovatif untuk pengelolaan sampah. Dengan fitur-fitur canggih, kami memudahkan Anda untuk memilah, mengelola, dan mendaur ulang sampah secara efektif.
                    </p>
                </div>
                <div class="md:w-1/3 mb-6 md:mb-0 text-center">
                    <h3 class="text-lg font-semibold mb-2">Hubungi</h3>
                    <p class="text-sm">+62 812 3456 7890</p>
                    <p class="text-sm">cycletech@gmail.com</p>
                </div>
                <div class="md:w-1/3 text-center md:text-right">
                    <h3 class="text-lg font-semibold mb-2">Media Sosial</h3>
                    <div class="flex justify-center md:justify-end space-x-4">
                        <a href="#" class="text-black hover:text-gray-400">
                            <i class="bi bi-facebook w-6 h-6"></i>
                        </a>
                        <a href="#" class="text-black hover:text-gray-400">
                            <i class="bi bi-twitter w-6 h-6"></i>
                        </a>
                        <a href="#" class="text-black hover:text-gray-400">
                            <i class="bi bi-instagram w-6 h-6"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="text-center mt-8">
                <p class="text-sm">© 2024 CycleTech. All Rights Reserved.</p>
            </div>
        </footer>
        </section>
</body>
</html>
