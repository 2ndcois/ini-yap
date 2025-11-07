<?php
// 1. KONEKSI DATABASE (Sama seperti testing.php)
$db_host="localhost";
$db_user="root";
$db_pass="";
$db_name="database_manajemen_siswa"; 

$koneksi= mysqli_connect ($db_host,$db_user,$db_pass,$db_name);

if (mysqli_connect_errno()){
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Inisialisasi pesan
$pesan_sukses = "";
$pesan_error = "";
$data_edit_kelompok = null; 

// --- LOGIC TAMBAH KELOMPOK ---
if (isset($_POST['tambah_kelompok_baru'])) {
    $nama_kelompok_baru = mysqli_real_escape_string($koneksi, trim($_POST['nama_kelompok_baru']));
    $keterangan_baru = mysqli_real_escape_string($koneksi, trim($_POST['keterangan_baru']));

    if (!empty($nama_kelompok_baru)) {
        $q_cek = mysqli_query($koneksi, "SELECT * FROM tb_kelompok WHERE NamaKelompok = '$nama_kelompok_baru'");
        if (mysqli_num_rows($q_cek) > 0) {
            $pesan_error = "Kelompok dengan nama '$nama_kelompok_baru' sudah ada!";
        } else {
            $query = "INSERT INTO tb_kelompok (NamaKelompok, Keterangan, WaktuDibuat) VALUES ('$nama_kelompok_baru', '$keterangan_baru', NOW())";
            if (mysqli_query($koneksi, $query)) {
                header("Location: kelompok.php?status=tambah_sukses");
                exit();
            } else {
                $pesan_error = "Gagal menambahkan kelompok: " . mysqli_error($koneksi);
            }
        }
    } else {
        $pesan_error = "Nama kelompok tidak boleh kosong!";
    }
}

// --- LOGIC HAPUS KELOMPOK (Termasuk Anggotanya) ---
if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus_kelompok') {
    $id_kelompok_hapus = (int)$_GET['id'];
    
    if ($id_kelompok_hapus > 0) {
        // Hapus anggota kelompok terlebih dahulu (untuk menjaga Foreign Key, jika belum diatur CASCADE di DB)
        mysqli_query($koneksi, "DELETE FROM tb_anggota_kelompok WHERE IDKelompok = $id_kelompok_hapus");
        
        // Hapus kelompok
        $query = "DELETE FROM tb_kelompok WHERE IDKelompok = $id_kelompok_hapus";
        if (mysqli_query($koneksi, $query)) {
            header("Location: kelompok.php?status=hapus_sukses");
            exit();
        } else {
            $pesan_error = "Gagal menghapus data kelompok: " . mysqli_error($koneksi);
        }
    }
}

// --- LOGIC AMBIL DATA UNTUK EDIT KELOMPOK ---
if (isset($_GET['aksi']) && $_GET['aksi'] == 'edit_kelompok') {
    $id_kelompok_edit = (int)$_GET['id'];
    $q_ambil = mysqli_query($koneksi, "SELECT * FROM tb_kelompok WHERE IDKelompok = $id_kelompok_edit");
    
    if (mysqli_num_rows($q_ambil) > 0) {
        $data_edit_kelompok = mysqli_fetch_assoc($q_ambil);
    } else {
        header("Location: kelompok.php?status=error_edit");
        exit();
    }
}

// --- LOGIC UPDATE KELOMPOK ---
if (isset($_POST['update_kelompok'])) {
    $id_kelompok_update = (int)$_POST['id_kelompok_update'];
    $nama_kelompok_update = mysqli_real_escape_string($koneksi, trim($_POST['nama_kelompok_update']));
    $keterangan_update = mysqli_real_escape_string($koneksi, trim($_POST['keterangan_update']));

    if (!empty($nama_kelompok_update) && $id_kelompok_update > 0) {
        $query_update = "UPDATE tb_kelompok SET 
                             NamaKelompok = '$nama_kelompok_update', 
                             Keterangan = '$keterangan_update'
                             WHERE IDKelompok = $id_kelompok_update";
        
        if (mysqli_query($koneksi, $query_update)) {
            header("Location: kelompok.php?status=edit_sukses");
            exit();
        } else {
            $pesan_error = "Gagal mengupdate data kelompok: " . mysqli_error($koneksi);
        }
    } else {
        $pesan_error = "Data kelompok yang dikirim tidak valid!";
    }
}

