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
                <li><a href="{{ route('tentang.kami') }}" class="text-white bg-green-700 rounded-lg hover:bg-old-hulk inline-flex justify-center w-full px-4 py-2">Tentang Kami</a></li>
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
    <div class="relative bg-gray-50 py-10 px-6 md:px-10">
        <div class="relative md:bg-[url('/public/images/tentangkami.png')] bg-no-repeat bg-cover bg-center h-[400px] rounded-lg lg:overflow-show">
            <div class="absolute top-24 left-4 md:top-44 md:left-6 bg-white bg-opacity-100 rounded-lg p-6 max-w-full w-[412px]">
                <div class="bg-white-200 flex items-center">
                    <img src="{{ asset('images/logo 2.png') }}" alt="Logo" class="w-12 h-12 rounded-full mr-4">
                    <h2 class="text-2xl font-bold text-hulk">Cycle Tech</h2>
                </div>
                <p class="mt-4 text-gray-600">
                    Cycle Tech adalah platform inovatif untuk pengelolaan sampah yang cerdas dan berkelanjutan. Dengan fitur-fitur canggih, kami membantu Anda memilah, mengelola, dan mendaur ulang sampah dengan lebih mudah dan efektif, sambil berkontribusi pada lingkungan yang lebih bersih.
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto text-justify text-gray-700 lg:px-10 md:px-12 md:mt-10 px-16 mb-10">
        <p class="text-lg leading-relaxed">
            Cycle Tech adalah solusi cerdas untuk pengelolaan sampah Anda. Kami menyediakan platform lengkap yang tidak hanya mengedukasi, tetapi juga menginspirasi pengelolaan sampah secara kreatif. Dengan fitur deteksi jenis sampah otomatis, Anda dapat mengunggah gambar sampah dan mendapatkan rekomendasi kreasi menarik yang dapat dibuat dari limbah tersebut.
        </p>
        <p class="mt-4 text-lg leading-relaxed">
            Selain itu, kami juga menghadirkan galeri inspirasi daur ulang untuk membantu Anda mengubah sampah menjadi barang bernilai guna, serta artikel terkini yang membahas isu-isu penting seputar pengelolaan dan teknologi daur ulang. Cycle Tech hadir untuk mempermudah pengelolaan sampah Anda sekaligus berkontribusi pada lingkungan yang lebih bersih dan berkelanjutan.
        </p>
  </div>


    <!-- Visi dan Misi -->
    <section class="bg-gradient-to-t from-krem to-birumuda py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Visi dan Misi</h2>
            <div class="flex flex-col items-center space-y-8 md:space-y-0 justify-center">
                <div class="flex flex-col items-center">
                    <h3 class="text-2xl font-semibold text-hulk mb-4">Visi Kami</h3>
                    <p class="text-gray-700 text-justify w-full max-w-4xl">Menjadi platform digital terdepan yang menginspirasi dan memberdayakan masyarakat untuk mengelola sampah secara kreatif dan inovatif, demi menciptakan lingkungan yang bersih, sehat, dan berkelanjutan.</p>
                </div>
                <div class="flex flex-col items-center">
                    <h3 class="text-2xl font-semibold text-hulk mb-4 mt-4">Misi Kami</h3>
                    <ul class="text-gray-700 space-y-2 list-decimal w-full max-w-4xl text-left">
                        <li>Meningkatkan kesadaran dan edukasi masyarakat tentang pentingnya pengelolaan sampah yang ramah lingkungan dan berkelanjutan.</li>
                        <li>Mengembangkan fitur-fitur inovatif yang mendukung daur ulang dan pemanfaatan kembali sampah dengan cara yang kreatif.</li>
                        <li>Memberikan informasi terkini tentang manfaat, peluang, dan nilai ekonomi dari pengelolaan sampah yang baik.</li>
                        <li>Mendorong partisipasi aktif masyarakat dalam pengelolaan sampah melalui platform yang inklusif dan mudah diakses.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>


    <!-- Section: Tim Kami -->
    <section class="bg-white py-10">
        <div class="container mx-auto text-center px-6 md:px-32">
            <h2 class="text-3xl font-bold text-gray-800">Tentang Tim Kami</h2>
            <p class="text-gray-600 mt-4">Berikut adalah tim hebat yang bekerja di balik layar Cycle Tech.</p>
            <div class="grid grid-cols-2 lg:grid-cols-5 gap-8 mt-12">
                <a href="http://www.linkedin.com/in/salma-salsabila-568243269" target="_blank">
                <div class="flex flex-col items-center h-[300px] bg-gradient-to-b from-krem to-birumuda border-none shadow-lg p-3 rounded hover:shadow-2xl">
                    <img src="{{ asset('images/salma.png') }}" alt="Member" class="w-36 h-36 rounded-lg object-cover">
                    <h3 class="mt-4 text-xl font-semibold text-gray-800">Salma Salsabila</h3>
                    <p class="text-gray-600">Product Manager</p>
                    <p class="text-gray-600 font-semibold">Universitas Singaperbangsa Karawang</p>
                </div>
                </a>
                <a href="https://www.linkedin.com/in/mutiazahrausma/">
                <div class="flex flex-col items-center h-[300px] bg-gradient-to-b from-krem to-birumuda border-none shadow-lg p-3 rounded hover:shadow-2xl">
                    <img src="{{ asset('images/mutia.png') }}" alt="Member" class="w-36 h-36 rounded-lg object-cover">
                    <h3 class="mt-4 text-xl font-semibold text-gray-800">Mutia Zahra Usma</h3>
                    <p class="text-gray-600">UI/UX Designer</p>
                    <p class="text-gray-600 font-semibold">UPN "Veteran" Jakarta</p>
                </div>
                </a>
                <a href="https://www.linkedin.com/in/harrybonardo" target="_blank">
                <div class="flex flex-col items-center h-[300px] bg-gradient-to-b from-krem to-birumuda border-none shadow-lg p-3 rounded hover:shadow-2xl">
                    <img src="{{ asset('images/harry.png') }}" alt="Member" class="w-36 h-36 rounded-lg object-cover">
                    <h3 class="mt-4 text-xl font-semibold text-gray-800">Harry Bonardo</h3>
                    <p class="text-gray-600">UI/UX Designer</p>
                    <p class="text-gray-600 font-semibold">Universitas Lampung</p>
                </div>
                </a>
                <a href="https://www.linkedin.com/in/ivan-herdianto/" target="_blank">
                <div class="flex flex-col items-center h-[300px] bg-gradient-to-b from-krem to-birumuda border-none shadow-lg p-3 rounded hover:shadow-2xl">
                    <img src="{{ asset('images/ivan.png') }}" alt="Member" class="w-36 h-36 rounded-lg object-cover">
                    <h3 class="mt-4 text-xl font-semibold text-gray-800">Ivan Herdianto</h3>
                    <p class="text-gray-600">Front-End Developer</p>
                    <p class="text-gray-600 font-semibold">UPN "Veteran" Jawa Timur</p>
                </div>
                </a>
                <a href="https://www.linkedin.com/in/aprinia-salsabila/" target="_blank">
                <div class="flex flex-col items-center h-[300px] bg-gradient-to-b from-krem to-birumuda border-none shadow-lg p-3 rounded hover:shadow-2xl">
                    <img src="{{ asset('images/aprin.png') }}" alt="Member" class="w-36 h-36 rounded-lg object-cover">
                    <h3 class="mt-4 text-xl font-semibold text-gray-800">Aprinia Salsabila</h3>
                    <p class="text-gray-600">Front-End Developer</p>
                    <p class="text-gray-600 font-semibold">UPN "Veteran" Jawa Timur</p>
                </div>
                </a>
                <a href="https://www.linkedin.com/in/ilham-saputra26" target="_blank">
                <div class="flex flex-col items-center h-[300px] bg-gradient-to-b from-krem to-birumuda border-none shadow-lg p-3 rounded hover:shadow-2xl">
                    <img src="{{ asset('images/ilham.png') }}" alt="Member" class="w-36 h-36 rounded-lg object-cover">
                    <h3 class="mt-4 text-xl font-semibold text-gray-800">Ilham Saputra</h3>
                    <p class="text-gray-600">Back-End Developer</p>
                    <p class="text-gray-600 font-semibold">Universitas Singaperbangsa Karawang</p>
                </div>
                </a>
                <a href="https://www.linkedin.com/in/anggitaardilianzfaticha" target="_blank">
                <div class="flex flex-col items-center h-[300px] bg-gradient-to-b from-krem to-birumuda border-none shadow-lg p-3 rounded hover:shadow-2xl">
                    <img src="{{ asset('images/anggita.png') }}" alt="Member" class="w-36 h-36 rounded-lg object-cover">
                    <h3 class="mt-4 text-xl font-semibold text-gray-800">Anggita Ardilianz</h3>
                    <p class="text-gray-600">Back-End Developer</p>
                    <p class="text-gray-600 font-semibold">Institut Teknologi dan Bisnis PalComTech </p>
                </div>
                </a>
                <a href="https://www.linkedin.com/in/rizmaagustin" target="_blank">
                <div class="flex flex-col items-center h-[300px] bg-gradient-to-b from-krem to-birumuda border-none shadow-lg p-3 rounded hover:shadow-2xl">
                    <img src="{{ asset('images/rizma.png') }}" alt="Member" class="w-36 h-36 rounded-lg object-cover">
                    <h3 class="mt-4 text-xl font-semibold text-gray-800">Rizma Agustin</h3>
                    <p class="text-gray-600">Back-End Developer</p>
                    <p class="text-gray-600 font-semibold">Universitas Nusantara PGRI Kediri</p>
                </div>
                </a>
                <a href="https://id.linkedin.com/in/velizhasandy" target="_blank">
                <div class="flex flex-col items-center h-[300px] bg-gradient-to-b from-krem to-birumuda border-none shadow-lg p-3 rounded hover:shadow-2xl">
                    <img src="{{ asset('images/velizha.png') }}" alt="Member" class="w-36 h-36 rounded-lg object-cover">
                    <h3 class="mt-4 text-xl font-semibold text-gray-800">Velizha Sandy Kusuma</h3>
                    <p class="text-gray-600">Data Analyst</p>
                    <p class="text-gray-600 font-semibold">Universitas Amikom Purwokerto</p>
                </div>
                </a>
                <a href="https://id.linkedin.com/in/muhammad-danu-erlangga" target="_blank">
                <div class="flex flex-col items-center h-[300px] bg-gradient-to-b from-krem to-birumuda border-none shadow-lg p-3 rounded hover:shadow-2xl">
                    <img src="{{ asset('images/danu.png') }}" alt="Member" class="w-36 h-36 rounded-lg object-cover">
                    <h3 class="mt-4 text-xl font-semibold text-gray-800">Muhammad Danu</h3>
                    <p class="text-gray-600">Data Analyst</p>
                    <p class="text-gray-600 font-semibold">Universitas Negeri Surabaya</p>
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
