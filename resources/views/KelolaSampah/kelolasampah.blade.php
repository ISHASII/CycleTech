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
                <li><a href="{{ route('kelola.sampah') }}" class="text-white bg-green-700 rounded-lg hover:bg-old-hulk inline-flex justify-center w-full px-4 py-2">Kelola Sampah</a></li>
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

    <!-- Hero Section -->
    <section class="bg-white py-12 mt-12">
        <div class="container mx-auto flex flex-col md:flex-row items-center justify-center px-32">
            <div class="md:w-1/2 space-y-4 text-center md:text-left">
                <h1 class="text-xl lg:text-4xl font-bold text-gray-800">Kelola Sampahmu!</h1>
                <p class="text-gray-700 text-sm lg:text-xl">Menjadi lebih hijau bukan hanya tren, tetapi juga kebutuhan. Daur ulang lebih mudah dengan layanan kami.</p>
            </div>
            <div class="md:w-1/2 flex justify-center">
                <img src="{{ asset('images/kelolasampah 1.png') }}" alt="Hero Image" class="rounded-lg">
            </div>
        </div>
    </section>

    <!-- Keuntungan -->
    <section class="bg-white py-16 px-24 lg:px-52">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-12">Keuntungan</h2>
            <div class="grid grid-cols-2 gap-2">
                <div class="bg-gradient-to-r from-birumuda to-krem text-right bg-blue-50 p-6 rounded-lg shadow">
                    <h3 class="text-md lg:text-xl font-semibold text-green-600">Sampah Terkelola</h3>
                    <p class="text-gray-700 mt-2 text-sm lg:text-md ">Sampah akan dikelola secara bertanggung jawab dan mengurangi jumlah sampah di TPA</p>
                </div>
                <div class="bg-gradient-to-r from-krem to-birumuda text-left bg-blue-50 p-6 rounded-lg shadow">
                    <h3 class="text-md lg:text-xl font-semibold text-green-600">Bangun Hubungan</h3>
                    <p class="text-gray-700 mt-2 text-sm lg:text-md">Jalin hubungan yang baik dengan Cycle Tech dan mitra lainnya.</p>
                </div>
                <div class="bg-gradient-to-r from-birumuda to-krem text-right bg-blue-50 p-6 rounded-lg shadow">
                    <h3 class="text-md lg:text-xl font-semibold text-green-600">Mudah</h3>
                    <p class="text-gray-700 mt-2 text-sm lg:text-md">Cukup pilah dan bersihkan sampah Anda dan setorkan ke mitra Cycle Tech terdekat.</p>
                </div>
                <div class="bg-gradient-to-r from-krem to-birumuda text-left bg-blue-50 p-6 rounded-lg shadow">
                    <h3 class="text-md lg:text-xl font-semibold text-green-600 ">Sejahterakan Pengelola Sampah</h3>
                    <p class="text-gray-700 mt-2 text-sm lg:text-md">Sampah yang dipilah dengan bijak akan memudahkan pekerjaan pengelola sampah</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Cara Mengirim -->
    <section class="bg-white py-16">
        <div class="container mx-auto text-center px-10">
            <h2 class="text-3xl font-bold text-gray-800 mb-12">Cara Mengirim</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="space-y-4">
                    <i class="bi bi-box-seam text-4xl text-green-600"></i>
                    <h3 class="font-semibold">Pilah dan Kemas</h3>
                    <p>Pilah dan pastikan sampah dalam keadaan bersih dan kering. Kemas sampah dengan baik dan aman.</p>
                </div>
                <div class="space-y-4">
                    <i class="bi bi-truck text-4xl text-green-600"></i>
                    <h3 class="font-semibold">Kirim Sampah</h3>
                    <p>Kirimkan sampah dengan datang langsung ke tempat pengelolaan sampah terdekat.</p>
                </div>
                <div class="space-y-4">
                    <i class="bi bi-recycle text-4xl text-green-600"></i>
                    <h3 class="font-semibold">Sampah Terkelola</h3>
                    <p>Sampah yang telah dikirimkan akan dikelola secara bertanggung jawab oleh tempat pengelola sampah tersebut</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Cara Menyiapkan Sampah -->
   <section class="bg-gradient-to-b from-birumuda to-krem py-16">
    <div class="mx-auto p-8 px-6 md:px-12 lg:px-32">
        <h1 class="text-2xl font-bold text-center mb-6">Cara Menyiapkan Sampah</h1>
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <!-- Left Section -->
            <div class="flex-1 mb-6 md:mb-0 md:mr-4">
                <div class="flex items-start text-right mb-4">
                    <div class="mb-8 mr-8">
                        <h2 class="font-bold">Bersihkan Sampah</h2>
                        <p>Pastikan sampah yang akan disetorkan dalam keadaan bersih untuk menghindari penyebaran kuman dan penyakit.</p>
                    </div>
                    <div class="text-black font-bold text-5xl w-12 h-12 flex items-center justify-center mr-4">
                        1
                    </div>
                </div>
                <div class="flex items-start mb-4 text-right">
                    <div class="mr-8">
                        <h2 class="font-bold">Pastikan Sampah Kering</h2>
                        <p>Sampah yang akan disetorkan harus dalam keadaan kering, tidak basah, maupun lembab.</p>
                    </div>
                    <div class="text-black font-bold text-5xl w-12 h-12 flex items-center justify-center mr-4">
                        2
                    </div>
                </div>
            </div>

            <!-- Center Image (only visible on large screens) -->
            <div class="justify-center mt-6 hidden lg:block">
                <img src="{{ asset('images/kelolasampah 2.png') }}" alt="Ilustrasi persiapan sampah" class="w-48 h-48">
            </div>

            <!-- Right Section -->
            <div class="flex-1 mb-6 md:mb-0 md:ml-4">
                <div class="flex items-end text-left mb-4">
                    <div class="text-black font-bold text-5xl w-12 h-12 flex items-center justify-center mb-8 ml-4">
                        3
                    </div>
                    <div class="ml-8">
                        <h2 class="font-bold">Remas dan Lipat</h2>
                        <p>Remas dan lipat sampah untuk memaksimalkan ruang dan volume paket.</p>
                    </div>
                </div>
                <div class="flex items-end mb-4 text-left">
                    <div class="text-black font-bold text-5xl w-12 h-12 flex items-center justify-center ml-4">
                        4
                    </div>
                    <div class="ml-8">
                        <h2 class="font-bold">Kemas Rapi</h2>
                        <p>Kemas sampah menggunakan kardus atau kemasan lain. Jangan lupa tulis kode SSA pada paket.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Lokasi -->
    <div class="mx-auto bg-white-50 p-6 px-6 md:px-24 lg:px-32 text-center">
        <h1 class="text-2xl font-bold mb-4">Lokasi Pengelola Sampah</h1>
        <p class="mb-4">Lokasi mitra drop point yang bisa Anda jadikan sebagai titik pengiriman sampah</p>
        <div class="flex flex-wrap justify-center items-center gap-2 mb-6">
            <button class="bg-hulk hover:bg-gradient-to-r from-black to-old-hulk text-white px-4 py-2 rounded-3xl" onclick="toggleDetails('jakarta')">Jakarta</button>
        </div>
        <div id="details" class="space-y-4 text-left hidden">
            <div class="border p-4 rounded-lg">
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="w-full md:w-1/3 flex justify-center items-center xl:px-24">
                        <img src="{{ asset('images/kelola apsi.png') }}" class="w-full h-48 object-contain">
                    </div>
                    <div class="w-full md:w-2/3">
                        <h2 class="text-xl font-bold mb-2">Asosiasi Pengusaha Sampah Indonesia (APSI)</h2>
                        <p>APSI merupakan perkumpulan para pengusaha yang bergerak dalam bidang persampahan diantaranya, pengumpul pengolah material daur ulang, operator jasa angkutan sampah, operator jasa pengolahan sampah, operator pengolah sampah residu waste to energy, operator transportasi L3S, konsultan pengelolaan sampah di yang tersebar diseluruh Indonesia.</p>
                    </div>
                </div>
            </div>
            <div class="border p-4 rounded-lg">
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="w-full md:w-1/3 flex justify-center items-center xl:px-24">
                        <img src="{{ asset('images/kelola adupi.png') }}" class="w-full h-48 object-contain">
                    </div>
                    <div class="w-full md:w-2/3">
                        <h2 class="text-xl font-bold mb-2">Asosiasi Daur Ulang Plastik Indonesia (ADUPI)</h2>
                        <p>ADUPI didirikan pada tahun 2015 dan terdaftar sebagai organisasi nirlaba dengan lebih dari 500 anggota, membentuk ekosistem rantai daur ulang plastik terbesar di Indonesia dari hulu ke hilir, seperti kelompok pengumpul plastik, bank sampah, hingga industri daur ulang. Organisasi ini juga melibatkan akademisi dan praktisi aktif daur ulang plastik di Indonesia.</p>
                    </div>
                </div>
            </div>
            <div class="border p-4 rounded-lg">
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="w-full md:w-1/3 flex justify-center items-center xl:px-24">
                        <img src="{{ asset('images/kelola ibcsd.png') }}" class="w-full h-48 object-contain">
                    </div>
                    <div class="w-full md:w-2/3">
                        <h2 class="text-xl font-bold mb-2">Indonesia Business Council for Sustainable Development (IBCSD)</h2>
                        <p>IBCSD (Indonesia Business Council for Sustainable Development) adalah asosiasi perusahaan yang berkomitmen untuk mempromosikan pembangunan berkelanjutan di Indonesia melalui pertumbuhan ekonomi berkelanjutan, keseimbangan lingkungan, dan kemajuan sosial. Diresmikan pada April 2011, IBCSD merupakan mitra global dari WBCSD (World Business Council for Sustainable Development) dan telah mengumpulkan lebih dari 40 perusahaan pada 2022 untuk bersama-sama mendorong inisiatif keberlanjutan di berbagai sektor industri di Indonesia.</p>
                    </div>
                </div>
            </div>
            <div class="border p-4 rounded-lg">
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="w-full md:w-1/3 flex justify-center items-center xl:px-24">
                        <img src="{{ asset('images/kelola repurpose.png') }}" class="w-full h-48 object-contain">
                    </div>
                    <div class="w-full md:w-2/3">
                        <h2 class="text-xl font-bold mb-2">rePurpose Global</h2>
                        <p>rePurpose Global adalah platform aksi plastik terkemuka dunia yang menyatukan merek, konsumen, inovator, dan pembuat kebijakan untuk melawan krisis sampah plastik. Melalui solusi di ekonomi sirkular, rePurpose telah membantu lebih dari 500 perusahaan mengukur dan mengurangi jejak plastik mereka. Hingga kini, rePurpose telah mengelola 30 juta kilogram sampah plastik, memberdayakan masyarakat pesisir di Amerika, Afrika, dan Asia, serta mendukung ribuan pekerja pengelola sampah yang terpinggirkan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function toggleDetails() {
        const details = document.getElementById('details');
        if (details.classList.contains('hidden')) {
            details.classList.remove('hidden');
        } else {
            details.classList.add('hidden');
        }
    }
    </script>


    <!-- Footer -->
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
</body>
</html>