// --- LOGIC TAMBAH ANGGOTA ---
if (isset($_POST['tambah_anggota'])) {
    $id_kelompok = (int)$_POST['id_kelompok_anggota'];
    $id_siswa_baru = (int)$_POST['id_siswa']; // ID Siswa yang dipilih
    $peran_anggota = mysqli_real_escape_string($koneksi, trim($_POST['peran_anggota']));

    if ($id_kelompok > 0 && $id_siswa_baru > 0) {
        // Cek apakah siswa sudah menjadi anggota di kelompok ini
        $q_cek_anggota = mysqli_query($koneksi, "SELECT * FROM tb_anggota_kelompok WHERE IDKelompok = $id_kelompok AND IDSiswa = $id_siswa_baru");

        if (mysqli_num_rows($q_cek_anggota) > 0) {
            $pesan_error = "Siswa sudah terdaftar sebagai anggota di kelompok ini!";
        } else {
            $query_tambah_anggota = "INSERT INTO tb_anggota_kelompok (IDKelompok, IDSiswa, Peran) 
                                     VALUES ($id_kelompok, $id_siswa_baru, '$peran_anggota')";
            if (mysqli_query($koneksi, $query_tambah_anggota)) {
                header("Location: kelompok.php?status=anggota_tambah_sukses&kelompok=$id_kelompok");
                exit();
            } else {
                $pesan_error = "Gagal menambahkan anggota: " . mysqli_error($koneksi);
            }
        }
    } else {
        $pesan_error = "Data anggota yang dikirim tidak valid!";
    }
}

// --- LOGIC HAPUS ANGGOTA (Tambahan, untuk fungsionalitas di dalam modal)
if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus_anggota') {
    $id_anggota_hapus = (int)$_GET['id_anggota'];
    $id_kelompok_redirect = (int)$_GET['id_kelompok'];
    
    if ($id_anggota_hapus > 0) {
        $query = "DELETE FROM tb_anggota_kelompok WHERE IDAnggota = $id_anggota_hapus";
        if (mysqli_query($koneksi, $query)) {
            header("Location: kelompok.php?status=anggota_hapus_sukses&kelompok=$id_kelompok_redirect");
            exit();
        } else {
            $pesan_error = "Gagal menghapus anggota: " . mysqli_error($koneksi);
        }
    }
}


// --- LOGIC TAMPILKAN PESAN DARI REDIRECT ---
if (isset($_GET['status'])) {
    // Pesan Kelompok
    if ($_GET['status'] == 'tambah_sukses') {
        $pesan_sukses = "Kelompok berhasil ditambahkan!";
    } elseif ($_GET['status'] == 'hapus_sukses') {
        $pesan_sukses = "Kelompok dan anggotanya berhasil dihapus!";
    } elseif ($_GET['status'] == 'edit_sukses') {
        $pesan_sukses = "Data kelompok berhasil diubah!";
    } elseif ($_GET['status'] == 'error_edit') {
        $pesan_error = "ID kelompok untuk edit tidak ditemukan!";
    }
    // Pesan Anggota
    elseif ($_GET['status'] == 'anggota_tambah_sukses') {
        $pesan_sukses = "Anggota berhasil ditambahkan ke kelompok!";
    }
    elseif ($_GET['status'] == 'anggota_hapus_sukses') {
        $pesan_sukses = "Anggota berhasil dihapus dari kelompok!";
    }
}

