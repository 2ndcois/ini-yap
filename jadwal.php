<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Pelajaran - SMKN 1 Tenggarong</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style2.css">
    <style>
        /* CSS Khusus untuk Halaman Jadwal */
        :root {
            /* Contoh variabel CSS dari style2.css, jika belum ada */
            --primary-red: #D32F2F;
            /* Merah primary */
            --accent-yellow: #FFC107;
            /* Kuning accent */
            --shadow-color: rgba(0, 0, 0, 0.1);
            --text-muted: #6c757d;
            --text-dark: #343a40;
            --light-red: #fde8e8;
            /* Merah muda sangat muda */
        }

        .jadwal-card {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px var(--shadow-color);
            margin-bottom: 20px;
        }

        .tab-menu {
            margin-bottom: 20px;
            border-bottom: 2px solid #eee;
        }

        .tab-menu button {
            background: none;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-weight: bold;
            color: var(--text-muted);
            border-bottom: 3px solid transparent;
            transition: all 0.3s;
        }

        .tab-menu button.active {
            color: var(--primary-red);
            border-bottom: 3px solid var(--accent-yellow);
        }

        /* Styling Tabel Jadwal */
        .table-jadwal {
            width: 100%;
            border-collapse: collapse;
            font-size: 1rem;
        }

        .table-jadwal th,
        .table-jadwal td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
        }

        .table-jadwal thead th {
            background-color: var(--primary-red);
            /* Header tabel merah */
            color: white;
            font-weight: 600;
            border-bottom: 2px solid var(--accent-yellow);
        }

        .table-jadwal tbody tr:hover {
            background-color: var(--light-red);
            /* Hover warna abu-abu muda/merah muda */
        }

        /* Highlight jam istirahat */
        .istirahat {
            background-color: #ffebee;
            /* Latar belakang sangat muda */
            font-weight: bold;
            color: var(--primary-red);
            text-align: center !important;
        }

        /* Highlight kegiatan pagi/ekstra */
        .kegiatan-khusus {
            background-color: #f3f9ff;
            /* Warna biru muda */
            font-weight: bold;
            color: var(--text-dark);
            text-align: center !important;
        }


        /* Judul Mata Pelajaran */
        .mata-pelajaran {
            color: var(--text-dark);
            font-weight: 600;
        }

        .guru-pengajar {
            font-size: 0.9rem;
            color: var(--text-muted);
            display: block;
        }

        /* Tambahkan style untuk judul card */
        .title-red {
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary-red);
            margin-bottom: 20px;
            color: var(--primary-red);
        }
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
                <a href="jadwal.php" class="menu-item active">
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
                    <h2>Jadwal Pelajaran Kelas XI RPL</h2>
                </div>
            </div>

            <div class="main-content-area">

                <div class="jadwal-card">
                    <h3 class="title-red" style="border-bottom-color: var(--primary-red);">Jadwal Kelas</h3>

                    <div class="tab-menu">
                        <button class="active" onclick="showTab(event, 'senin')">Senin</button>
                        <button onclick="showTab(event, 'selasa')">Selasa</button>
                        <button onclick="showTab(event, 'rabu')">Rabu</button>
                        <button onclick="showTab(event, 'kamis')">Kamis</button>
                        <button onclick="showTab(event, 'jumat')">Jumat</button>
                    </div>

                    <div id="senin" class="jadwal-tab-content">
                        <table class="table-jadwal">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">Jam Ke</th>
                                    <th style="width: 15%;">Waktu</th>
                                    <th style="width: 55%;">Mata Pelajaran / Kegiatan</th>
                                    <th style="width: 20%;">Ruangan / Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="kegiatan-khusus">
                                    <td>-</td>
                                    <td>07:00 - 08:00</td>
                                    <td>UPACARA BENDERA</td>
                                    <td>Lapangan Utama</td>
                                </tr>
                                <tr>
                                    <td>1-3</td>
                                    <td>08:00 - 10:00</td>
                                    <td><span class="mata-pelajaran">Kejuruan RPL</span><span class="guru-pengajar">Bu Fit</span></td>
                                    <td>Lab. Komputer RPL</td>
                                </tr>
                                <tr class="istirahat">
                                    <td colspan="4">ISTIRAHAT (10:00 - 10:20)</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>10:20 - 11:00</td>
                                    <td><span class="mata-pelajaran">Kejuruan RPL</span><span class="guru-pengajar">Bu Fit</span></td>
                                    <td>Lab. Komputer RPL</td>
                                </tr>
                                <tr>
                                    <td>5-6</td>
                                    <td>11:00 - 12:20</td>
                                    <td><span class="mata-pelajaran">Kejuruan RPL</span><span class="guru-pengajar">Bu Dinda</span></td>
                                    <td>Lab. Komputer RPL</td>
                                </tr>
                                <tr class="istirahat">
                                    <td colspan="4">ISHOMA (SHALAT DZUHUR) (12:20 - 13:00)</td>
                                </tr>
                                <tr>
                                    <td>7-10</td>
                                    <td>13:00 - 15:40</td>
                                    <td><span class="mata-pelajaran">Kejuruan RPL</span><span class="guru-pengajar">Pak Rian</span></td>
                                    <td>Lab. Komputer RPL</td>
                                </tr>
                                <tr class="kegiatan-khusus">
                                    <td>-</td>
                                    <td>15:40 - 16:40</td>
                                    <td>EKSTRAKURIKULER</td>
                                    <td>Sekolah</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div id="selasa" class="jadwal-tab-content" style="display: none;">
                        <table class="table-jadwal">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">Jam Ke</th>
                                    <th style="width: 15%;">Waktu</th>
                                    <th style="width: 55%;">Mata Pelajaran / Kegiatan</th>
                                    <th style="width: 20%;">Ruangan / Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="kegiatan-khusus">
                                    <td>-</td>
                                    <td>07:00 - 08:00</td>
                                    <td>SHOLAT DHUHA</td>
                                    <td>Lapangan Utama</td>
                                </tr>
                                <tr>
                                    <td>1-2</td>
                                    <td>08:00 - 09:20</td>
                                    <td><span class="mata-pelajaran">PJOK</span><span class="guru-pengajar">Pak Adi</span></td>
                                    <td>Lapangan / R. Kelas</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>09:20 - 10:00</td>
                                    <td><span class="mata-pelajaran">Bahasa Inggris</span><span class="guru-pengajar">Bu Santi</span></td>
                                    <td>R. Kelas</td>
                                </tr>
                                <tr class="istirahat">
                                    <td colspan="4">ISTIRAHAT (10:00 - 10:20)</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>10:20 - 11:00</td>
                                    <td><span class="mata-pelajaran">Bahasa Inggris</span><span class="guru-pengajar">Bu Santi</span></td>
                                    <td>R. Kelas</td>
                                </tr>
                                <tr>
                                    <td>5-7</td>
                                    <td>11:00 - 13:00</td>
                                    <td><span class="mata-pelajaran">Kejuruan RPL</span><span class="guru-pengajar">Pak Deka</span></td>
                                    <td>Lab. Komputer RPL</td>
                                </tr>
                                <tr class="istirahat">
                                    <td colspan="4">ISHOMA (SHALAT DZUHUR) (12:20 - 13:00) - Jam ke-7 sampai 13:00</td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>13:00 - 13:40</td>
                                    <td><span class="mata-pelajaran">Kejuruan RPL</span><span class="guru-pengajar">Pak Deka</span></td>
                                    <td>Lab. Komputer RPL</td>
                                </tr>
                                <tr>
                                    <td>8-10</td>
                                    <td>13:40 - 15:40</td>
                                    <td><span class="mata-pelajaran">Matematika, Informatika</span><span class="guru-pengajar">Bu Mariani</span></td>
                                    <td>R. Kelas / Lab. Komputer</td>
                                </tr>
                                <tr class="kegiatan-khusus">
                                    <td>-</td>
                                    <td>15:40 - 16:40</td>
                                    <td>EKSTRAKURIKULER</td>
                                    <td>Sekolah</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div id="rabu" class="jadwal-tab-content" style="display: none;">
                        <table class="table-jadwal">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">Jam Ke</th>
                                    <th style="width: 15%;">Waktu</th>
                                    <th style="width: 55%;">Mata Pelajaran / Kegiatan</th>
                                    <th style="width: 20%;">Ruangan / Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="kegiatan-khusus">
                                    <td>-</td>
                                    <td>07:00 - 08:00</td>
                                    <td>SHOLAT DHUHA</td>
                                    <td>Lapangan Utama</td>
                                </tr>
                                <tr>
                                    <td>1-3</td>
                                    <td>08:00 - 10:00</td>
                                    <td><span class="mata-pelajaran">Bahasa Indonesia</span><span class="guru-pengajar">Bu Sabar</span></td>
                                    <td>R. Kelas</td>
                                </tr>
                                <tr class="istirahat">
                                    <td colspan="4">ISTIRAHAT (10:00 - 10:20)</td>
                                </tr>
                                <tr>
                                    <td>4-6</td>
                                    <td>10:20 - 12:20</td>
                                    <td><span class="mata-pelajaran">Kejuruan RPL</span><span class="guru-pengajar">Pak Deka</span></td>
                                    <td>Lab. Komputer RPL</td>
                                </tr>
                                <tr class="istirahat">
                                    <td colspan="4">ISHOMA (SHALAT DZUHUR) (12:20 - 13:00)</td>
                                </tr>
                                <tr>
                                    <td>7-8</td>
                                    <td>13:00 - 14:20</td>
                                    <td><span class="mata-pelajaran">Bahasa Inggris</span><span class="guru-pengajar">Bu Santi</span></td>
                                    <td>R. Kelas</td>
                                </tr>
                                <tr>
                                    <td>9-10</td>
                                    <td>14:20 - 15:40</td>
                                    <td><span class="mata-pelajaran">PKn</span><span class="guru-pengajar">Bu Puji</span></td>
                                    <td>R. Kelas</td>
                                </tr>
                                <tr class="kegiatan-khusus">
                                    <td>-</td>
                                    <td>15:40 - 16:40</td>
                                    <td>EKSTRAKURIKULER</td>
                                    <td>Sekolah</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div id="kamis" class="jadwal-tab-content" style="display: none;">
                        <table class="table-jadwal">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">Jam Ke</th>
                                    <th style="width: 15%;">Waktu</th>
                                    <th style="width: 55%;">Mata Pelajaran / Kegiatan</th>
                                    <th style="width: 20%;">Ruangan / Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="kegiatan-khusus">
                                    <td>-</td>
                                    <td>07:00 - 08:00</td>
                                    <td>SHOLAT DHUHA</td>
                                    <td>Lapangan Utama</td>
                                </tr>
                                <tr>
                                    <td>1-3</td>
                                    <td>08:00 - 10:00</td>
                                    <td><span class="mata-pelajaran">Kejuruan RPL</span><span class="guru-pengajar">Bu Dinda</span></td>
                                    <td>Lab. Komputer RPL</td>
                                </tr>
                                <tr class="istirahat">
                                    <td colspan="4">ISTIRAHAT (10:00 - 10:20)</td>
                                </tr>
                                <tr>
                                    <td>4-8</td>
                                    <td>10:20 - 13:40</td>
                                    <td><span class="mata-pelajaran">Kejuruan RPL</span><span class="guru-pengajar">Pak Deka</span></td>
                                    <td>Lab. Komputer RPL</td>
                                </tr>
                                <tr class="istirahat">
                                    <td colspan="4">ISHOMA (SHALAT DZUHUR) (12:20 - 13:00) - Jam ke-7 sampai 13:00</td>
                                </tr>
                                <tr>
                                    <td>9-11</td>
                                    <td>13:40 - 15:40</td>
                                    <td><span class="mata-pelajaran">Pendidikan Agama Islam</span><span class="guru-pengajar">Bu Nanik</span></td>
                                    <td>R. Kelas</td>
                                </tr>
                                <tr class="kegiatan-khusus">
                                    <td>-</td>
                                    <td>15:40 - 16:40</td>
                                    <td>EKSTRAKURIKULER</td>
                                    <td>Sekolah</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div id="jumat" class="jadwal-tab-content" style="display: none;">
                        <table class="table-jadwal">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">Jam Ke</th>
                                    <th style="width: 15%;">Waktu</th>
                                    <th style="width: 55%;">Mata Pelajaran / Kegiatan</th>
                                    <th style="width: 20%;">Ruangan / Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="kegiatan-khusus">
                                    <td>-</td>
                                    <td>07:00 - 08:00</td>
                                    <td>SENAM KESEGARAN JASMANI</td>
                                    <td>Lapangan Sekolah</td>
                                </tr>
                                <tr>
                                    <td>1-2</td>
                                    <td>08:00 - 09:20</td>
                                    <td><span class="mata-pelajaran">Bimbingan Konseling</span><span class="guru-pengajar">Pak Adit</span></td>
                                    <td>R. Kelas</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>09:20 - 10:00</td>
                                    <td><span class="mata-pelajaran">Sejarah</span><span class="guru-pengajar">Pak Luqman</span></td>
                                    <td>R. Kelas</td>
                                </tr>
                                <tr class="istirahat">
                                    <td colspan="4">ISTIRAHAT (10:00 - 10:20)</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>10:20 - 11:00</td>
                                    <td><span class="mata-pelajaran">Sejarah</span><span class="guru-pengajar">Pak Luqman</span></td>
                                    <td>R. Kelas</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>11:00 - 11:40</td>
                                    <td><span class="mata-pelajaran">Kejuruan RPL</span><span class="guru-pengajar">Pak Charly</span></td>
                                    <td>Lab. Komputer RPL</td>
                                </tr>
                                <tr class="istirahat">
                                    <td colspan="4">SHOLAT JUM'AT (11:40 - 13:00)</td>
                                </tr>
                                <tr>
                                    <td>6-8</td>
                                    <td>13:00 - 15:00</td>
                                    <td><span class="mata-pelajaran">Kejuruan RPL</span><span class="guru-pengajar">Pak Charly</span></td>
                                    <td>Lab. Komputer RPL</td>
                                </tr>
                                <tr class="kegiatan-khusus">
                                    <td>-</td>
                                    <td>15:00 - 15:40</td>
                                    <td>EKSTRAKURIKULER</td>
                                    <td>Sekolah</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Fungsi yang diperbarui untuk memastikan 'event' terdefinisi
            function showTab(event, tabId) {
                // Sembunyikan semua konten tab
                var contents = document.querySelectorAll('.jadwal-tab-content');
                contents.forEach(function(content) {
                    content.style.display = 'none';
                });

                // Hapus kelas 'active' dari semua tombol
                var buttons = document.querySelectorAll('.tab-menu button');
                buttons.forEach(function(button) {
                    button.classList.remove('active');
                });

                // Tampilkan konten tab yang dipilih
                document.getElementById(tabId).style.display = 'block';

                // Tambahkan kelas 'active' ke tombol yang dipilih
                if (event && event.currentTarget) {
                    event.currentTarget.classList.add('active');
                } else {
                    // Fallback jika dipanggil tanpa event (misal: saat inisialisasi)
                    var targetButton = document.querySelector(`.tab-menu button[onclick*="'${tabId}'"]`);
                    if (targetButton) {
                        targetButton.classList.add('active');
                    }
                }
            }

            // Inisialisasi: Tampilkan tab "Senin" saat halaman dimuat
            document.addEventListener('DOMContentLoaded', function() {
                // Pastikan tab Senin terlihat dan tombolnya aktif saat pertama kali load
                document.getElementById('senin').style.display = 'block';
                var seninButton = document.querySelector(`.tab-menu button[onclick*="'senin'"]`);
                if (seninButton) {
                    seninButton.classList.add('active');
                }
            });

            // *Toggle Sidebar (Jika Anda menggunakan elemen menu-toggle)*
            // Asumsi ada CSS untuk 'wrapper.toggled'
            // var menuToggle = document.getElementById('menu-toggle');
            // var wrapper = document.querySelector('.wrapper');
            // if (menuToggle && wrapper) {
            //     menuToggle.addEventListener('click', function() {
            //         wrapper.classList.toggle('toggled');
            //     });
            // }
        </script>

    </div>
</body>

</html>