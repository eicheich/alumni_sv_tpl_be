<footer class="bg-purple-900 text-white py-12">
    <div class="max-w-6xl mx-auto px-6 lg:px-8">
        <div class="grid md:grid-cols-3 gap-8 lg:gap-12">
            <div class="text-center lg:text-left">
                <h3 class="font-semibold text-lg mb-4">Web Alumni TPL</h3>
                <div class="flex justify-center lg:justify-start space-x-4">
                    <a href="#"
                        class="bg-purple-700 hover:bg-purple-600 w-10 h-10 rounded-full flex items-center justify-center transition-colors">
                        <i class="fa-brands fa-twitter text-lg"></i>
                    </a>
                    <a href="#"
                        class="bg-purple-700 hover:bg-purple-600 w-10 h-10 rounded-full flex items-center justify-center transition-colors">
                        <i class="fa-brands fa-instagram text-lg"></i>
                    </a>
                </div>
            </div>


            <div class="text-center lg:text-left">
                <h3 class="font-semibold text-lg mb-4">Tautan</h3>
                <ul class="space-y-3 text-sm">
                    <li><a href="#beranda" class="hover:text-purple-200 transition-colors">Beranda</a></li>
                    <li><a href="{{ route('about.index') }}" class="hover:text-purple-200 transition-colors">Tentang</a>
                    </li>
                    <li><a href="#informasi" class="hover:text-purple-200 transition-colors">Informasi Umum</a></li>
                    <li><a href="{{ route('faq.index') }}" class="hover:text-purple-200 transition-colors">FAQ</a></li>
                </ul>
            </div>
            <div class="text-center lg:text-left">
                <h3 class="font-semibold text-lg mb-4">Alamat & Kontak</h3>
                <div class="text-sm space-y-2">
                    <p class="leading-relaxed">
                        KAMPUS BOGOR<br>
                        Jl. Kumbang No.14, Kelurahan Babakan<br>
                        Kecamatan Bogor Tengah, Kota Bogor<br>
                        Jawa Barat 16128
                    </p>
                    <p class="pt-2">
                        <span class="block font-medium">Telepon: (0251) 8348007</span>
                        <span class="block font-medium">Email: sv@apps.ipb.ac.id</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-purple-700 mt-8 pt-6 text-center">
            <p class="text-sm text-purple-200">
                Copyright © 2025 Web Alumni TPL. All rights reserved.
            </p>
        </div>
    </div>
</footer>
