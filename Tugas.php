<?php
// Pastikan file koneksi.php ada di direktori yang sama
include 'koneksi.php';

// Cek koneksi untuk debugging, jika ada masalah, error akan tampil di sini
if (mysqli_connect_errno()){
    // Jika koneksi gagal, script akan berhenti di sini
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// --- INISIALISASI PESAN ---
$pesan_sukses = "";
$pesan_error = "";

// --- Proses TAMBAH TUGAS BARU (Menggunakan Prepared Statements) ---
if (isset($_POST['tambah_tugas_baru'])) {
    // Ambil dan bersihkan input (trim saja, tidak perlu escape karena pakai prepared statement)
    $nama_mapel = trim($_POST['nama_mapel_baru']);
    $keterangan = trim($_POST['keterangan_baru']);
    $deadline = trim($_POST['deadline_baru']); 

    if (!empty($nama_mapel) && !empty($keterangan) && !empty($deadline)) {
        
        // Query INSERT dengan placeholder (?)
        $query = "INSERT INTO tb_tugas (mata_pelajaran, keterangan, deadline) VALUES (?, ?, ?)";
        
        // 1. Siapkan statement
        $stmt = mysqli_prepare($koneksi, $query);
        
        if ($stmt) {
            // 2. Bind parameter (sss = 3 string)
            // Pastikan format DEADLINE cocok dengan tipe data kolom di DB (biasanya DATETIME/TIMESTAMP)
            mysqli_stmt_bind_param($stmt, "sss", $nama_mapel, $keterangan, $deadline);
            
            // 3. Jalankan query
            if (mysqli_stmt_execute($stmt)) {
                // Sukses
                header("Location: Tugas.php?status=tambah_tugas_sukses&mapel=" . urlencode($nama_mapel));
                exit();
            } else {
                // Gagal eksekusi. INI AKAN MENAMPILKAN ERROR JIKA ADA MASALAH DENGAN TIPE DATA/DATABASE
                $pesan_error = "Gagal menambahkan tugas: " . mysqli_stmt_error($stmt) . " (Pastikan kolom 'deadline' Anda bertipe DATETIME atau TIMESTAMP)";
            }
            
            // 4. Tutup statement
            mysqli_stmt_close($stmt);
        } else {
            $pesan_error = "Gagal menyiapkan statement: " . mysqli_error($koneksi);
        }
    } else {
        $pesan_error = "Mata pelajaran, keterangan, atau deadline tidak boleh kosong!";
    }
}

// --- Proses HAPUS TUGAS (Menggunakan Prepared Statements) ---
if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus_tugas') {
    $id_tugas_hapus = (int)$_GET['id'];
    
    if ($id_tugas_hapus > 0) {
        $query = "DELETE FROM tb_tugas WHERE id_tugas = ?";
        $stmt = mysqli_prepare($koneksi, $query);
        
        if ($stmt) {
            // i = integer
            mysqli_stmt_bind_param($stmt, "i", $id_tugas_hapus);
            
            if (mysqli_stmt_execute($stmt)) {
                header("Location: Tugas.php?status=hapus_tugas_sukses");
                exit();
            } else {
                $pesan_error = "Gagal menghapus tugas: " . mysqli_stmt_error($stmt);
            }
            mysqli_stmt_close($stmt);
        } else {
            $pesan_error = "Gagal menyiapkan statement hapus: " . mysqli_error($koneksi);
        }
    }
}

// --- LOGIC TAMPILKAN PESAN DARI REDIRECT ---
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'tambah_tugas_sukses') {
        $mapel = isset($_GET['mapel']) ? htmlspecialchars($_GET['mapel']) : "Tugas";
        $pesan_sukses = "Tugas '$mapel' berhasil ditambahkan!";
    } elseif ($_GET['status'] == 'hapus_tugas_sukses') {
        $pesan_sukses = "Tugas berhasil dihapus!";
    }
}

