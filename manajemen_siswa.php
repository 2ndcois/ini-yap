<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Sekolah - SMKN 1 Tenggarong</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="manajemen_siswa.css">
    <style>
        .edit-profile-diri {
            display: block;
            width: 80%;
            margin: 10px auto 0 auto;
            /* Tengah dan sedikit jarak dari atas */
            padding: 5px 10px;
            background-color: var(--accent-yellow);
            /* Warna kuning cerah */
            color: var(--text-dark);
            /* Teks hitam */
            border: none;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.2s;
        }

        .edit-profile-diri:hover {
            background-color: #ffb300;
        }
    </style>

</head>

<body>
    <div class="wrapper">

        <div class="sidebar">
            <div class="sidebar-header">SMKN 1 TENGGARONG</div>
            <div class="profile-section">
                <img src="profil dashboard.jpg" alt="Foto Profil" class="profile-pic">
                <p class="profile-name">Rahmat Alfarizi</p>
                <small class="profile-role">Admin</small>

                <a href="profil.php" class="edit-profile-diri">
                    <i class="fas fa-edit"></i> Edit Profil
                </a>
            </div>

            <div class="menu">
                <a href="manajemen_siswa.php" class="menu-item active">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
                <a href="jadwal.php" class="menu-item">
                    <i class="fas fa-calendar-alt"></i> Jadwal Pelajaran
                </a>
                <a href="testing.php" class="menu-item">
                    <i class="fas fa-user-graduate"></i> Data Siswa
                </a>
                <a href="tugas.php" class="menu-item">
                    <i class="fas fa-ticket-alt"></i> Daftar Tugas
                </a>
                <a href="kelompok.php" class="menu-item">
                    <i class="fas fa-users"></i> Kelompok
                </a>
            </div>

            <div class="logout-section">
                <a href="#" class="menu-item">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>

        <div class="sidebar-overlay" id="sidebar-overlay"></div>
        
        <div class="page-content-wrapper">

            <div class="navbar-top">
                <div class="page-title">
                    <i class="fas fa-bars menu-toggle" id="menu-toggle"></i>
                    <h2>Profil Sekolah</h2>
                </div>
            </div>
            <div class="main-content-area">

                <div class="stats-grid">
                    <div class="stat-card" style="border-left: 5px solid #007bff;">
                        <div class="stat-info">
                            <div class="stat-number">1330</div>
                            <div class="stat-label">Jumlah Siswa</div>
                        </div>
                        <i class="fas fa-user-graduate stat-icon blue"></i>
                    </div>

                    <div class="stat-card" style="border-left: 5px solid #ffc107;">
                        <div class="stat-info">
                            <div class="stat-number">B</div>
                            <div class="stat-label">Akreditasi</div>
                        </div>
                        <i class="fas fa-medal stat-icon yellow"></i>
                    </div>

                    <div class="stat-card" style="border-left: 5px solid #28a745;">
                        <div class="stat-info">
                            <div class="stat-number">20+</div>
                            <div class="stat-label">Eskul Pilihan</div>
                        </div>
                        <i class="fas fa-trophy stat-icon green"></i>
                    </div>

                    <div class="stat-card bright-green-bg">
                        <div class="stat-info">
                            <div class="stat-number">7</div>
                            <div class="stat-label">Jurusan</div>
                        </div>
                        <i class="fas fa-code-branch stat-icon"></i>
                    </div>
                </div>
                <div class="data-container">

                    <div class="profile-card">
                        <h3 class="title-red">Tentang SMK Negeri 1 Tenggarong</h3>
                        <p>SMK Negeri 1 Tenggarong adalah salah satu institusi pendidikan kejuruan negeri yang
                            terkemuka di Kabupaten Kutai Kartanegara, Kalimantan Timur. Sekolah ini didirikan
                            pada tahun 1979 dengan nama awal Sekolah Menengah Ekonomi Atas (SMEA) Negeri
                            Tenggarong, yang menunjukkan fokus awalnya pada bidang ekonomi, keuangan, dan
                            administrasi.</p>
                        <p>Sekolah ini terus beradaptasi dengan menerapkan Kurikulum Merdeka untuk menghasilkan
                            lulusan yang relevan dengan kebutuhan Dunia Usaha dan Dunia Industri (DUDI) saat ini.</p>
                    </div>

                    <div class="profile-grid">
                        <div class="profile-card">
                            <h4 class="title-yellow"><i class="fas fa-info-circle"></i> Data Lengkap Sekolah</h4>
                            <ul class="data-list">
                                <li><strong>NPSN:</strong> 30405294</li>
                                <li><strong>Status Sekolah:</strong> Negeri (Pemerintah Daerah)</li>
                                <li><strong>Bentuk Pendidikan:</strong> SMK</li>
                                <li><strong>Tahun Berdiri:</strong> 1979</li>
                                <li><strong>Akreditasi:</strong> B (Tahun 2020)</li>
                                <li><strong>Kepala Sekolah:</strong> Stefanus Batas</li>
                                <li><strong>Kurikulum:</strong> Kurikulum Merdeka</li>
                                <li><strong>Jumlah Rombel:</strong> 32</li>
                                <li><strong>Luas Tanah:</strong> 20.000 M$^2$</li>
                            </ul>
                        </div>

                        <div class="profile-card">
                            <h4 class="title-yellow"><i class="fas fa-map-marker-alt"></i> Lokasi & Kontak</h4>
                            <ul class="data-list">
                                <li><strong>Alamat:</strong> Jl. KH. Ahmad Dahlan No. 49</li>
                                <li><strong>Lurah/Kecamatan:</strong> Kampung Baru, Tenggarong</li>
                                <li><strong>Kabupaten/Kota:</strong> Kutai Kartanegara</li>
                                <li><strong>Provinsi:</strong> Kalimantan Timur</li>
                                <li><strong>Kode Pos:</strong> 75516</li>
                                <li><strong>Nomor Telepon:</strong> (0541) 66127</li>
                            </ul>
                        </div>
                    </div>

                    <div class="profile-card program-keahlian">
                        <h3 class="title-red">Program Keahlian (Jurusan)</h3>
                        <p class="mb-3">SMK Negeri 1 Tenggarong memiliki fokus kuat pada bidang bisnis,
                            manajemen, dan teknologi. Berikut program keahlian yang diselenggarakan:</p>

                        <div class="jurusan-list-grid">
                            <div class="jurusan-item">
                                <h5>Pemasaran (PM)</h5>
                                <span>Mempersiapkan siswa untuk berwirausaha dan bekerja di bidang pemasaran
                                    konvensional maupun digital.</span>
                            </div>
                            <div class="jurusan-item">
                                <h5>Akuntansi dan Keuangan Lembaga (AKL)</h5>
                                <span>Fokus pada pencatatan, pengelolaan transaksi keuangan, perpajakan, dan
                                    pelaporan keuangan.</span>
                            </div>
                            <div class="jurusan-item">
                                <h5>Manajemen Perkantoran dan Layanan Bisnis (MPLB)</h5>
                                <span>Keterampilan administrasi profesional, pengelolaan dokumen digital/fisik,
                                    dan teknologi perkantoran modern.</span>
                            </div>
                            <div class="jurusan-item">
                                <h5>Teknik Komputer dan Jaringan (TKJ)</h5>
                                <span>Instalasi, pemeliharaan, dan perbaikan perangkat keras komputer, jaringan,
                                    dan sistem operasi.</span>
                            </div>
                            <div class="jurusan-item">
                                <h5>Tata Boga</h5>
                                <span>Melatih siswa dalam teknik memasak, penyajian makanan, dan manajemen dapur
                                    profesional.</span>
                            </div>
                            <div class="jurusan-item">
                                <h5>Perhotelan (PH)</h5>
                                <span>Membentuk siswa agar siap bekerja di hotel, restoran, kapal pesiar, atau
                                    bidang hospitality lainnya.</span>
                            </div>
                            <div class="jurusan-item">
                                <h5>Rekayasa Perangkat Lunak (RPL)</h5>
                                <span>Membentuk siswa agar siap menjadi programmer, web developer, software
                                    engineer, atau pengembang aplikasi.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const toggle = document.getElementById("menu-toggle");
        const sidebar = document.querySelector(".sidebar");
        const overlay = document.getElementById("sidebar-overlay");

        toggle.addEventListener("click", () => {
            sidebar.classList.toggle("active");
            overlay.classList.toggle("active");
        });

        overlay.addEventListener("click", () => {
            sidebar.classList.remove("active");
            overlay.classList.remove("active");
        });
    </script>

</body>

</html>