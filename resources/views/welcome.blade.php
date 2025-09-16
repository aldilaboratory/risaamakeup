<x-user.layout>
    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="hero-content">
                        <h1>Jasa MUA Favoritmu</h1>
                        <p>Sedang cari Jasa MUA / Professional Makeup Artis terdekat? Buat kalian yang mencari MUA di Denpasar dan Karangasem, bisa konsultasi dan booking layanan Makeup Artis di Risaa Makeup. Tersedia layanan Jasa Makeup Artist untuk acara Engagement, Prewedding, Wedding, Photoshoot, Wisuda, Sweet Seventeen dan acara lainnya.</p>
                        <a href="#pricing" class="btn btn-primary-pink btn-lg text-white">Lihat Paket</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="services" class="py-5">
        <div class="container">
            <h2 class="section-title">Layanan Risaa Makeup</h2>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-palette"></i>
                        </div>
                        <h4>Makeup Profesional</h4>
                        <p>Rias wajah oleh ahli menggunakan produk berkualitas untuk hasil yang sempurna dan tahan lama.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h4>Spesialis Pengantin</h4>
                        <p>Rias pengantin khusus dengan sesi uji coba untuk memastikan tampilan sempurna di hari pernikahan kamu.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-camera"></i>
                        </div>
                        <h4>Siap Pemotretan</h4>
                        <p>Makeup yang terlihat menawan baik secara langsung maupun di depan kamera, ideal untuk sesi foto.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h4>Waktu Fleksibel</h4>
                        <p>Tersedia untuk sesi pagi hari atau jadwal acara khusus sesuai kebutuhan Anda.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-home"></i>
                        </div>
                        <h4>Layanan ke Lokasi</h4>
                        <p>Kami datang ke tempatmu! Layanan makeup profesional di rumah, hotel, atau lokasi acara.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <h4>Produk Premium</h4>
                        <p>Hanya menggunakan merek dan produk makeup terbaik untuk kualitas dan hasil akhir yang istimewa.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    {{-- <section id="about" class="about-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1926&q=80" alt="About Us" class="img-fluid rounded-3">
                </div>
                <div class="col-lg-6">
                    <h2 class="section-title text-start">About Us</h2>
                    <p class="lead">With over 8 years of experience in the beauty industry, Risa Makeup Artist has been transforming faces and boosting confidence for countless clients.</p>
                    <p>We specialize in creating personalized makeup looks that enhance your natural beauty while ensuring you feel comfortable and confident. Our expertise spans from subtle everyday looks to glamorous special occasion makeup.</p>
                    <p>Every client receives a personalized consultation to understand their style preferences, skin type, and the occasion, ensuring a perfect result every time.</p>
                    <a href="#contact" class="btn btn-primary-pink">Learn More</a>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Pricing Section -->
    @include('packages.index', ['categories' => $categories, 'order' => $order])

    <!-- Gallery Section -->
    <section id="gallery" class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title">Gallery</h2>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="gallery-item">
                        <img src="https://images.unsplash.com/photo-1487412947147-5cebf100ffc2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1971&q=80" alt="Bridal Makeup">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="gallery-item">
                        <img src="https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2069&q=80" alt="Evening Makeup">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="gallery-item">
                        <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1926&q=80" alt="Natural Look">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="gallery-item">
                        <img src="https://images.unsplash.com/photo-1516975080664-ed2fc6a32937?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Glamour Makeup">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="gallery-item">
                        <img src="https://images.unsplash.com/photo-1594736797933-d0401ba2fe65?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1974&q=80" alt="Special Event">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="gallery-item">
                        <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Professional Makeup">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title">Testimoni</h2>
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="testimonial-card">
                        <p>"Risa made me feel absolutely stunning on my wedding day. The makeup was flawless and lasted throughout the entire celebration!"</p>
                        <h5>Sarah Johnson</h5>
                        <small class="text-muted">Bride 2024</small>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="testimonial-card">
                        <p>"Professional, talented, and so easy to work with. Risa understood exactly what I wanted and delivered beyond my expectations."</p>
                        <h5>Emily Chen</h5>
                        <small class="text-muted">Bride 2023</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5">
        <div class="container">
            <h2 class="section-title">Kontak Whatsapp</h2>
            <p class="text-center">Jangan sungkan untuk hubungi kami apabila ingin berkonsultasi terlebih dahulu.</p>

            <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                <a
                    href="https://wa.me/6281234567890?text=Halo%20Risaa%20Makeup%2C%20saya%20ingin%20konsultasi%20tentang%20paket%20makeup.%20Tanggal%3A%20_____%20Lokasi%3A%20_____"
                    class="btn btn-success btn-lg px-4 shadow-sm"
                    target="_blank"
                    rel="noopener"
                >
                    <i class="fab fa-whatsapp me-2"></i> Chat via WhatsApp
                </a>
                </div>
            </div>
            </div>
        </div>
    </section>

</x-user>