// --- Ambil Data Tugas untuk ditampilkan (tetap menggunakan mysqli_query karena ini SELECT) ---
$query_tugas = mysqli_query($koneksi, "SELECT * FROM tb_tugas ORDER BY deadline ASC");
$data_tugas = [];
if ($query_tugas) {
    while ($d = mysqli_fetch_assoc($query_tugas)) {
        $data_tugas[] = $d;
    }
} else {
     // Error saat SELECT
    $pesan_error = "Gagal mengambil data tugas: " . mysqli_error($koneksi);
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tugas - SMKN 1 Tenggarong</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style3.css"> 
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
                <a href="Tugas.php" class="menu-item active"> <i class="fas fa-ticket-alt"></i> Daftar Tugas
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
                    <h2>Daftar Tugas</h2> </div>
            </div>

            <div class="main-content-area"> <div class="alert-container">
                    <?php if ($pesan_sukses): ?>
                        <div class="alert success-alert">
                            <?= $pesan_sukses ?>
                            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                        </div>
                    <?php endif; ?>
                    <?php if ($pesan_error): ?>
                        <div class="alert error-alert">
                            <?= $pesan_error ?>
                            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-tambah-tugas"> 
                    <h4 class="title-red">Tambahkan Tugas Baru</h4>
                    <form method="POST" action="Tugas.php">
                        <div style="display: flex; gap: 15px; margin-bottom: 15px; align-items: stretch;">
                            <input type="text" name="nama_mapel_baru" placeholder="Mata Pelajaran" required style="flex: 2; padding: 10px;">
                            <input type="text" name="keterangan_baru" placeholder="Keterangan Tugas" required style="flex: 3; padding: 10px;">
                            <input type="datetime-local" name="deadline_baru" required style="flex: 2; padding: 10px;">
                            <button type="submit" name="tambah_tugas_baru" class="btn-action" style="background-color: var(--primary-red); color: white; flex: 1;">
                                <i class="fas fa-plus"></i> Tambah
                            </button>
                        </div>
                    </form>
                </div>
                
                <h3>Tugas Aktif (Urut Berdasarkan Deadline)</h3>
                <div style="overflow-x: auto;">
                    <table class="tugas-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Mata Pelajaran</th>
                                <th>Keterangan</th>
                                <th>Deadline</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($data_tugas)): ?>
                                <tr>
                                    <td colspan="6" style="text-align: center; color: #777;">Tidak ada tugas yang terdaftar saat ini.</td>
                                </tr>
                            <?php else: ?>
                                <?php $no = 1; foreach ($data_tugas as $tugas): 
                                    $deadline_time = strtotime($tugas['deadline']);
                                    $sekarang = time();
                                    
                                    if ($deadline_time < $sekarang) {
                                        $status = '<span style="color: #dc3545; font-weight: bold;"><i class="fas fa-times-circle"></i> Terlambat</span>';
                                    } else {
                                        // Hitung sisa waktu
                                        $sisa_waktu = $deadline_time - $sekarang;
                                        $hari = floor($sisa_waktu / (60 * 60 * 24));
                                        $jam = floor(($sisa_waktu % (60 * 60 * 24)) / (60 * 60));
                                        $menit = floor(($sisa_waktu % (60 * 60)) / 60);

                                        $sisa_text = "";
                                        if ($hari > 0) $sisa_text .= "$hari hari ";
                                        if ($jam > 0) $sisa_text .= "$jam jam ";
                                        if ($menit > 0 && $hari == 0) $sisa_text .= "$menit menit";
                                        
                                        // Menggunakan warna hijau dari CSS utility
                                        $status = '<span class="green" style="font-weight: bold;"><i class="fas fa-clock"></i> Sisa: ' . trim($sisa_text) . '</span>';
                                    }
                                    
                                ?>
                                <tr class="data-row">
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($tugas['mata_pelajaran']) ?></td>
                                    <td><?= htmlspecialchars($tugas['keterangan']) ?></td>
                                    <td><?= date('d M Y H:i', $deadline_time) ?></td>
                                    <td><?= $status ?></td>
                                    <td>
                                        <a 
                                            href="Tugas.php?aksi=hapus_tugas&id=<?= $tugas['id_tugas'] ?>" 
                                            class="btn-action btn-danger" 
                                            onclick="return confirm('Yakin ingin menghapus tugas <?= htmlspecialchars($tugas['keterangan']) ?>?')"
                                        >
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div> </div> </div> </body>

</html>