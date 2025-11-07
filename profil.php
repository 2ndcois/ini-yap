<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Data Diri - SMKN 1 Tenggarong</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style2.css"> 
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
            /* Kuning sedikit lebih gelap saat hover */
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
                <a href="manajemen_siswa.php" class="menu-item">
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

        <div class="page-content-wrapper"> 
            
            <div class="navbar-top">
                <div class="page-title">
                    <i class="fas fa-bars menu-toggle" id="menu-toggle"></i>
                    <h2>Profil Data Diri</h2> 
                </div>
            </div>
            
            <div class="main-content-area">

                <div class="data-container">
                    
                    <div class="profile-card">
                        <h3 class="title-red"><i class="fas fa-user-circle"></i> Informasi Dasar</h3>
                        <div class="profile-grid">
                            <div class="profile-card" style="margin-bottom: 0;">
                                <ul class="data-list">
                                    <li><strong>Nama Lengkap:</strong> Rahmat Alfarizi</li>
                                    <li><strong>NISN:</strong> 0045678901</li>
                                    <li><strong>Nomor Induk:</strong> 12345/001/2024</li>
                                    <li><strong>Jenis Kelamin:</strong> Laki-laki</li>
                                    <li><strong>Tempat, Tgl Lahir:</strong> Tenggarong, 18 Mei 2004</li>
                                    <li><strong>Agama:</strong> Islam</li>
                                </ul>
                            </div>
                            
                            <div class="profile-card" style="margin-bottom: 0;">
                                <ul class="data-list">
                                    <li><strong>Kelas / Rombel:</strong> XII RPL B</li>
                                    <li><strong>Jurusan:</strong> Rekayasa Perangkat Lunak (RPL)</li>
                                    <li><strong>Tahun Masuk:</strong> 2022</li>
                                    <li><strong>Status Siswa:</strong> Aktif</li>
                                    <li><strong>Wali Kelas:</strong> Bpk. Haryadi, S.Kom</li>
                                    <li><strong>Akun Akses:</strong> Admin</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="profile-card">
                        <h3 class="title-red"><i class="fas fa-home"></i> Alamat & Kontak</h3>
                        <div class="profile-grid">
                            <div class="profile-card" style="margin-bottom: 0;">
                                <ul class="data-list">
                                    <li><strong>Alamat Lengkap:</strong> Jl. Cendana No. 15 RT 05</li>
                                    <li><strong>Kelurahan:</strong> Kampung Baru</li>
                                    <li><strong>Kecamatan:</strong> Tenggarong</li>
                                    <li><strong>Kabupaten/Kota:</strong> Kutai Kartanegara</li>
                                    <li><strong>Kode Pos:</strong> 75516</li>
                                </ul>
                            </div>
                            <div class="profile-card" style="margin-bottom: 0;">
                                <ul class="data-list">
                                    <li><strong>Nomor HP Siswa:</strong> 0812-3456-7890</li>
                                    <li><strong>Email Siswa:</strong> rahmat.alfarizi@smkn1tgr.sch.id</li>
                                    <li style="height: 10px;"></li>
                                    <h4 class="title-yellow" style="margin-bottom: 5px;">Kontak Orang Tua</h4>
                                    <li><strong>Nama Ayah:</strong> Bpk. Sukarmin</li>
                                    <li><strong>Nomor HP Ayah:</strong> 0857-1122-3344</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>

</html>