// ----------------------------------------------------------------------
// 7. LOGIC AMBIL DATA UNTUK DITAMPILKAN
// ----------------------------------------------------------------------
$query_kelompok = mysqli_query($koneksi, "SELECT * FROM tb_kelompok ORDER BY NamaKelompok ASC");

$query_siswa_all = mysqli_query($koneksi, "SELECT IDSiswa, NamaSiswa, KelasSiswa FROM tb_siswa ORDER BY NamaSiswa ASC");
$semua_siswa = [];
while($row = mysqli_fetch_assoc($query_siswa_all)) {
    $semua_siswa[] = $row;
}

// Ambil data anggota jika ada parameter kelompok di URL
$data_anggota = [];
$id_kelompok_aktif = 0;
if (isset($_GET['kelompok']) || $pesan_sukses == 'Anggota berhasil ditambahkan ke kelompok!' || $pesan_sukses == 'Anggota berhasil dihapus dari kelompok!') {
    $id_kelompok_aktif = (int)($_GET['kelompok'] ?? $_POST['id_kelompok_anggota'] ?? 0);
    
    // Query untuk mengambil data anggota, join dengan tb_siswa
    $q_anggota = "SELECT ta.IDAnggota, ts.NamaSiswa, ts.KelasSiswa, ta.Peran 
                  FROM tb_anggota_kelompok ta 
                  JOIN tb_siswa ts ON ta.IDSiswa = ts.IDSiswa
                  WHERE ta.IDKelompok = $id_kelompok_aktif
                  ORDER BY ts.NamaSiswa ASC";
    
    $result_anggota = mysqli_query($koneksi, $q_anggota);
    while($row = mysqli_fetch_assoc($result_anggota)) {
        $data_anggota[] = $row;
    }
    
    // Ambil nama kelompok untuk modal
    $q_kelompok_nama = mysqli_query($koneksi, "SELECT NamaKelompok FROM tb_kelompok WHERE IDKelompok = $id_kelompok_aktif");
    if (mysqli_num_rows($q_kelompok_nama) > 0) {
        $nama_kelompok_aktif = mysqli_fetch_assoc($q_kelompok_nama)['NamaKelompok'];
    } else {
        $nama_kelompok_aktif = 'Kelompok Tidak Ditemukan';
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kelompok - SMKN 1 Tenggarong</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .main-content-area {
            padding: 20px !important;
        }
        .table-responsive {
            margin-top: 20px;
        }
        /* Style untuk modal yang otomatis tampil */
        .modal.show {
            display: block;
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
                <a href="kelompok.php" class="menu-item active">
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
                    <h2>Manajemen Data Kelompok</h2>
                </div>
            </div>
            
            <div class="main-content-area">

                <div class="content-data"> 
                    
                    <?php if ($pesan_sukses): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $pesan_sukses; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>

                    <?php if ($pesan_error): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $pesan_error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>

                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahKelompokModal">
                        <i class="fas fa-plus me-2"></i> Tambah Kelompok Baru
                    </button>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kelompok</th> 
                                    <th>Keterangan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                while($data_kelompok = mysqli_fetch_assoc($query_kelompok)):
                                ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($data_kelompok['NamaKelompok']); ?></td>
                                    <td><?= htmlspecialchars($data_kelompok['Keterangan']); ?></td>
                                    <td class="text-center" style="min-width: 250px;">
                                        <a href="kelompok.php?kelompok=<?= $data_kelompok['IDKelompok']; ?>" 
                                           class="btn btn-sm btn-info me-2 show-anggota-modal" 
                                           data-id-kelompok="<?= $data_kelompok['IDKelompok']; ?>" 
                                           data-nama-kelompok="<?= htmlspecialchars($data_kelompok['NamaKelompok']); ?>"
                                           data-bs-toggle="modal" 
                                           data-bs-target="#tambahAnggotaModal">
                                            <i class="fas fa-users"></i> Anggota
                                        </a>
                                        
                                        <a href="?aksi=edit_kelompok&id=<?= $data_kelompok['IDKelompok']; ?>" 
                                           class="btn btn-sm btn-warning me-2">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="?aksi=hapus_kelompok&id=<?= $data_kelompok['IDKelompok']; ?>" 
                                           onclick="return confirm('Yakin hapus kelompok <?= $data_kelompok['NamaKelompok']; ?>? Semua anggotanya akan terhapus.')" 
                                           class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash-alt"></i> Hapus </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>

                                <?php if (mysqli_num_rows($query_kelompok) == 0): ?>
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada data kelompok.</td> </tr>
                                <?php endif; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="tambahKelompokModal" tabindex="-1" aria-labelledby="tambahKelompokModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action=""> 
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahKelompokModalLabel">Tambah Kelompok Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="mb-3">
                            <label for="nama_kelompok_baru" class="form-label">Nama Kelompok</label>
                            <input type="text" class="form-control" id="nama_kelompok_baru" name="nama_kelompok_baru" required>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan_baru" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan_baru" name="keterangan_baru"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" name="tambah_kelompok_baru" class="btn btn-primary">Simpan Kelompok</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php if ($data_edit_kelompok): ?>
    <div class="modal fade show" id="editKelompokModal" tabindex="-1" aria-labelledby="editKelompokModalLabel" aria-hidden="true" style="display: block;" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action=""> 
                    <div class="modal-header">
                        <h5 class="modal-title" id="editKelompokModalLabel">Edit Kelompok: <?= htmlspecialchars($data_edit_kelompok['NamaKelompok']); ?></h5>
                        <a href="kelompok.php" class="btn-close" aria-label="Close"></a>
                    </div>
                    <div class="modal-body">
                        
                        <input type="hidden" name="id_kelompok_update" value="<?= htmlspecialchars($data_edit_kelompok['IDKelompok']); ?>">

                        <div class="mb-3">
                            <label for="nama_kelompok_update" class="form-label">Nama Kelompok</label>
                            <input type="text" class="form-control" id="nama_kelompok_update" name="nama_kelompok_update" 
                                value="<?= htmlspecialchars($data_edit_kelompok['NamaKelompok']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan_update" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan_update" name="keterangan_update"><?= htmlspecialchars($data_edit_kelompok['Keterangan']); ?></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <a href="kelompok.php" class="btn btn-secondary">Tutup</a>
                        <button type="submit" name="update_kelompok" class="btn btn-warning">Update Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    <?php endif; ?>

    <div class="modal fade" id="tambahAnggotaModal" tabindex="-1" aria-labelledby="tambahAnggotaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahAnggotaModalLabel">Manajemen Anggota Kelompok</h5>
                    <a href="kelompok.php" class="btn-close" aria-label="Close"></a>
                </div>
                <div class="modal-body">
                    <h6 class="mb-3">Kelompok: <span id="namaKelompokAnggota"><?= $nama_kelompok_aktif ?? 'Pilih Kelompok'; ?></span></h6>

                    <form method="POST" action="kelompok.php" class="p-3 border rounded mb-4">
                        <h6>Tambah Anggota Baru</h6>
                        <input type="hidden" name="id_kelompok_anggota" id="id_kelompok_anggota" value="<?= $id_kelompok_aktif; ?>">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="id_siswa" class="form-label">Pilih Siswa</label>
                                <select class="form-select" id="id_siswa" name="id_siswa" required>
                                    <option value="" disabled selected>Pilih Siswa</option>
                                    <?php foreach ($semua_siswa as $siswa): ?>
                                    <option value="<?= $siswa['IDSiswa']; ?>">
                                        <?= htmlspecialchars($siswa['NamaSiswa']) . " (" . htmlspecialchars($siswa['KelasSiswa']) . ")"; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="peran_anggota" class="form-label">Peran</label>
                                <input type="text" class="form-control" id="peran_anggota" name="peran_anggota" value="Anggota">
                            </div>
                            <div class="col-md-2 d-flex align-items-end mb-3">
                                <button type="submit" name="tambah_anggota" class="btn btn-success w-100">Tambah</button>
                            </div>
                        </div>
                    </form>

                    <h6>Daftar Anggota Kelompok</h6>
                    <div id="daftarAnggota" class="table-responsive">
                    <?php if (empty($data_anggota)): ?>
                        <p class="text-muted text-center">Belum ada anggota di kelompok ini.</p>
                    <?php else: ?>
                        <table class="table table-sm table-bordered table-striped">
                            <thead>
                                <tr><th>No</th><th>Nama Siswa</th><th>Kelas</th><th>Peran</th><th class="text-center">Aksi</th></tr>
                            </thead>
                            <tbody>
                                <?php $no_anggota = 1; foreach ($data_anggota as $anggota): ?>
                                <tr>
                                    <td><?= $no_anggota++; ?></td>
                                    <td><?= htmlspecialchars($anggota['NamaSiswa']); ?></td>
                                    <td><?= htmlspecialchars($anggota['KelasSiswa']); ?></td>
                                    <td><?= htmlspecialchars($anggota['Peran']); ?></td>
                                    <td class="text-center">
                                        <a href="?aksi=hapus_anggota&id_anggota=<?= $anggota['IDAnggota']; ?>&id_kelompok=<?= $id_kelompok_aktif; ?>" 
                                            onclick="return confirm('Yakin hapus anggota <?= $anggota['NamaSiswa']; ?>?')" 
                                            class="btn btn-sm btn-danger">
                                            Hapus
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                    </div>

                </div>
                <div class="modal-footer">
                    <a href="kelompok.php" class="btn btn-secondary">Tutup</a>
                </div>
            </div>
        </div>
    </div>
    <?php if ($data_edit_kelompok || $id_kelompok_aktif > 0 && isset($_GET['kelompok']) || isset($_GET['status']) && strpos($_GET['status'], 'anggota') !== false): ?>
    <div class="modal-backdrop fade show"></div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Logika untuk menampilkan Modal Edit Kelompok jika ada data edit
        <?php if ($data_edit_kelompok): ?>
            var editModal = new bootstrap.Modal(document.getElementById('editKelompokModal'));
            editModal.show();
        <?php endif; ?>

        // Logika untuk menampilkan Modal Anggota jika ada status anggota atau parameter kelompok di URL
        <?php 
        // Cek jika ada redirect sukses/error dari aksi anggota atau ada param kelompok
        if ($id_kelompok_aktif > 0 && (isset($_GET['kelompok']) || (isset($_GET['status']) && strpos($_GET['status'], 'anggota') !== false))): 
        ?>
            var anggotaModal = new bootstrap.Modal(document.getElementById('tambahAnggotaModal'));
            
            // Set data dinamis di modal
            document.getElementById('namaKelompokAnggota').textContent = '<?= htmlspecialchars($nama_kelompok_aktif); ?>';
            document.getElementById('id_kelompok_anggota').value = '<?= $id_kelompok_aktif; ?>';
            
            anggotaModal.show();

        <?php endif; ?>

        // Logika JavaScript untuk tombol Anggota (memastikan ID terisi saat tombol diklik)
        document.querySelectorAll('.show-anggota-modal').forEach(button => {
            button.addEventListener('click', function (event) {
                // Mencegah navigasi penuh jika modal dibuka via JS
                // event.preventDefault(); 
                
                var idKelompok = this.getAttribute('data-id-kelompok');
                var namaKelompok = this.getAttribute('data-nama-kelompok');
                
                // Isi form dan judul modal
                document.getElementById('namaKelompokAnggota').textContent = namaKelompok;
                document.getElementById('id_kelompok_anggota').value = idKelompok;
                
                // Karena kita menggunakan redirect PHP untuk menampilkan anggota, 
                // cukup memastikan data diisi di form tambah dan modal terbuka.
            });
        });
    });
    </script>
</body>

</html>