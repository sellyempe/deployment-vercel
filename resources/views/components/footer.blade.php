<footer class="py-12 border-t border-white/5" style="background-color: #132440 !important; color: #ffffff !important;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            <div>
                <h3 class="text-lg font-bold mb-4" style="color: #ffffff !important;">{{ get_setting('site_name', 'Pink Tour and Travel') }}</h3>
                <p class="text-sm leading-relaxed" style="color: rgba(255, 255, 255, 0.7) !important;">
                    {{ get_setting('site_description', 'Jelajahi destinasi impian Anda bersama kami dengan paket wisata terpercaya dan berpengalaman.') }}
                </p>
            </div>

            <div>
                <h4 class="font-bold mb-4" style="color: #ffffff !important;">Menu</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="/" class="hover:text-pink-400 transition font-medium" style="color: rgba(255, 255, 255, 0.7) !important;">Beranda</a></li>
                    <li><a href="#destinasi" class="hover:text-pink-400 transition font-medium" style="color: rgba(255, 255, 255, 0.7) !important;">Destinasi</a></li>
                    <li><a href="#paket" class="hover:text-pink-400 transition font-medium" style="color: rgba(255, 255, 255, 0.7) !important;">Paket Wisata</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold mb-4" style="color: #ffffff !important;">Informasi</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-pink-400 transition font-medium" style="color: rgba(255, 255, 255, 0.7) !important;">Tentang Kami</a></li>
                    <li><a href="#" class="hover:text-pink-400 transition font-medium" style="color: rgba(255, 255, 255, 0.7) !important;">Syarat & Ketentuan</a></li>
                    <li><a href="#" class="hover:text-pink-400 transition font-medium" style="color: rgba(255, 255, 255, 0.7) !important;">Kebijakan Privasi</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold mb-4" style="color: #ffffff !important;">Hubungi Kami</h4>
                <ul class="space-y-2 text-sm">
                    <li>
                        <a href="mailto:{{ get_setting('contact_email', 'pinktourandtravel@gmail.com') }}"
                            class="hover:text-pink-400 transition font-medium" style="color: rgba(255, 255, 255, 0.7) !important;">{{ get_setting('contact_email', 'pinktourandtravel@gmail.com') }}</a>
                    </li>
                    <li>
                        <a href="tel:{{ str_replace(' ', '', get_setting('contact_phone', '+62 852 9821 0193')) }}" class="hover:text-pink-400 transition font-medium" style="color: rgba(255, 255, 255, 0.7) !important;">{{ get_setting('contact_phone', '+62 852 9821 0193') }}</a>
                    </li>
                    <li class="font-medium" style="color: rgba(255, 255, 255, 0.7) !important;">
                        {{ get_setting('contact_address', 'Makassar, Indonesia') }}
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-white/5 pt-8">
            <p class="text-sm text-center font-medium" style="color: rgba(255, 255, 255, 0.5) !important;">
                © {{ date('Y') }} {{ get_setting('site_name', 'Pink Tour and Travel') }}. Semua hak dilindungi.
            </p>
        </div>
    </div>
</footer>