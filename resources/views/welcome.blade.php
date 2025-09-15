<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Risaa Makeup Artist</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-pink: #ff6b9d;
            --secondary-pink: #ffc0cb;
            --light-pink: #ffe4e6;
            --dark-pink: #e91e63;
            --text-dark: #2c3e50;
            --text-light: #6c757d;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
        }

        .hero-section {
            background: linear-gradient(rgba(255, 107, 157, 0.8), rgba(255, 192, 203, 0.8)), 
                        url('https://cdn.pixabay.com/photo/2020/01/05/20/04/mouth-4743981_1280.jpg');
            background-size: cover;
            background-position: center;
            min-height: 75vh;
            display: flex;
            align-items: center;
            color: white;
            position: relative;
        }

        .hero-content h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .hero-content p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }

        .btn-primary-pink {
            background: var(--primary-pink);
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .btn-primary-pink:hover {
            background: var(--dark-pink);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 157, 0.3);
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 3rem;
            text-align: center;
        }

        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: none;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(255, 107, 157, 0.2);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-pink), var(--secondary-pink));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 2rem;
        }

        .about-section {
            background: var(--light-pink);
            padding: 80px 0;
        }

        .pricing-card {
            background: white;
            border-radius: 15px;
            padding: 2.5rem 2rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .pricing-card.featured {
            border: 3px solid var(--primary-pink);
            transform: scale(1.05);
        }

        .pricing-card.featured::before {
            content: 'MOST POPULAR';
            position: absolute;
            top: 20px;
            right: -30px;
            background: var(--primary-pink);
            color: white;
            padding: 5px 40px;
            font-size: 0.8rem;
            font-weight: 600;
            transform: rotate(45deg);
        }

        .price {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary-pink);
            margin: 1rem 0;
        }

        .gallery-item {
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }

        .gallery-item:hover {
            transform: scale(1.05);
        }

        .gallery-item img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .blog-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .blog-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .blog-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .testimonial-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .testimonial-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 1rem;
            border: 4px solid var(--secondary-pink);
        }

        .contact-form {
            background: white;
            border-radius: 15px;
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-pink);
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 157, 0.25);
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-pink) !important;
        }

        .nav-link {
            color: var(--text-white) !important;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-white) !important;
        }

        .navbar-actions {
            display: flex;
            align-items: center;
        }

        .nav-action-btn {
            background: var(--primary-pink);
            color: white !important;
            padding: 8px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .nav-action-btn:hover {
            background: var(--dark-pink);
            color: white !important;
            transform: translateY(-1px);
        }

        .nav-icon-btn {
            color: var(--text-dark) !important;
            font-size: 1.2rem;
            text-decoration: none;
            position: relative;
            padding: 8px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .nav-icon-btn:hover {
            color: var(--primary-pink) !important;
            background: rgba(255, 107, 157, 0.1);
        }

        .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
            color: white;
            background-color: var(--primary-pink);
        }

        .cart-count {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--primary-pink);
            color: white;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 2px 6px;
            border-radius: 50%;
            min-width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 991px) {
            .navbar-actions {
                margin-top: 1rem;
                justify-content: center;
            }
            
            .nav-action-btn {
                margin-bottom: 0.5rem;
            }
        }

        footer {
            background: var(--text-dark);
            color: white;
            padding: 3rem 0 1rem;
        }

        .social-links a {
            display: inline-block;
            width: 40px;
            height: 40px;
            background: var(--primary-pink);
            color: white;
            text-align: center;
            line-height: 40px;
            border-radius: 50%;
            margin: 0 5px;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: var(--dark-pink);
            transform: translateY(-3px);
        }

        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.5rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .pricing-card.featured {
                transform: none;
                margin-top: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#home">Risaa Makeup</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Beranda</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pricing">Package</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#gallery">Galeri</a>
                    </li>
                </ul>
                <div class="navbar-actions">
                    <a href="#" class="nav-icon-btn me-2" title="Shopping Cart">
                        <i class="fas fa-shopping-bag"></i>
                        <span class="cart-count">0</span>
                    </a>
                    <a href="#" class="nav-icon-btn" title="User Profile">
                        <i class="fas fa-user"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>

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
    <section id="pricing" class="py-5">
  <div class="container">
    <h2 class="section-title text-center mb-4">Package Terbaik Dengan Harga Terbaik</h2>

    <!-- Tabs -->
    <ul class="nav nav-pills justify-content-center mb-4" id="pricingTabs" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link text-white active" id="akad-tab" data-bs-toggle="tab" data-bs-target="#akad" type="button" role="tab" aria-controls="akad" aria-selected="true">
          Akad
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link text-white" id="wedding-tab" data-bs-toggle="tab" data-bs-target="#wedding" type="button" role="tab" aria-controls="wedding" aria-selected="true">
          Wedding
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link text-white" id="prewedding-tab" data-bs-toggle="tab" data-bs-target="#prewedding" type="button" role="tab" aria-controls="prewedding" aria-selected="false">
          Pre-wedding
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link text-white" id="engagement-tab" data-bs-toggle="tab" data-bs-target="#engagement" type="button" role="tab" aria-controls="engagement" aria-selected="false">
          Engagement
        </button>
      </li>
    </ul>

    <div class="tab-content" id="pricingTabsContent">
      <!-- AKAD -->
      <div class="tab-pane fade show active" id="akad" role="tabpanel" aria-labelledby="akad-tab" tabindex="0">
        <div class="row g-4">
          <div class="col-lg-4">
            <div class="pricing-card">
              <h3>Silver Package</h3>
              <div class="price">Rp250.000</div>
              <hr>
              <ul class="list-unstyled">
                <li><i class="fas fa-check text-success me-2"></i>Bridal makeup & light hair styling</li>
                <li><i class="fas fa-check text-success me-2"></i>1.5 Hour Session</li>
                <li><i class="fas fa-check text-success me-2"></i>Basic touch-ups</li>
                <li><i class="fas fa-check text-success me-2"></i>Consultation included</li>
              </ul>
              <a href="#contact" class="btn btn-primary-pink text-white">Pilih Package</a>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="pricing-card featured">
              <h3>Gold Package</h3>
              <div class="price">Rp400.000</div>
              <hr>
              <ul class="list-unstyled">
                <li><i class="fas fa-check text-success me-2"></i>Full bridal makeup + hair styling</li>
                <li><i class="fas fa-check text-success me-2"></i>2.5 Hour Session</li>
                <li><i class="fas fa-check text-success me-2"></i>Touch-up kit + veil setup</li>
                <li><i class="fas fa-check text-success me-2"></i>Photo ready finish</li>
              </ul>
              <a href="#contact" class="btn btn-primary-pink text-white">Pilih Package</a>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="pricing-card">
              <h3>Platinum Package</h3>
              <div class="price">Rp600.000</div>
              <hr>
              <ul class="list-unstyled">
                <li><i class="fas fa-check text-success me-2"></i>Trial session</li>
                <li><i class="fas fa-check text-success me-2"></i>Wedding day makeup & hair</li>
                <li><i class="fas fa-check text-success me-2"></i>On-site touch-ups (up to 3 hrs)</li>
                <li><i class="fas fa-check text-success me-2"></i>Bridal party discount</li>
              </ul>
              <a href="#contact" class="btn btn-primary-pink text-white">Pilih Package</a>
            </div>
          </div>
        </div>
      </div>

      <!-- WEDDING -->
      <div class="tab-pane fade" id="wedding" role="tabpanel" aria-labelledby="wedding-tab" tabindex="0">
        <div class="row g-4">
          <div class="col-lg-4">
            <div class="pricing-card">
              <h3>Silver Package</h3>
              <div class="price">Rp250.000</div>
              <hr>
              <ul class="list-unstyled">
                <li><i class="fas fa-check text-success me-2"></i>Bridal makeup & light hair styling</li>
                <li><i class="fas fa-check text-success me-2"></i>1.5 Hour Session</li>
                <li><i class="fas fa-check text-success me-2"></i>Basic touch-ups</li>
                <li><i class="fas fa-check text-success me-2"></i>Consultation included</li>
              </ul>
              <a href="#contact" class="btn btn-primary-pink text-white">Pilih Package</a>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="pricing-card featured">
              <h3>Gold Package</h3>
              <div class="price">Rp400.000</div>
              <hr>
              <ul class="list-unstyled">
                <li><i class="fas fa-check text-success me-2"></i>Full bridal makeup + hair styling</li>
                <li><i class="fas fa-check text-success me-2"></i>2.5 Hour Session</li>
                <li><i class="fas fa-check text-success me-2"></i>Touch-up kit + veil setup</li>
                <li><i class="fas fa-check text-success me-2"></i>Photo ready finish</li>
              </ul>
              <a href="#contact" class="btn btn-primary-pink text-white">Pilih Package</a>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="pricing-card">
              <h3>Platinum Package</h3>
              <div class="price">Rp600.000</div>
              <hr>
              <ul class="list-unstyled">
                <li><i class="fas fa-check text-success me-2"></i>Trial session</li>
                <li><i class="fas fa-check text-success me-2"></i>Wedding day makeup & hair</li>
                <li><i class="fas fa-check text-success me-2"></i>On-site touch-ups (up to 3 hrs)</li>
                <li><i class="fas fa-check text-success me-2"></i>Bridal party discount</li>
              </ul>
              <a href="#contact" class="btn btn-primary-pink text-white">Pilih Package</a>
            </div>
          </div>
        </div>
      </div>

      <!-- ENGAGEMENT -->
      <div class="tab-pane fade" id="engagement" role="tabpanel" aria-labelledby="engagement-tab" tabindex="0">
        <div class="row g-4">
          <div class="col-lg-4">
            <div class="pricing-card">
              <h3>Silver Package</h3>
              <div class="price">Rp120.000</div>
              <hr>
              <ul class="list-unstyled">
                <li><i class="fas fa-check text-success me-2"></i>Natural makeup</li>
                <li><i class="fas fa-check text-success me-2"></i>1 Hour Session</li>
                <li><i class="fas fa-check text-success me-2"></i>Basic hair setting</li>
                <li><i class="fas fa-check text-success me-2"></i>Consultation</li>
              </ul>
              <a href="#contact" class="btn btn-primary-pink text-white">Pilih Package</a>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="pricing-card featured">
              <h3>Gold Package</h3>
              <div class="price">Rp220.000</div>
              <hr>
              <ul class="list-unstyled">
                <li><i class="fas fa-check text-success me-2"></i>Full engagement look</li>
                <li><i class="fas fa-check text-success me-2"></i>1.5 Hour Session</li>
                <li><i class="fas fa-check text-success me-2"></i>Hair styling included</li>
                <li><i class="fas fa-check text-success me-2"></i>Touch-up kit</li>
              </ul>
              <a href="#contact" class="btn btn-primary-pink text-white">Pilih Package</a>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="pricing-card">
              <h3>Platinum Package</h3>
              <div class="price">Rp320.000</div>
              <hr>
              <ul class="list-unstyled">
                <li><i class="fas fa-check text-success me-2"></i>Advanced glam look</li>
                <li><i class="fas fa-check text-success me-2"></i>2 Hour Session</li>
                <li><i class="fas fa-check text-success me-2"></i>Hair accessories setup</li>
                <li><i class="fas fa-check text-success me-2"></i>Photo ready finish</li>
              </ul>
              <a href="#contact" class="btn btn-primary-pink text-white">Pilih Package</a>
            </div>
          </div>
        </div>
      </div>

      <!-- PRE-WEDDING -->
      <div class="tab-pane fade" id="prewedding" role="tabpanel" aria-labelledby="prewedding-tab" tabindex="0">
        <div class="row g-4">
          <div class="col-lg-4">
            <div class="pricing-card">
              <h3>Silver Package</h3>
              <div class="price">Rp180.000</div>
              <hr>
              <ul class="list-unstyled">
                <li><i class="fas fa-check text-success me-2"></i>Soft natural look</li>
                <li><i class="fas fa-check text-success me-2"></i>1.5 Hour Session</li>
                <li><i class="fas fa-check text-success me-2"></i>Basic hair styling</li>
                <li><i class="fas fa-check text-success me-2"></i>Consultation</li>
              </ul>
              <a href="#contact" class="btn btn-primary-pink text-white">Pilih Package</a>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="pricing-card featured">
              <h3>Gold Package</h3>
              <div class="price">Rp280.000</div>
              <hr>
              <ul class="list-unstyled">
                <li><i class="fas fa-check text-success me-2"></i>Editorial/modern look</li>
                <li><i class="fas fa-check text-success me-2"></i>2 Hour Session</li>
                <li><i class="fas fa-check text-success me-2"></i>Hair styling included</li>
                <li><i class="fas fa-check text-success me-2"></i>Photo ready finish</li>
              </ul>
              <a href="#contact" class="btn btn-primary-pink text-white">Pilih Package</a>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="pricing-card">
              <h3>Platinum Package</h3>
              <div class="price">Rp350.000</div>
              <hr>
              <ul class="list-unstyled">
                <li><i class="fas fa-check text-success me-2"></i>High-glam camera look</li>
                <li><i class="fas fa-check text-success me-2"></i>2.5 Hour Session</li>
                <li><i class="fas fa-check text-success me-2"></i>Hair accessories setup</li>
                <li><i class="fas fa-check text-success me-2"></i>On-site touch-ups</li>
              </ul>
              <a href="#contact" class="btn btn-primary-pink text-white">Pilih Package</a>
            </div>
          </div>
        </div>
      </div>
    </div><!-- /tab-content -->
  </div>
</section>


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

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <h5>Risa Makeup Artist</h5>
                    <p>Professional makeup services for your special moments. Creating beautiful looks that enhance your natural beauty.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2">
                    <h6>Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="#home" class="text-light">Beranda</a></li>
                        <li><a href="#services" class="text-light">Layanan</a></li>
                        <li><a href="#pricing" class="text-light">Package</a></li>
                        <li><a href="#gallery" class="text-light">Galeri</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h6>Services</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light">Bridal Makeup</a></li>
                        <li><a href="#" class="text-light">Event Makeup</a></li>
                        <li><a href="#" class="text-light">Photoshoot</a></li>
                        <li><a href="#" class="text-light">Consultation</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h6>Contact Info</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-phone me-2"></i>+62 888 999 777</li>
                        <li><i class="fas fa-envelope me-2"></i>info@risaamakeup.my.id</li>
                        <li><i class="fas fa-map-marker-alt me-2"></i>Denpasar, Bali</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p>&copy; 2024 Risa Makeup Artist. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Smooth Scrolling -->
    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar background on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(255, 255, 255, 0.98)';
            } else {
                navbar.style.background = 'rgba(255, 255, 255, 0.95)';
            }
        });
    </script>
</body>
</html>
