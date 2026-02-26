<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerakan 7KAIH - Tujuh Kebiasaan Anak Indonesia Hebat</title>
      <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2a6bc9;
            --secondary: #1ea896;
            --accent: #ffcc00;
            --dark: #1a365d;
            --light: #f8fafc;
            --gradient: linear-gradient(135deg, var(--primary), var(--secondary));
            --shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--light);
            color: #333;
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Header & Navigation */
        header {
            background: var(--gradient);
            color: white;
            padding: 1rem 2rem;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: var(--shadow);
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.5rem;
            font-weight: 700;
            cursor: pointer;
        }

        .logo i {
            font-size: 1.8rem;
        }

        .logo img {
            width: 35px;
            /* atur sesuai kebutuhan */
            height: 35px;
            object-fit: contain;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            position: relative;
        }

        .nav-links a:hover {
            color: var(--accent);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent);
            transition: var(--transition);
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .hamburger {
            display: none;
            cursor: pointer;
        }

        /* Hero Section */
        .hero {
            background: var(--gradient);
            color: white;
            padding: 10rem 2rem 6rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none"><path d="M0,0 V100 Q500,50 1000,100 V0 Z" fill="rgba(255,255,255,0.1)"/></svg>');
            background-size: cover;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .btn {
            display: inline-block;
            background: var(--accent);
            color: var(--dark);
            padding: 0.8rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            border: none;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        /* About Section */
        .about {
            padding: 5rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title h2 {
            font-size: 2.5rem;
            color: var(--dark);
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }

        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--gradient);
            border-radius: 2px;
        }

        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
        }

        .about-text p {
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
        }

        .about-image {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .about-image:hover {
            transform: translateY(-10px);
        }

        .about-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* Habits Section */
        .habits {
            padding: 5rem 2rem;
            background: #f0f7ff;
        }

        .habits-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .habits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .habit-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: var(--shadow);
            transition: var(--transition);
            text-align: center;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .habit-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .habit-icon {
            width: 80px;
            height: 80px;
            background: var(--gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
        }

        .habit-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .habit-card p {
            color: #666;
            margin-bottom: 1.5rem;
        }

        .habit-number {
            position: absolute;
            top: 10px;
            right: 10px;
            background: var(--accent);
            color: var(--dark);
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* Implementation Section */
        .implementation {
            padding: 5rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .implementation-steps {
            display: flex;
            flex-direction: column;
            gap: 2rem;
            position: relative;
        }

        .implementation-steps::before {
            content: '';
            position: absolute;
            top: 0;
            left: 30px;
            height: 100%;
            width: 4px;
            background: var(--gradient);
            z-index: 0;
        }

        .step {
            display: flex;
            gap: 2rem;
            position: relative;
            z-index: 1;
        }

        .step-icon {
            width: 60px;
            height: 60px;
            background: var(--gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .step-content {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: var(--shadow);
            flex: 1;
        }

        .step-content h3 {
            margin-bottom: 0.5rem;
            color: var(--dark);
        }

        /* Resources Section */
        .resources {
            padding: 5rem 2rem;
            background: #f0f7ff;
        }

        .resources-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .resources-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .resource-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: var(--shadow);
            transition: var(--transition);
            text-align: center;
        }

        .resource-card:hover {
            transform: translateY(-5px);
        }

        .resource-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--primary);
        }

        .resource-card h3 {
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .resource-card a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            margin-top: 1rem;
        }

        .resource-card a:hover {
            text-decoration: underline;
        }

        /* Footer */
        footer {
            background: var(--dark);
            color: white;
            padding: 3rem 2rem 1rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .footer-section h3 {
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .footer-section h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 2px;
            background: var(--accent);
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.8rem;
        }

        .footer-links a {
            color: #ccc;
            text-decoration: none;
            transition: var(--transition);
        }

        .footer-links a:hover {
            color: var(--accent);
            padding-left: 5px;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: white;
            transition: var(--transition);
        }

        .social-links a:hover {
            background: var(--accent);
            color: var(--dark);
            transform: translateY(-3px);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            margin-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Landing Page Styles */
        .landing-page {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            z-index: 2000;
            overflow-y: auto;
            padding: 2rem;
        }

        .landing-header {
            background: var(--gradient);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            position: relative;
            text-align: center;
        }

        .back-btn {
            position: absolute;
            left: 2rem;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-50%) scale(1.1);
        }

        .landing-content {
            max-width: 1000px;
            margin: 0 auto;
        }

        .landing-section {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
        }

        .landing-section h2 {
            color: var(--dark);
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--accent);
        }

        .definition-box {
            background: #f0f7ff;
            padding: 1.5rem;
            border-radius: 10px;
            border-left: 4px solid var(--primary);
            margin-bottom: 1.5rem;
        }

        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .benefit-item {
            background: #f9f9f9;
            padding: 1.5rem;
            border-radius: 10px;
            text-align: center;
            transition: var(--transition);
        }

        .benefit-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .benefit-icon {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .implementation-steps-landing {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .implementation-step {
            display: flex;
            gap: 1.5rem;
            align-items: flex-start;
        }

        .step-number {
            background: var(--gradient);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            flex-shrink: 0;
        }

        .step-content-landing {
            flex: 1;
        }

        .quote-box {
            background: #fff9e6;
            padding: 1.5rem;
            border-radius: 10px;
            border-left: 4px solid var(--accent);
            font-style: italic;
            margin: 1.5rem 0;
        }

        .quote-author {
            text-align: right;
            font-weight: bold;
            margin-top: 0.5rem;
            color: var(--dark);
        }

        /* Peran Guru & Satuan Pendidikan Styles */
        .role-section {
            margin-top: 2rem;
        }

        .role-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-top: 1.5rem;
        }

        .role-card {
            background: #f9f9f9;
            border-radius: 10px;
            padding: 1.5rem;
            border-left: 4px solid var(--primary);
        }

        .role-card h3 {
            color: var(--dark);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .role-card h3 i {
            color: var(--primary);
        }

        .role-list {
            list-style-type: none;
            padding: 0;
        }

        .role-list li {
            padding: 0.5rem 0;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .role-list li:before {
            content: "•";
            color: var(--primary);
            font-weight: bold;
            flex-shrink: 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .hamburger {
                display: block;
            }

            .hero h1 {
                font-size: 2.2rem;
            }

            .about-content {
                grid-template-columns: 1fr;
            }

            .implementation-steps::before {
                left: 20px;
            }

            .step {
                flex-direction: column;
                gap: 1rem;
            }

            .step-icon {
                align-self: flex-start;
            }

            .back-btn {
                position: relative;
                left: 0;
                top: 0;
                transform: none;
                margin-bottom: 1rem;
            }

            .landing-header {
                text-align: left;
            }

            .role-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 1s ease forwards;
        }

        .delay-1 {
            animation-delay: 0.2s;
        }

        .delay-2 {
            animation-delay: 0.4s;
        }

        .delay-3 {
            animation-delay: 0.6s;
        }

        .delay-4 {
            animation-delay: 0.8s;
        }

        .delay-5 {
            animation-delay: 1s;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <nav class="navbar">
            <div class="logo" id="main-logo">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
                <span>7KAIH</span>
            </div>

            <ul class="nav-links">
                <li><a href="#home">Beranda</a></li>
                <li><a href="#about">Tentang</a></li>
                <li><a href="#habits">Kebiasaan</a></li>
                <li><a href="#implementation">Implementasi</a></li>
                <li><a href="#resources">Sumber Daya</a></li>
                <li><a href="{{ route('login') }}">Masuk</a></li>
            </ul>
            <div class="hamburger">
                <i class="fas fa-bars"></i>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <div id="main-content">
        <!-- Hero Section -->
        <section class="hero" id="home">
            <div class="hero-content">
                <h1 class="fade-in">Gerakan 7 Kebiasaan Anak Indonesia Hebat</h1>
                <p class="fade-in delay-1">Membentuk Generasi Emas Indonesia 2045 melalui Pembiasaan Positif Sehari-hari
                </p>
                <a href="#about" class="btn fade-in delay-2">Pelajari Lebih Lanjut</a>
            </div>
        </section>

        <!-- About Section -->
        <section class="about" id="about">
            <div class="section-title">
                <h2>Tentang 7KAIH</h2>
            </div>
            <div class="about-content">
                <div class="about-text">
                    <p class="fade-in">Gerakan Tujuh Kebiasaan Anak Indonesia Hebat (7KAIH) merupakan inisiatif
                        Kementerian Pendidikan Dasar dan Menengah yang diluncurkan pada 27 Desember 2024 sebagai langkah
                        strategis menuju Generasi Emas Indonesia 2045.</p>
                    <p class="fade-in delay-1">Gerakan ini bertujuan membentuk anak-anak Indonesia dengan karakter yang
                        tangguh dan berdaya saing melalui pembiasaan perilaku positif sehari-hari.</p>
                    <p class="fade-in delay-2">7KAIH melakukan perubahan secara intrinsik dan ekstrinsik. Perubahan
                        intrinsik meniscayakan kesadaran dari dalam diri sendiri, sementara perubahan ekstrinsik berasal
                        dari motivasi guru, orang tua, dan lingkungan yang positif.</p>
                </div>
                <div class="about-image fade-in delay-3">
                    <div
                        style="width:100%;height:300px;background:var(--gradient);display:flex;align-items:center;justify-content:center;color:white;font-size:1.5rem;">
                        <i class="fas fa-users" style="font-size:4rem;opacity:0.7;"></i>
                    </div>
                </div>
            </div>
        </section>

        <!-- Habits Section -->
        <section class="habits" id="habits">
            <div class="habits-container">
                <div class="section-title">
                    <h2>7 Kebiasaan Hebat</h2>
                </div>
                <div class="habits-grid">
                    <!-- Habit 1 -->
                    <div class="habit-card fade-in" id="bangun-pagi-card">
                        <div class="habit-number">1</div>
                        <div class="habit-icon">
                            <i class="fas fa-sun"></i>
                        </div>
                        <h3>Bangun Pagi</h3>
                        <p>Bangun dari tidur pada pukul 04.00-06.00 untuk memulai hari dengan penuh semangat dan
                            kesiapan.</p>
                    </div>

                    <!-- Habit 2 -->
                    <div class="habit-card fade-in delay-1" id="beribadah-card">
                        <div class="habit-number">2</div>
                        <div class="habit-icon">
                            <i class="fas fa-pray"></i>
                        </div>
                        <h3>Beribadah</h3>
                        <p>Bentuk pengabdian, penghormatan, dan ketaatan kepada Tuhan sesuai ajaran agama dan
                            kepercayaan.</p>
                    </div>

                    <!-- Habit 3 -->
                    <div class="habit-card fade-in delay-2" id="berolahraga-card">
                        <div class="habit-number">3</div>
                        <div class="habit-icon">
                            <i class="fas fa-running"></i>
                        </div>
                        <h3>Berolahraga</h3>
                        <p>Aktivitas fisik untuk meningkatkan kebugaran tubuh, menjaga kesehatan, dan meningkatkan
                            kualitas hidup.</p>
                    </div>

                    <!-- Habit 4 -->
                    <div class="habit-card fade-in delay-3" id="makan-sehat-card">
                        <div class="habit-number">4</div>
                        <div class="habit-icon">
                            <i class="fas fa-apple-alt"></i>
                        </div>
                        <h3>Makan Sehat & Bergizi</h3>
                        <p>Pola makan teratur dengan nutrisi lengkap dan seimbang untuk mendukung kesehatan fisik dan
                            mental.</p>
                    </div>

                    <!-- Habit 5 -->
                    <div class="habit-card fade-in" id="gemar-belajar-card">
                        <div class="habit-number">5</div>
                        <div class="habit-icon">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <h3>Gemar Belajar</h3>
                        <p>Kebiasaan menambah pengetahuan, keterampilan, dan wawasan dengan senang, antusias, dan
                            berkeinginan kuat.</p>
                    </div>

                    <!-- Habit 6 -->
                    <div class="habit-card fade-in delay-1" id="bermasyarakat-card">
                        <div class="habit-number">6</div>
                        <div class="habit-icon">
                            <i class="fas fa-hands-helping"></i>
                        </div>
                        <h3>Bermasyarakat</h3>
                        <p>Interaksi sosial, kerja sama, dan keterlibatan dalam kegiatan sosial, budaya, atau
                            lingkungan.</p>
                    </div>

                    <!-- Habit 7 -->
                    <div class="habit-card fade-in delay-2" id="tidur-cepat-card">
                        <div class="habit-number">7</div>
                        <div class="habit-icon">
                            <i class="fas fa-bed"></i>
                        </div>
                        <h3>Tidur Cepat</h3>
                        <p>Kebiasaan tidur tepat waktu dan tidak larut malam sesuai kebutuhan ideal waktu tidur anak.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Implementation Section -->
        <section class="implementation" id="implementation">
            <div class="section-title">
                <h2>Implementasi</h2>
            </div>
            <div class="implementation-steps">
                <!-- Step 1 -->
                <div class="step fade-in">
                    <div class="step-icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="step-content">
                        <h3>Peran Guru</h3>
                        <p>Guru berperan sebagai teladan, pembimbing, motivator, dan evaluator dalam penerapan 7KAIH di
                            sekolah.</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="step fade-in delay-1">
                    <div class="step-icon">
                        <i class="fas fa-school"></i>
                    </div>
                    <div class="step-content">
                        <h3>Peran Satuan Pendidikan</h3>
                        <p>Membuat kebijakan, sistem apresiasi, edukasi, dan menyediakan sarana prasarana pendukung.</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="step fade-in delay-2">
                    <div class="step-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="step-content">
                        <h3>Peran Orang Tua/Wali</h3>
                        <p>Membimbing, memantau, dan memberi contoh penerapan 7KAIH di lingkungan rumah.</p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="step fade-in delay-3">
                    <div class="step-icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <div class="step-content">
                        <h3>Pemantauan & Evaluasi</h3>
                        <p>Menggunakan catatan harian, refleksi bulanan, dan rekapitulasi untuk memantau perkembangan.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Resources Section -->
        <section class="resources" id="resources">
            <div class="resources-container">
                <div class="section-title">
                    <h2>Sumber Daya</h2>
                </div>
                <div class="resources-grid">
                    <div class="resource-card fade-in">
                        <div class="resource-icon">
                            <i class="fas fa-file-download"></i>
                        </div>
                        <h3>Template & Formulir</h3>
                        <p>Download template catatan harian, formulir pemantauan, dan lembar refleksi.</p>
                        <a href="https://bit.ly/template7kaih" target="_blank">Unduh di sini</a>
                    </div>

                    <div class="resource-card fade-in delay-1">
                        <div class="resource-icon">
                            <i class="fas fa-music"></i>
                        </div>
                        <h3>Lagu & Video</h3>
                        <p>Akses lagu-lagu 7KAIH, video senam, dan materi edukasi lainnya.</p>
                        <a href="https://cerdasberkarakter.kemendikdasmen.go.id/gerakan7kebiasaan/#albumkelana">Lihat
                            Koleksi</a>
                    </div>

                    <div class="resource-card fade-in delay-2">
                        <div class="resource-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <h3>Panduan Lengkap</h3>
                        <p>Buku panduan penerapan 7KAIH untuk guru dan satuan pendidikan.</p>
                        <a href="https://cerdasberkarakter.kemendikdasmen.go.id/gerakan7kebiasaan/#panduan">Baca
                            Panduan</a>
                    </div>

                    <div class="resource-card fade-in delay-3">
                        <div class="resource-icon">
                            <i class="fas fa-globe"></i>
                        </div>
                        <h3>Website Resmi</h3>
                        <p>Kunjungi website resmi 7KAIH untuk informasi terbaru dan sumber daya lainnya.</p>
                        <a href="https://cerdasberkarakter.kemdikbud.go.id" target="_blank">Kunjungi Website</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer>
            <div class="footer-content">
                <div class="footer-section">
                    <h3>7KAIH</h3>
                    <p>Gerakan Tujuh Kebiasaan Anak Indonesia Hebat merupakan inisiatif Kementerian Pendidikan Dasar dan
                        Menengah untuk membentuk generasi Indonesia yang sehat, cerdas, dan berkarakter.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-tiktok"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                <div class="footer-section">
                    <h3>Tautan Cepat</h3>
                    <ul class="footer-links">
                        <li><a href="#home">Beranda</a></li>
                        <li><a href="#about">Tentang 7KAIH</a></li>
                        <li><a href="#habits">7 Kebiasaan</a></li>
                        <li><a href="#implementation">Implementasi</a></li>
                        <li><a href="#resources">Sumber Daya</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>Kontak</h3>
                    <ul class="footer-links">
                        <li><i class="fas fa-map-marker-alt"></i> <a
                                href="https://maps.app.goo.gl/HLwrUFDrqakg8xYz9?g_st=aw">SMP</a>
                        </li>
                        <li><i class="fas fa-phone"></i> 08817626520</li>
                        <li><i class="fas fa-envelope"></i> sekolah@gmail.com</li>
                        <li><i class="fas fa-globe"></i> <a
                                href="">skolah.blogspot.com</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2023 Gerakan 7 Kebiasaan Anak Indonesia Hebat. Semua hak dilindungi.</p>
            </div>
        </footer>
    </div>

    <!-- Landing Page for Bangun Pagi -->
    <div id="bangun-pagi-landing" class="landing-page">
        <div class="landing-content">
            <div class="landing-header">
                <button class="back-btn" id="back-from-bangun-pagi">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <h1>Bangun Pagi</h1>
                <p>Kebiasaan membangun hari dengan penuh semangat dan kesiapan</p>
            </div>

            <div class="landing-section fade-in">
                <h2>Definisi</h2>
                <div class="definition-box">
                    <p>Bangun pagi adalah aktivitas seseorang untuk bangun dari tidur pada waktu pagi hari, biasanya
                        antara pukul <strong>04.00 hingga 06.00</strong>.</p>
                </div>
                <div class="quote-box">
                    <p>"Bangun pagi itu adalah kebiasaan orang sukses, karena pagi adalah waktu yang penuh kesempatan
                        untuk meraih cita-cita."</p>
                    <div class="quote-author">- B.J. Habibie</div>
                </div>
            </div>

            <div class="landing-section fade-in delay-1">
                <h2>Pentingnya Bangun Pagi</h2>
                <p>Bangun pagi penting dilakukan oleh murid karena bisa meningkatkan konsentrasi dan fokus, dengan
                    bangun pagi mereka dapat mempersiapkan segala aktivitas dengan optimal.</p>
                <p>Rutinitas bangun pagi yang konsisten dapat membantu murid untuk menjaga kesehatan fisik dan
                    mentalnya. Murid yang bangun pagi, sering kali memiliki waktu untuk melakukan aktivitas produktif
                    seperti beribadah, sarapan, belajar, dan berolahraga.</p>
                <p>Kebiasaan bangun pagi dapat memberikan disiplin diri dan tanggung jawab murid, sehingga mendukung
                    kesuksesan akademik dan menguatkan karakter mereka.</p>
            </div>

            <div class="landing-section fade-in delay-2">
                <h2>Manfaat Bangun Pagi</h2>
                <div class="benefits-grid">
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3>Meningkatkan Kedisiplinan</h3>
                        <p>Dengan mematuhi waktu yang telah ditentukan, dilakukan dengan rasa tanggung jawab, dan
                            berkelanjutan.</p>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <h3>Meningkatkan Kemampuan Mengelola Waktu</h3>
                        <p>Membentuk kebiasaan yang teratur dan memberi ruang untuk melakukan evaluasi diri.</p>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-brain"></i>
                        </div>
                        <h3>Meningkatkan Kemampuan Mengendalikan Diri</h3>
                        <p>Melawan godaan untuk bermalas-malasan dan membangun kontrol diri yang lebih baik.</p>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                        <h3>Meningkatkan Keseimbangan Jiwa dan Raga</h3>
                        <p>Tubuh dan pikiran menjadi segar melalui berbagai aktivitas yang dapat dilakukan di pagi hari.
                        </p>
                    </div>
                </div>
            </div>

            <div class="landing-section fade-in delay-3">
                <h2>Cara Penerapan di Sekolah</h2>
                <div class="implementation-steps-landing">
                    <div class="implementation-step">
                        <div class="step-number">1</div>
                        <div class="step-content-landing">
                            <h3>Rutinitas Pagi di Sekolah</h3>
                            <p>Tawarkan beberapa aktivitas menarik di pagi hari, misalnya: gerak bersama dengan diiringi
                                lagu (Bangun Pagi), olahraga pagi bisa dengan senam pagi Anak Indonesia Hebat, sesi
                                membaca, mengenalkan permainan tradisional, dan aktivitas lain yang mendukung kegiatan
                                belajar di kelas.</p>
                        </div>
                    </div>
                    <div class="implementation-step">
                        <div class="step-number">2</div>
                        <div class="step-content-landing">
                            <h3>Membangun Kesadaran</h3>
                            <p>Adakan sesi diskusi di kelas tentang manfaat bangun pagi. Ajak murid untuk berbagi
                                pengalaman mereka dan mendiskusikan bagaimana kebiasaan ini dapat mempengaruhi kehidupan
                                sehari-hari. Gunakan video, artikel, atau presentasi yang menjelaskan dampak positif
                                dari bangun pagi.</p>
                        </div>
                    </div>
                    <div class="implementation-step">
                        <div class="step-number">3</div>
                        <div class="step-content-landing">
                            <h3>Memberikan Aktivitas yang Menarik</h3>
                            <p>Berikan aktivitas menarik yang harus diselesaikan di pagi hari, seperti membuat ringkasan
                                buku favorit murid atau membuat jurnal kebiasaan pagi.</p>
                        </div>
                    </div>
                    <div class="implementation-step">
                        <div class="step-number">4</div>
                        <div class="step-content-landing">
                            <h3>Memberikan Contoh yang Baik</h3>
                            <p>Melibatkan murid untuk mempresentasikan kisah sukses dari tokoh-tokoh terkenal yang
                                memiliki kebiasaan bangun pagi, serta bagaimana hal itu berkontribusi pada kesuksesan
                                mereka.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="landing-section fade-in delay-4">
                <h2>Peran Guru dan Satuan Pendidikan</h2>
                <div class="role-section">
                    <div class="role-grid">
                        <div class="role-card">
                            <h3><i class="fas fa-user-tie"></i> Peran Guru</h3>
                            <ul class="role-list">
                                <li><strong>Teladan:</strong> Datang lebih awal untuk menyapa murid, mengikuti senam
                                    pagi bersama, memulai aktivitas kelas dengan energi positif</li>
                                <li><strong>Pembimbing:</strong> Menjelaskan manfaat bangun pagi dengan bahasa dan cara
                                    yang mudah dipahami, mengajak berdiskusi tentang pentingnya mengelola waktu</li>
                                <li><strong>Motivator:</strong> Memotivasi murid untuk terbiasa bangun pagi setiap hari,
                                    memberikan apresiasi kepada murid yang datang tepat waktu</li>
                                <li><strong>Evaluator:</strong> Berkolaborasi dengan orang tua/wali tentang upaya yang
                                    harus dilakukan, menandatangani formulir pemantauan</li>
                            </ul>
                        </div>
                        <div class="role-card">
                            <h3><i class="fas fa-school"></i> Peran Satuan Pendidikan</h3>
                            <ul class="role-list">
                                <li><strong>Kebijakan:</strong> Menetapkan tata tertib datang tepat waktu ke sekolah
                                    bagi semua warga sekolah, membuat prosedur operasional standar penyambutan
                                    kedatangan murid</li>
                                <li><strong>Sistem Apresiasi:</strong> Mengembangkan dan menerapkan sistem apresiasi
                                    bagi murid yang telah menerapkan kebiasaan bangun pagi</li>
                                <li><strong>Edukasi dan Sosialisasi:</strong> Mengundang narasumber ahli, membuat poster
                                    atau media publikasi tentang manfaat kebiasaan bangun pagi</li>
                                <li><strong>Kolaborasi:</strong> Deklarasi bersama orang tua/wali agar turut aktif
                                    membimbing dan memantau penerapan kebiasaan bangun pagi di rumah</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Landing Page for Beribadah -->
    <div id="beribadah-landing" class="landing-page">
        <div class="landing-content">
            <div class="landing-header">
                <button class="back-btn" id="back-from-beribadah">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <h1>Beribadah</h1>
                <p>Pengabdian, penghormatan, dan ketaatan kepada Tuhan sesuai ajaran agama dan kepercayaan</p>
            </div>

            <div class="landing-section fade-in">
                <h2>Definisi</h2>
                <div class="definition-box">
                    <p>Beribadah adalah bentuk <strong>pengabdian, penghormatan, dan ketaatan</strong> seseorang kepada
                        Tuhan sesuai dengan ajaran agama atau kepercayaan yang dianutnya.</p>
                </div>
                <div class="quote-box">
                    <p>"Beribadah adalah cara kita menunjukkan rasa syukur dan mendekatkan diri kepada Tuhan."</p>
                    <div class="quote-author">- Ahmad Dahlan</div>
                </div>
            </div>

            <div class="landing-section fade-in delay-1">
                <h2>Pentingnya Beribadah</h2>
                <p>Beribadah dapat memperkuat hubungan spiritual dengan Tuhan sehingga memberikan ketenangan hati yang
                    membuat kesehatan mental dan pembentukan karakter semakin baik.</p>
                <p>Selain itu, beribadah dapat membangun hubungan sosial yang positif, menjalani hidup yang lebih
                    bermakna dan penuh berkah.</p>
                <p>Ibadah bukan sekadar ritual, tetapi berdampak pada perilaku sehari-hari.</p>
            </div>

            <div class="landing-section fade-in delay-2">
                <h2>Manfaat Beribadah</h2>
                <div class="benefits-grid">
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-praying-hands"></i>
                        </div>
                        <h3>Mendekatkan Hubungan dengan Tuhan</h3>
                        <p>Mengakui keberadaan dan kekuasaan Tuhan, serta membangun hubungan yang penuh syukur, cinta,
                            dan penghormatan.</p>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h3>Meningkatkan Nilai Etika dan Moral</h3>
                        <p>Ibadah bukan sekedar ritual, tetapi juga membentuk karakter yang baik dengan menjalankan
                            kebaikan dan menjauhi perbuatan buruk.</p>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3>Memahami Tujuan Hidup</h3>
                        <p>Ibadah memberi waktu untuk merenung, introspeksi, dan memfokuskan pikiran pada hal-hal yang
                            lebih penting.</p>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>Meningkatkan Kebersamaan</h3>
                        <p>Ibadah tidak hanya menghubungkan kita dengan Tuhan, tetapi juga dengan sesama tanpa memandang
                            status sosial atau latar belakang.</p>
                    </div>
                </div>
            </div>

            <div class="landing-section fade-in delay-3">
                <h2>Cara Penerapan di Sekolah</h2>
                <div class="implementation-steps-landing">
                    <div class="implementation-step">
                        <div class="step-number">1</div>
                        <div class="step-content-landing">
                            <h3>Integrasi Nilai Agama</h3>
                            <p>Gunakan studi kasus yang relevan dengan nilai-nilai agama. Diskusikan bagaimana
                                tokoh-tokoh agama atau sejarah menerapkan nilai-nilai tersebut dalam kehidupan mereka.
                            </p>
                        </div>
                    </div>
                    <div class="implementation-step">
                        <div class="step-number">2</div>
                        <div class="step-content-landing">
                            <h3>Lingkungan yang Mendukung</h3>
                            <p>Menciptakan lingkungan yang mendukung ibadah, murid dapat beribadah dengan nyaman sesuai
                                agama, keyakinan, dan kepercayaan yang dianutnya.</p>
                        </div>
                    </div>
                    <div class="implementation-step">
                        <div class="step-number">3</div>
                        <div class="step-content-landing">
                            <h3>Kegiatan Keagamaan yang Menarik</h3>
                            <p>Bentuk organisasi keagamaan di sekolah. Ajak murid untuk berpartisipasi dalam kegiatan
                                seperti diskusi agama, kajian kitab suci, atau kegiatan sosial yang berlandaskan
                                nilai-nilai agama.</p>
                        </div>
                    </div>
                    <div class="implementation-step">
                        <div class="step-number">4</div>
                        <div class="step-content-landing">
                            <h3>Kolaborasi dengan Orang Tua</h3>
                            <p>Libatkan orang tua dalam mendukung rutinitas ibadah murid. Berikan informasi tentang
                                kegiatan keagamaan di sekolah dan pentingnya peran orang tua.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="landing-section fade-in delay-4">
                <h2>Peran Guru dan Satuan Pendidikan</h2>
                <div class="role-section">
                    <div class="role-grid">
                        <div class="role-card">
                            <h3><i class="fas fa-user-tie"></i> Peran Guru</h3>
                            <ul class="role-list">
                                <li><strong>Teladan:</strong> Membiasakan diri untuk beribadah yang konsisten, selalu
                                    menghubungkan setiap aktivitas di kelas dengan nilai-nilai keagamaan</li>
                                <li><strong>Pembimbing:</strong> Menjelaskan pentingnya ibadah dengan cara dan bahasa
                                    yang mudah dipahami, mengintegrasikan nilai-nilai agama dalam mata pelajaran</li>
                                <li><strong>Motivator:</strong> Memotivasi peserta didik untuk terbiasa beribadah sesuai
                                    dengan agama, keyakinan, dan kepercayaan, memberikan apresiasi ketika terlibat dalam
                                    kegiatan beribadah</li>
                                <li><strong>Evaluator:</strong> Menandatangani formulir pemantauan, berkolaborasi dengan
                                    orang tua/wali tentang upaya yang harus dilakukan untuk meningkatkan kebiasaan
                                    beribadah</li>
                            </ul>
                        </div>
                        <div class="role-card">
                            <h3><i class="fas fa-school"></i> Peran Satuan Pendidikan</h3>
                            <ul class="role-list">
                                <li><strong>Kebijakan:</strong> Menetapkan kebijakan berdoa bersama sesuai keyakinan
                                    masing-masing sebelum memulai pembelajaran, mengadakan kegiatan ekstrakurikuler
                                    keagamaan</li>
                                <li><strong>Sistem Penghargaan:</strong> Mengembangkan dan menerapkan sistem penghargaan
                                    bagi murid yang telah menerapkan kebiasaan beribadah dengan baik</li>
                                <li><strong>Edukasi dan Sosialisasi:</strong> Mengundang narasumber dari unsur pemuka
                                    agama atau pakar, membuat media publikasi tentang manfaat kebiasaan beribadah</li>
                                <li><strong>Sarana dan Prasarana:</strong> Menyediakan fasilitas beribadah atau
                                    perangkat beribadah sesuai dengan agama, keyakinan, dan kepercayaan yang mudah
                                    diakses oleh murid</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Landing Page for Berolahraga -->
    <div id="berolahraga-landing" class="landing-page">
        <div class="landing-content">
            <div class="landing-header">
                <button class="back-btn" id="back-from-berolahraga">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <h1>Berolahraga</h1>
                <p>Aktivitas fisik untuk kebugaran, kesehatan, dan kualitas hidup</p>
            </div>

            <div class="landing-section fade-in">
                <h2>Definisi</h2>
                <div class="definition-box">
                    <p>Berolahraga adalah aktivitas fisik yang dilakukan untuk <strong>meningkatkan kebugaran tubuh,
                            menjaga kesehatan, dan meningkatkan kualitas hidup</strong>.</p>
                </div>
                <div class="quote-box">
                    <p>"Olahraga adalah cara terbaik untuk menjaga keseimbangan antara tubuh dan pikiran."</p>
                    <div class="quote-author">- Nelson Mandela</div>
                </div>
            </div>

            <div class="landing-section fade-in delay-1">
                <h2>Pentingnya Berolahraga</h2>
                <p>Olahraga yang teratur dapat membuat kita merasa lebih sehat dan lebih bugar, yang secara langsung
                    meningkatkan kualitas hidup kita.</p>
                <p>Olahraga penting untuk menjaga keseimbangan antara pendidikan, kehidupan sosial, dan kesehatan tubuh.
                </p>
                <p>Melalui olahraga, kita menjaga agar tubuh tetap aktif dan bugar, sehingga mampu menjalani kehidupan
                    dengan lebih baik.</p>
            </div>

            <div class="landing-section fade-in delay-2">
                <h2>Manfaat Berolahraga</h2>
                <div class="benefits-grid">
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <h3>Menjaga Kesehatan Fisik dan Mental</h3>
                        <p>Berolahraga dapat mengurangi stres, kecemasan, dan meningkatkan kualitas pikiran, serta
                            menciptakan harmoni antara tubuh dan pikiran.</p>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-running"></i>
                        </div>
                        <h3>Menjaga Kebugaran Tubuh</h3>
                        <p>Tubuh adalah karunia Tuhan yang perlu dijaga dan dikembangkan potensinya secara maksimal.</p>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-brain"></i>
                        </div>
                        <h3>Meningkatkan Potensi Diri</h3>
                        <p>Meningkatkan potensi diri, baik secara fisik, mental, maupun sosial yang mendukung kesuksesan
                            dalam berbagai aspek kehidupan.</p>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <h3>Meningkatkan Nilai Sportivitas</h3>
                        <p>Nilai sportivitas mengajarkan sikap yang menjunjung tinggi kejujuran dan keadilan.</p>
                    </div>
                </div>
            </div>

            <div class="landing-section fade-in delay-3">
                <h2>Cara Penerapan di Sekolah</h2>
                <div class="implementation-steps-landing">
                    <div class="implementation-step">
                        <div class="step-number">1</div>
                        <div class="step-content-landing">
                            <h3>Kegiatan Olahraga Menarik</h3>
                            <p>Mengadakan kegiatan olahraga yang menarik seperti kompetisi dan turnamen yang
                                diselenggarakan sekolah maupun mengikuti kompetisi di luar sekolah.</p>
                        </div>
                    </div>
                    <div class="implementation-step">
                        <div class="step-number">2</div>
                        <div class="step-content-landing">
                            <h3>Olahraga Bersama</h3>
                            <p>Menetapkan kegiatan olahraga bersama, seperti senam pagi, jalan sehat, atau olahraga tim.
                            </p>
                        </div>
                    </div>
                    <div class="implementation-step">
                        <div class="step-number">3</div>
                        <div class="step-content-landing">
                            <h3>Kisah Inspiratif</h3>
                            <p>Ceritakan kisah-kisah inspiratif tentang atlet atau tokoh olahraga yang berhasil.</p>
                        </div>
                    </div>
                    <div class="implementation-step">
                        <div class="step-number">4</div>
                        <div class="step-content-landing">
                            <h3>Kolaborasi dengan Orang Tua</h3>
                            <p>Libatkan orang tua dalam mendukung kegiatan olahraga murid. Kirimkan informasi tentang
                                kegiatan olahraga di sekolah.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="landing-section fade-in delay-4">
                <h2>Peran Guru dan Satuan Pendidikan</h2>
                <div class="role-section">
                    <div class="role-grid">
                        <div class="role-card">
                            <h3><i class="fas fa-user-tie"></i> Peran Guru</h3>
                            <ul class="role-list">
                                <li><strong>Teladan:</strong> Membiasakan diri untuk berolahraga, mempraktikkan
                                    kebiasaan olahraga yang sehat, terlibat senam bersama di pagi hari</li>
                                <li><strong>Pembimbing:</strong> Memberikan penjelasan tentang pentingnya berolahraga,
                                    mengatur jadwal kegiatan olahraga rutin di sekolah, membina klub olahraga atau
                                    ekstrakurikuler</li>
                                <li><strong>Motivator:</strong> Memotivasi murid untuk terbiasa berolahraga, memberikan
                                    apresiasi kepada murid setelah berolahraga</li>
                                <li><strong>Evaluator:</strong> Memperhatikan kebiasaan olahraga yang dilakukan murid di
                                    sekolah, berkolaborasi dengan orang tua/wali tentang upaya peningkatan</li>
                            </ul>
                        </div>
                        <div class="role-card">
                            <h3><i class="fas fa-school"></i> Peran Satuan Pendidikan</h3>
                            <ul class="role-list">
                                <li><strong>Kebijakan:</strong> Melaksanakan senam pagi Anak Indonesia Hebat minimal dua
                                    kali dalam seminggu, mengembangkan sistem apresiasi bagi murid</li>
                                <li><strong>Edukasi dan Sosialisasi:</strong> Mengundang narasumber dari unsur guru,
                                    orang tua, alumni, atau pakar, membuat media publikasi tentang manfaat berolahraga
                                </li>
                                <li><strong>Kompetisi:</strong> Mengadakan kompetisi olahraga antar kelas atau antar
                                    sekolah, seperti turnamen futsal, bola basket, voli, atau olahraga lainnya</li>
                                <li><strong>Sarana dan Prasarana:</strong> Menyediakan fasilitas berolahraga yang
                                    memadai dan mudah diakses, mengizinkan murid menggunakan fasilitas olahraga sekolah
                                    setelah jam pelajaran</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Landing Page for Makan Sehat -->
    <div id="makan-sehat-landing" class="landing-page">
        <div class="landing-content">
            <div class="landing-header">
                <button class="back-btn" id="back-from-makan-sehat">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <h1>Makan Sehat & Bergizi</h1>
                <p>Pola makan teratur dengan nutrisi lengkap dan seimbang untuk kesehatan fisik dan mental</p>
            </div>

            <div class="landing-section fade-in">
                <h2>Definisi</h2>
                <div class="definition-box">
                    <p>Makan sehat dan bergizi adalah <strong>pola makan teratur</strong> dengan mengkonsumsi makanan
                        yang mengandung <strong>nutrisi lengkap dan seimbang</strong> untuk memenuhi kebutuhan tubuh,
                        sehingga mendukung kesehatan fisik dan mental.</p>
                </div>
                <div class="quote-box">
                    <p>"Menjaga pola makan sehat, membuat tubuh kuat dan bugar."</p>
                    <div class="quote-author">- Iko Uwais</div>
                </div>
            </div>

            <div class="landing-section fade-in delay-1">
                <h2>Pentingnya Makan Sehat dan Bergizi</h2>
                <p>Makan sehat dan bergizi sangat penting bagi murid karena dapat mendukung pertumbuhan dan perkembangan
                    tubuh serta meningkatkan daya tahan tubuh.</p>
                <p>Dengan asupan gizi yang seimbang, murid dapat memiliki energi yang cukup untuk menjalani aktivitas
                    sehari-hari dengan optimal.</p>
                <p>Kebiasaan makan sehat dan bergizi dapat memberikan disiplin dalam memilih makanan yang baik bagi
                    tubuh, sehingga membantu murid untuk lebih sadar akan pentingnya menjaga pola hidup sehat.</p>
            </div>

            <div class="landing-section fade-in delay-2">
                <h2>Manfaat Makan Sehat dan Bergizi</h2>
                <div class="benefits-grid">
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h3>Menjaga Kesehatan Fisik</h3>
                        <p>Sebagai investasi jangka panjang untuk masa depan yang bebas dari penyakit dan ketergantungan
                            pada obat-obatan.</p>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-brain"></i>
                        </div>
                        <h3>Memaksimalkan Potensi Tubuh dan Pikiran</h3>
                        <p>Gizi yang baik dan nutrisi yang cukup membuat tubuh anak lebih kuat, meningkatkan
                            konsentrasi, dan mendukung produktivitas.</p>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <h3>Tanggung Jawab Individu</h3>
                        <p>Anak diajarkan untuk mengambil makanan sesuai porsi dan kebutuhan agar terhindar dari
                            pemborosan.</p>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-user-alt"></i>
                        </div>
                        <h3>Meningkatkan Kemandirian</h3>
                        <p>Kebiasaan ini mengajarkan anak untuk memilih sendiri dan mengkonsumsi makanan sehat yang
                            mempengaruhi energi, kesehatan, dan kesejahteraan tubuhnya.</p>
                    </div>
                </div>
            </div>

            <div class="landing-section fade-in delay-3">
                <h2>Cara Penerapan di Sekolah</h2>
                <div class="implementation-steps-landing">
                    <div class="implementation-step">
                        <div class="step-number">1</div>
                        <div class="step-content-landing">
                            <h3>Edukasi Gizi</h3>
                            <p>Adakan sesi diskusi atau presentasi di kelas tentang pentingnya makanan sehat dan
                                bergizi. Gunakan video, infografis, atau eksperimen sederhana.</p>
                        </div>
                    </div>
                    <div class="implementation-step">
                        <div class="step-number">2</div>
                        <div class="step-content-landing">
                            <h3>Tantangan Makan Sehat</h3>
                            <p>Buat program tantangan makan sehat, misalnya "7 Hari Sarapan Sehat" di mana murid
                                mencatat menu sarapan mereka setiap hari.</p>
                        </div>
                    </div>
                    <div class="implementation-step">
                        <div class="step-number">3</div>
                        <div class="step-content-landing">
                            <h3>Bekal Sehat</h3>
                            <p>Dorong murid untuk membawa bekal sehat dari rumah. Guru dapat mengadakan sesi berbagi
                                pengalaman di kelas.</p>
                        </div>
                    </div>
                    <div class="implementation-step">
                        <div class="step-number">4</div>
                        <div class="step-content-landing">
                            <h3>Kantin Sehat</h3>
                            <p>Bekerja sama dengan kantin sekolah agar menyediakan pilihan makanan yang lebih sehat,
                                seperti buah-buahan, sayuran, dan minuman tanpa pemanis buatan.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="landing-section fade-in delay-4">
                <h2>Peran Guru dan Satuan Pendidikan</h2>
                <div class="role-section">
                    <div class="role-grid">
                        <div class="role-card">
                            <h3><i class="fas fa-user-tie"></i> Peran Guru</h3>
                            <ul class="role-list">
                                <li><strong>Teladan:</strong> Membiasakan diri untuk makan sehat dan bergizi, memberikan
                                    contoh langsung makan sehat dan bergizi di kelas</li>
                                <li><strong>Pembimbing:</strong> Menjelaskan manfaat makanan sehat dan bergizi,
                                    mengajarkan tentang nutrisi dan cara membaca label nutrisi pada kemasan makanan</li>
                                <li><strong>Motivator:</strong> Memotivasi murid untuk terbiasa makan sehat dan bergizi,
                                    memberikan apresiasi kepada murid yang terbiasa makan sehat secara konsisten</li>
                                <li><strong>Evaluator:</strong> Bermitra dengan orang tua agar kebiasaan makan sehat
                                    berlanjut di rumah, menandatangani formulir pemantauan</li>
                            </ul>
                        </div>
                        <div class="role-card">
                            <h3><i class="fas fa-school"></i> Peran Satuan Pendidikan</h3>
                            <ul class="role-list">
                                <li><strong>Kebijakan:</strong> Mengembangkan dan menerapkan sistem apresiasi bagi murid
                                    yang telah menerapkan kebiasaan makan sehat dan bergizi</li>
                                <li><strong>Edukasi dan Sosialisasi:</strong> Mengundang narasumber ahli gizi, membuat
                                    media publikasi tentang manfaat kebiasaan makan sehat dan bergizi</li>
                                <li><strong>Kantin Sehat:</strong> Bekerja sama dengan pengelola kantin untuk
                                    menyediakan makanan sehat dan bergizi, memberi label atau stiker khusus pada makanan
                                    sehat</li>
                                <li><strong>Lingkungan Sehat:</strong> Menciptakan lingkungan satuan pendidikan yang
                                    sehat, menyediakan fasilitas yang mendukung kebiasaan makan sehat</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Landing Page for Gemar Belajar -->
    <div id="gemar-belajar-landing" class="landing-page">
        <div class="landing-content">
            <div class="landing-header">
                <button class="back-btn" id="back-from-gemar-belajar">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <h1>Gemar Belajar</h1>
                <p>Kebiasaan menambah pengetahuan, keterampilan, dan wawasan dengan senang, antusias, dan berkeinginan
                    kuat</p>
            </div>

            <div class="landing-section fade-in">
                <h2>Definisi</h2>
                <div class="definition-box">
                    <p>Gemar belajar adalah kebiasaan atau sikap seseorang untuk <strong>terus menambah pengetahuan,
                            keterampilan, atau wawasan</strong> baru dengan rasa senang, antusias, dan berkeinginan
                        kuat.</p>
                </div>
                <div class="quote-box">
                    <p>"Belajar adalah kunci untuk membuka pintu masa depan yang lebih cerah."</p>
                    <div class="quote-author">- Ki Hajar Dewantara</div>
                </div>
            </div>

            <div class="landing-section fade-in delay-1">
                <h2>Pentingnya Gemar Belajar</h2>
                <p>Kebiasaan gemar belajar penting karena membantu perkembangan murid untuk mencapai kesuksesan. Murid
                    dapat memperluas wawasan, meningkatkan keterampilan, dan lebih siap menghadapi tantangan.</p>
                <p>Kebiasaan gemar belajar dapat mengasah kepercayaan diri dan daya juang murid. Karena membuat lebih
                    adaptif dalam berbagai situasi, tidak takut gagal, atau memandang kegagalan sebagai sebuah proses
                    pembelajaran.</p>
                <p>Kebiasaan gemar belajar membuka lebih banyak peluang di masa depan, baik dalam pendidikan maupun
                    karir karena murid yang gemar belajar lebih adaptif dan kreatif dalam menemukan solusi.</p>
            </div>

            <div class="landing-section fade-in delay-2">
                <h2>Manfaat Gemar Belajar</h2>
                <div class="benefits-grid">
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <h3>Pengembangan Diri</h3>
                        <p>Murid yang gemar belajar selain pengetahuan dan keterampilannya akan bertambah, karakter
                            mereka juga semakin kuat.</p>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h3>Menumbuhkan Kreativitas dan Imajinasi</h3>
                        <p>Murid yang gemar belajar memiliki keberanian untuk bertanya, mencoba hal baru, berpikir di
                            luar kebiasaan, mengeksplorasi ide-ide baru.</p>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3>Menemukan Kebenaran dan Pengetahuan</h3>
                        <p>Murid yang gemar belajar akan terbiasa untuk menemukan kebenaran dan pemahaman yang lebih
                            dalam.</p>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-hands-helping"></i>
                        </div>
                        <h3>Membentuk Kerendahan Hati dan Empati</h3>
                        <p>Murid yang gemar belajar akan menyadari bahwa ada banyak hal yang belum diketahui. Sikap ini
                            membentuk kerendahan hati.</p>
                    </div>
                </div>
            </div>

            <div class="landing-section fade-in delay-3">
                <h2>Cara Penerapan di Sekolah</h2>
                <div class="implementation-steps-landing">
                    <div class="implementation-step">
                        <div class="step-number">1</div>
                        <div class="step-content-landing">
                            <h3>Menumbuhkan Rasa Ingin Tahu</h3>
                            <p>Dorong murid untuk selalu bertanya dan mencari tahu jawabannya dari berbagai macam
                                sumber. Misalnya: buku, internet, diskusi, atau mengikuti seminar/webinar.</p>
                        </div>
                    </div>
                    <div class="implementation-step">
                        <div class="step-number">2</div>
                        <div class="step-content-landing">
                            <h3>Membuat Jadwal Belajar</h3>
                            <p>Ajak murid untuk menyusun jadwal belajar yang rutin setiap hari. Misalnya: gunakan metode
                                "tema harian" dengan fokus berbeda setiap hari.</p>
                        </div>
                    </div>
                    <div class="implementation-step">
                        <div class="step-number">3</div>
                        <div class="step-content-landing">
                            <h3>Belajar dengan Metode Menyenangkan</h3>
                            <p>Ajak murid belajar dengan metode pembelajaran yang aktif dan kreatif. Misalnya: menonton
                                video edukasi, peta pikiran, eksperimen langsung, diskusi.</p>
                        </div>
                    </div>
                    <div class="implementation-step">
                        <div class="step-number">4</div>
                        <div class="step-content-landing">
                            <h3>Bergabung dengan Kelompok Belajar</h3>
                            <p>Dorong murid untuk berdiskusi bertukar pemahaman atau mengikuti komunitas/kelompok
                                belajar yang ada di sekolahnya.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="landing-section fade-in delay-4">
                <h2>Peran Guru dan Satuan Pendidikan</h2>
                <div class="role-section">
                    <div class="role-grid">
                        <div class="role-card">
                            <h3><i class="fas fa-user-tie"></i> Peran Guru</h3>
                            <ul class="role-list">
                                <li><strong>Teladan:</strong> Membiasakan diri untuk meningkatkan kompetensi sebagai
                                    guru, memberi contoh langsung yang dilakukan dalam pembelajaran di kelas</li>
                                <li><strong>Pembimbing:</strong> Mengenali minat dan potensi murid, menggunakan metode
                                    pembelajaran yang beragam dan interaktif, mengajarkan cara belajar yang efektif</li>
                                <li><strong>Motivator:</strong> Menciptakan lingkungan kelas yang aman dan nyaman,
                                    memotivasi murid untuk bertanya dan menganalisis, memberikan apresiasi untuk usaha
                                    dan keberhasilan</li>
                                <li><strong>Evaluator:</strong> Menandatangani formulir pemantauan, berkolaborasi dengan
                                    orang tua/wali tentang upaya yang harus dilakukan untuk meningkatkan kebiasaan gemar
                                    belajar</li>
                            </ul>
                        </div>
                        <div class="role-card">
                            <h3><i class="fas fa-school"></i> Peran Satuan Pendidikan</h3>
                            <ul class="role-list">
                                <li><strong>Kebijakan:</strong> Menyediakan ekstrakurikuler karya ilmiah, mengembangkan
                                    dan menerapkan sistem penghargaan bagi murid yang telah menerapkan kebiasaan gemar
                                    belajar</li>
                                <li><strong>Edukasi dan Sosialisasi:</strong> Membuat media publikasi tentang manfaat
                                    kebiasaan gemar belajar, mengundang narasumber ahli, mengadakan kelas Inspirasi</li>
                                <li><strong>Aktivitas:</strong> Melibatkan murid pada berbagai aktivitas lomba atau
                                    kompetisi di dalam dan di luar sekolah yang mendukung penerapan kebiasaan gemar
                                    belajar</li>
                                <li><strong>Sarana dan Prasarana:</strong> Menyediakan perpustakaan, pojok literasi,
                                    pojok baca, menciptakan lingkungan yang nyaman untuk mendukung murid gemar belajar
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Landing Page for Bermasyarakat -->
    <div id="bermasyarakat-landing" class="landing-page">
        <div class="landing-content">
            <div class="landing-header">
                <button class="back-btn" id="back-from-bermasyarakat">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <h1>Bermasyarakat</h1>
                <p>Interaksi sosial, kerja sama, dan keterlibatan dalam kegiatan sosial, budaya, atau lingkungan</p>
            </div>

            <div class="landing-section fade-in">
                <h2>Definisi</h2>
                <div class="definition-box">
                    <p>Bermasyarakat adalah kebiasaan individu yang saling <strong>berinteraksi, bekerja sama, dan
                            berperan sosial</strong> serta terlibat dalam kegiatan sosial, budaya, atau lingkungan untuk
                        menciptakan kehidupan yang harmonis dan saling mendukung.</p>
                </div>
                <div class="quote-box">
                    <p>"Semakin kita peduli terhadap sesama, semakin kuat pula ikatan dalam masyarakat kita."</p>
                    <div class="quote-author">- Abdurrahman Wahid (Gus Dur)</div>
                </div>
            </div>

            <div class="landing-section fade-in delay-1">
                <h2>Pentingnya Bermasyarakat</h2>
                <p>Aktivitas bermasyarakat penting dilakukan oleh murid karena dapat membantu meluangkan waktu yang
                    bermanfaat bagi orang lain dan lingkungan.</p>
                <p>Aktivitas bermasyarakat gotong royong membantu sesama, kesadaran saling memberi, membangun kerja sama
                    yang baik, kepedulian pada lingkungan dan aktif berkontribusi pada kegiatan yang diselenggarkan
                    satuan pendidikan.</p>
                <p>Mengajarkan kebiasaan bermasyarakat kepada murid, membantu membentuk karakter mereka dalam
                    bertanggung jawab dan menghargai individu lain, memunculkan rasa empati, memahami nilai kesetaraan
                    bagi sesama, dan memumbuhkan kemampuan interpersonal.</p>
            </div>

            <div class="landing-section fade-in delay-2">
                <h2>Manfaat Bermasyarakat</h2>
                <div class="benefits-grid">
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-hands-helping"></i>
                        </div>
                        <h3>Nilai Gotong Royong dan Kerja Sama</h3>
                        <p>Manusia hidup berdampingan untuk saling membantu dan meringankan beban satu sama lain agar
                            tercapai tujuan bersama.</p>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h3>Nilai Saling Menghormati dan Toleransi</h3>
                        <p>Bermasyarakat mengharuskan setiap individu menghormati keberagaman dalam keyakinan, budaya,
                            dan nilai.</p>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                        <h3>Nilai Keadilan dan Kesetaraan</h3>
                        <p>Setiap anggota masyarakat berhak mendapatkan perlakuan yang adil, tanpa diskriminasi, dan
                            memiliki kesempatan yang sama.</p>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <h3>Tanggung Jawab terhadap Lingkungan</h3>
                        <p>Setiap individu tidak hanya bertanggung jawab atas kesejahteraan diri sendiri, tetapi juga
                            harus peduli pada kesejahteraan bersama dan kelestarian lingkungan.</p>
                    </div>
                </div>
            </div>

            <div class="landing-section fade-in delay-3">
                <h2>Cara Penerapan di Sekolah</h2>
                <div class="implementation-steps-landing">
                    <div class="implementation-step">
                        <div class="step-number">1</div>
                        <div class="step-content-landing">
                            <h3>Pembelajaran Berbasis Praktik</h3>
                            <p>Pembelajaran berbasis praktik dapat membantu murid menemukan permasalahan di sekitar
                                mereka dan mencari solusi sesuai dengan kontribusi jenjang usia mereka.</p>
                        </div>
                    </div>
                    <div class="implementation-step">
                        <div class="step-number">2</div>
                        <div class="step-content-landing">
                            <h3>Interaksi Sosial</h3>
                            <p>Ciptakan aktivitas yang melibatkan kerja sama antar murid melalui tugas belajar
                                berkelompok yang memungkinkan murid untuk berinteraksi dengan masyarakat sekitar
                                sekolah.</p>
                        </div>
                    </div>
                    <div class="implementation-step">
                        <div class="step-number">3</div>
                        <div class="step-content-landing">
                            <h3>Aktivitas Sosial</h3>
                            <p>Aktivitas sosial dapat membantu membentuk karakter sosial dan empati bagi murid. Bentuk
                                aktivitas sosial bisa berupa: bermain dan belajar bersama saat mengunjungi panti asuhan,
                                melibatkan murid untuk melakukan bakti sosial.</p>
                        </div>
                    </div>
                    <div class="implementation-step">
                        <div class="step-number">4</div>
                        <div class="step-content-landing">
                            <h3>Permainan Tradisional</h3>
                            <p>Permainan tradisional seperti gobak sodor, engklek, bakiak balap dapat melatih kerja
                                sama, meningkatkan komunikasi, dan menumbuhkan empati.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="landing-section fade-in delay-4">
                <h2>Peran Guru dan Satuan Pendidikan</h2>
                <div class="role-section">
                    <div class="role-grid">
                        <div class="role-card">
                            <h3><i class="fas fa-user-tie"></i> Peran Guru</h3>
                            <ul class="role-list">
                                <li><strong>Teladan:</strong> Membiasakan diri untuk aktif bermasyarakat, saling menyapa
                                    kepada orang lain, berbagi, dan membantu sesama, terlibat langsung dalam kegiatan
                                    kerja bakti</li>
                                <li><strong>Pembimbing:</strong> Melibatkan murid dalam kegiatan sosial, mengajak murid
                                    untuk berdiskusi tentang isu-isu sosial, mengajarkan tata krama dan etika
                                    bersosialisasi</li>
                                <li><strong>Motivator:</strong> Memotivasi murid untuk melakukan pertemanan sehat,
                                    memotivasi murid untuk terlibat dalam organisasi, memberikan apresiasi bagi murid
                                    ketika membantu teman</li>
                                <li><strong>Evaluator:</strong> Berkolaborasi dengan orang tua/wali tentang upaya yang
                                    harus dilakukan untuk meningkatkan kebiasaan bermasyarakat, menandatangani formulir
                                    pemantauan</li>
                            </ul>
                        </div>
                        <div class="role-card">
                            <h3><i class="fas fa-school"></i> Peran Satuan Pendidikan</h3>
                            <ul class="role-list">
                                <li><strong>Kebijakan:</strong> Membuat program mentoring agar murid saling membantu
                                    dalam hal akademik maupun sosial, membersihkan lingkungan sekolah dengan kelompok
                                    lintas kelas</li>
                                <li><strong>Sistem Penghargaan:</strong> Mengembangkan dan menerapkan sistem penghargaan
                                    bagi murid yang telah menerapkan kebiasaan bermasyarakat</li>
                                <li><strong>Edukasi dan Sosialisasi:</strong> Mengundang narasumber dari unsur tokoh
                                    masyarakat, membuat media publikasi tentang kebiasaan bermasyarakat, mengadakan
                                    kelas inspirasi</li>
                                <li><strong>Kolaborasi:</strong> Bekerja sama dengan orang tua/wali untuk turut aktif
                                    membimbing dan memantau penerapan kebiasaan bermasyarakat di lingkungan rumah</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Landing Page for Tidur Cepat -->
    <div id="tidur-cepat-landing" class="landing-page">
        <div class="landing-content">
            <div class="landing-header">
                <button class="back-btn" id="back-from-tidur-cepat">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <h1>Tidur Cepat</h1>
                <p>Kebiasaan tidur tepat waktu dan tidak larut malam sesuai kebutuhan ideal waktu tidur anak</p>
            </div>

            <div class="landing-section fade-in">
                <h2>Definisi</h2>
                <div class="definition-box">
                    <p>Tidur cepat merupakan kebiasaan <strong>tidur tepat waktu secara teratur dan tidak larut
                            malam</strong>, yang disesuaikan dengan kebutuhan ideal waktu tidur anak, agar dapat bangun
                        pagi.</p>
                </div>
                <div class="quote-box">
                    <p>"Tidur yang cukup di malam hari adalah fondasi untuk hari yang produktif dan tubuh yang sehat."
                    </p>
                    <div class="quote-author">- R.A. Kartini</div>
                </div>
            </div>

            <div class="landing-section fade-in delay-1">
                <h2>Pentingnya Tidur Cepat</h2>
                <p>Kebiasaan tidur cepat di awal waktu akan membantu anak mendapatkan durasi tidur yang cukup dan
                    berkualitas serta membantu tubuh dan otak melakukan regenerasi dan pemulihan.</p>
                <p>Sehingga anak merasa segar, bersemangat, dan siap untuk belajar serta bermain keesokan harinya.</p>
                <p>Selain itu murid yang kurang tidur cenderung lebih mudah marah dan mengalami masalah dalam
                    berinteraksi dengan orang lain. Tidur yang cukup dapat membantu mengurangi konflik sosial.</p>
            </div>

            <div class="landing-section fade-in delay-2">
                <h2>Manfaat Tidur Cepat</h2>
                <div class="benefits-grid">
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <h3>Organ Tubuh Pulih dan Berfungsi Optimal</h3>
                        <p>Tubuh sebagai anugerah Tuhan harus dijaga dengan memberi waktu istirahat bagi tubuh dan
                            pikiran untuk pulih dan berfungsi secara optimal.</p>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-brain"></i>
                        </div>
                        <h3>Memulihkan Mental dan Emosional</h3>
                        <p>Tidur cepat sebagai sarana untuk mengurangi stres, menenangkan pikiran, dan menjaga kesehatan
                            jiwa.</p>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                        <h3>Keseimbangan Aktivitas dan Ketenangan</h3>
                        <p>Tidur cepat memberikan waktu untuk memulihkan tubuh dan pikiran, serta memberikan kesempatan
                            untuk menciptakan keharmonisan.</p>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3>Meningkatkan Produktivitas</h3>
                        <p>Tidur cepat memberikan ruang bagi otak untuk berpikir lebih jernih dan kreatif. Produktivitas
                            tidak selalu diperoleh melalui kerja keras tanpa henti.</p>
                    </div>
                </div>
            </div>

            <div class="landing-section fade-in delay-3">
                <h2>Cara Penerapan di Sekolah</h2>
                <div class="implementation-steps-landing">
                    <div class="implementation-step">
                        <div class="step-number">1</div>
                        <div class="step-content-landing">
                            <h3>Edukasi tentang Pentingnya Tidur</h3>
                            <p>Memberikan pengetahuan tentang pentingnya tidur cepat dan cukup untuk perkembangan fisik,
                                mental, dan emosional murid.</p>
                        </div>
                    </div>
                    <div class="implementation-step">
                        <div class="step-number">2</div>
                        <div class="step-content-landing">
                            <h3>Pembatasan Tugas</h3>
                            <p>Memotivasi untuk tidak terlalu membebani diri dengan tugas yang berlebihan dan mendorong
                                murid untuk mengambil waktu istirahat jika merasa jenuh atau lelah.</p>
                        </div>
                    </div>
                    <div class="implementation-step">
                        <div class="step-number">3</div>
                        <div class="step-content-landing">
                            <h3>Pembatasan Penggunaan Gadget</h3>
                            <p>Mengajak murid untuk berdiskusi mengenai bagaimana cara mengatur waktu dengan bijak dan
                                pembatasan waktu dalam penggunaan gawai agar tubuh dapat istirahat secara optimal.</p>
                        </div>
                    </div>
                    <div class="implementation-step">
                        <div class="step-number">4</div>
                        <div class="step-content-landing">
                            <h3>Sistem Penghargaan</h3>
                            <p>Mengembangkan dan menerapkan sistem penghargaan bagi murid yang telah menerapkan
                                kebiasaan tidur cepat.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="landing-section fade-in delay-4">
                <h2>Peran Guru dan Satuan Pendidikan</h2>
                <div class="role-section">
                    <div class="role-grid">
                        <div class="role-card">
                            <h3><i class="fas fa-user-tie"></i> Peran Guru</h3>
                            <ul class="role-list">
                                <li><strong>Teladan:</strong> Membiasakan diri untuk tidur cepat, memberikan contoh pola
                                    hidup sehat dengan istirahat yang cukup</li>
                                <li><strong>Pembimbing:</strong> Memberikan pengetahuan tentang pentingnya tidur cepat
                                    dan cukup, mengajarkan pentingnya tidur cepat dikaitkan dalam materi pembelajaran
                                </li>
                                <li><strong>Motivator:</strong> Memotivasi untuk tidak terlalu membebani diri dengan
                                    tugas yang berlebihan, mengembangkan sistem penghargaan bagi murid yang menerapkan
                                    kebiasaan tidur cepat</li>
                                <li><strong>Evaluator:</strong> Menandatangani formulir pemantauan, berkolaborasi dengan
                                    orang tua/wali untuk berdiskusi tentang upaya peningkatan kebiasaan tidur cepat</li>
                            </ul>
                        </div>
                        <div class="role-card">
                            <h3><i class="fas fa-school"></i> Peran Satuan Pendidikan</h3>
                            <ul class="role-list">
                                <li><strong>Kebijakan:</strong> Mengembangkan dan menerapkan sistem penghargaan bagi
                                    murid yang telah menerapkan kebiasaan tidur cepat</li>
                                <li><strong>Kolaborasi:</strong> Bekerja sama dengan orang tua/wali untuk turut aktif
                                    membimbing dan memantau penerapan kebiasaan tidur cepat di rumah</li>
                                <li><strong>Edukasi dan Sosialisasi:</strong> Mengundang narasumber dari unsur guru,
                                    orang tua, alumni, atau pakar untuk menjelaskan tentang manfaat dan cara menerapkan
                                    kebiasaan tidur cepat</li>
                                <li><strong>Media Publikasi:</strong> Membuat media publikasi tentang manfaat kebiasaan
                                    tidur cepat yang disebarluaskan melalui media sosial atau di sekitar lingkungan
                                    satuan pendidikan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="landing-section fade-in delay-5">
                <h2>Kebutuhan Tidur Sesuai Usia</h2>
                <div style="background:#f9f9f9; padding:1.5rem; border-radius:10px;">
                    <h3 style="margin-bottom:1rem;">Rekomendasi Waktu Tidur</h3>
                    <ul style="list-style-type:none; padding:0;">
                        <li style="padding:0.5rem 0; border-bottom:1px solid #eee;"><strong>6-12 tahun:</strong> 10 jam
                            per hari</li>
                        <li style="padding:0.5rem 0; border-bottom:1px solid #eee;"><strong>12-18 tahun:</strong> 8-9
                            jam per hari</li>
                        <li style="padding:0.5rem 0;"><strong>Dewasa (18+):</strong> 7-8 jam per hari</li>
                    </ul>
                    <p style="margin-top:1rem; font-style:italic; font-size:0.9rem;">Sumber: Kementerian Kesehatan
                        Republik Indonesia</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Toggle mobile menu
        const hamburger = document.querySelector('.hamburger');
        const navLinks = document.querySelector('.nav-links');

        hamburger.addEventListener('click', () => {
            navLinks.style.display = navLinks.style.display === 'flex' ? 'none' : 'flex';
        });

        // Close mobile menu when clicking on a link
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 768) {
                    navLinks.style.display = 'none';
                }
            });
        });

        // Fade in elements on scroll
        const fadeElements = document.querySelectorAll('.fade-in');

        const fadeInOnScroll = () => {
            fadeElements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                const elementVisible = 150;

                if (elementTop < window.innerHeight - elementVisible) {
                    element.style.opacity = 1;
                    element.style.transform = 'translateY(0)';
                }
            });
        };

        // Initialize
        window.addEventListener('scroll', fadeInOnScroll);
        window.addEventListener('load', fadeInOnScroll);

        // Function to show landing page
        function showLandingPage(landingId) {
            document.getElementById('main-content').style.display = 'none';
            document.getElementById(landingId).style.display = 'block';
            window.scrollTo(0, 0);
        }

        // Function to hide landing page and return to main content
        function hideLandingPage(landingId) {
            document.getElementById(landingId).style.display = 'none';
            document.getElementById('main-content').style.display = 'block';
        }

        // Event listeners for habit cards
        document.getElementById('bangun-pagi-card').addEventListener('click', () => {
            showLandingPage('bangun-pagi-landing');
        });

        document.getElementById('beribadah-card').addEventListener('click', () => {
            showLandingPage('beribadah-landing');
        });

        document.getElementById('berolahraga-card').addEventListener('click', () => {
            showLandingPage('berolahraga-landing');
        });

        document.getElementById('makan-sehat-card').addEventListener('click', () => {
            showLandingPage('makan-sehat-landing');
        });

        document.getElementById('gemar-belajar-card').addEventListener('click', () => {
            showLandingPage('gemar-belajar-landing');
        });

        document.getElementById('bermasyarakat-card').addEventListener('click', () => {
            showLandingPage('bermasyarakat-landing');
        });

        document.getElementById('tidur-cepat-card').addEventListener('click', () => {
            showLandingPage('tidur-cepat-landing');
        });

        // Event listeners for back buttons
        document.getElementById('back-from-bangun-pagi').addEventListener('click', () => {
            hideLandingPage('bangun-pagi-landing');
        });

        document.getElementById('back-from-beribadah').addEventListener('click', () => {
            hideLandingPage('beribadah-landing');
        });

        document.getElementById('back-from-berolahraga').addEventListener('click', () => {
            hideLandingPage('berolahraga-landing');
        });

        document.getElementById('back-from-makan-sehat').addEventListener('click', () => {
            hideLandingPage('makan-sehat-landing');
        });

        document.getElementById('back-from-gemar-belajar').addEventListener('click', () => {
            hideLandingPage('gemar-belajar-landing');
        });

        document.getElementById('back-from-bermasyarakat').addEventListener('click', () => {
            hideLandingPage('bermasyarakat-landing');
        });

        document.getElementById('back-from-tidur-cepat').addEventListener('click', () => {
            hideLandingPage('tidur-cepat-landing');
        });

        // Return to main content when logo is clicked
        document.getElementById('main-logo').addEventListener('click', () => {
            const landingPages = document.querySelectorAll('.landing-page');
            landingPages.forEach(page => {
                page.style.display = 'none';
            });
            document.getElementById('main-content').style.display = 'block';
            window.scrollTo(0, 0);
        });
    </script>
</body>

</html>
