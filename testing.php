<?php
// 1. KONEKSI DATABASE
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "database_manajemen_siswa";

$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (mysqli_connect_errno()) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Inisialisasi pesan
$pesan_sukses = "";
$pesan_error = "";
$data_edit = null; // Variabel untuk menampung data siswa yang akan diedit

// ----------------------------------------------------------------------
// 2. LOGIC TAMBAH DATA
// ----------------------------------------------------------------------
if (isset($_POST['tambah_siswa_baru'])) {
    $nama_siswa_baru = mysqli_real_escape_string($koneksi, trim($_POST['nama_siswa_baru']));
    $kelas_baru = mysqli_real_escape_string($koneksi, trim($_POST['kelas_baru']));
    $jurusan_baru = mysqli_real_escape_string($koneksi, trim($_POST['jurusan_baru']));

    if (!empty($nama_siswa_baru)) {
        $q_cek = mysqli_query($koneksi, "SELECT * FROM tb_siswa WHERE NamaSiswa = '$nama_siswa_baru' AND KelasSiswa = '$kelas_baru'");
        if (mysqli_num_rows($q_cek) > 0) {
            $pesan_error = "Siswa dengan nama '$nama_siswa_baru' di kelas '$kelas_baru' sudah ada!";
        } else {
            $query = "INSERT INTO tb_siswa (NamaSiswa, KelasSiswa, JurusanSiswa) VALUES ('$nama_siswa_baru', '$kelas_baru', '$jurusan_baru')";
            if (mysqli_query($koneksi, $query)) {
                header("Location: testing.php?status=tambah_sukses");
                exit();
            } else {
                $pesan_error = "Gagal menambahkan siswa: " . mysqli_error($koneksi);
            }
        }
    } else {
        $pesan_error = "Nama siswa tidak boleh kosong!";
    }
}

// ----------------------------------------------------------------------
// 3. LOGIC HAPUS DATA SISWA
// ----------------------------------------------------------------------
if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus_siswa') {
    $id_siswa_hapus = (int)$_GET['id'];

    if ($id_siswa_hapus > 0) {
        $query = "DELETE FROM tb_siswa WHERE IDSiswa = $id_siswa_hapus";
        if (mysqli_query($koneksi, $query)) {
            header("Location: testing.php?status=hapus_sukses");
            exit();
        } else {
            $pesan_error = "Gagal menghapus data siswa: " . mysqli_error($koneksi);
        }
    }
}

// ----------------------------------------------------------------------
// 4. LOGIC AMBIL DATA UNTUK EDIT (Menampilkan Modal Edit)
// ----------------------------------------------------------------------
if (isset($_GET['aksi']) && $_GET['aksi'] == 'edit') {
    $id_siswa_edit = (int)$_GET['id'];
    $q_ambil = mysqli_query($koneksi, "SELECT * FROM tb_siswa WHERE IDSiswa = $id_siswa_edit");

    if (mysqli_num_rows($q_ambil) > 0) {
        $data_edit = mysqli_fetch_assoc($q_ambil);
    } else {
        header("Location: testing.php?status=error_edit");
        exit();
    }
}

// ----------------------------------------------------------------------
// 5. LOGIC UPDATE DATA SISWA (Dari form modal)
// ----------------------------------------------------------------------
if (isset($_POST['update_siswa'])) {
    $id_siswa_update = (int)$_POST['id_siswa_update']; // Ambil ID dari hidden field
    $nama_siswa_update = mysqli_real_escape_string($koneksi, trim($_POST['nama_siswa_update']));
    $kelas_update = mysqli_real_escape_string($koneksi, trim($_POST['kelas_update']));
    $jurusan_update = mysqli_real_escape_string($koneksi, trim($_POST['jurusan_update']));

    if (!empty($nama_siswa_update) && $id_siswa_update > 0) {
        $query_update = "UPDATE tb_siswa SET 
                         NamaSiswa = '$nama_siswa_update', 
                         KelasSiswa = '$kelas_update', 
                         JurusanSiswa = '$jurusan_update' 
                         WHERE IDSiswa = $id_siswa_update";

        if (mysqli_query($koneksi, $query_update)) {
            header("Location: testing.php?status=edit_sukses");
            exit();
        } else {
            $pesan_error = "Gagal mengupdate data: " . mysqli_error($koneksi);
        }
    } else {
        $pesan_error = "Data yang dikirim tidak valid!";
    }
}

// ----------------------------------------------------------------------
// 6. LOGIC TAMPILKAN PESAN DARI REDIRECT
// ----------------------------------------------------------------------
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'tambah_sukses') {
        $pesan_sukses = "Data siswa berhasil ditambahkan!";
    } elseif ($_GET['status'] == 'hapus_sukses') {
        $pesan_sukses = "Data siswa berhasil dihapus!";
    } elseif ($_GET['status'] == 'edit_sukses') {
        $pesan_sukses = "Data siswa berhasil diubah!";
    } elseif ($_GET['status'] == 'error_edit') {
        $pesan_error = "ID siswa untuk edit tidak ditemukan!";
    }
}

// ----------------------------------------------------------------------
// 7. LOGIC AMBIL DATA UNTUK DITAMPILKAN
$query_siswa = mysqli_query($koneksi, "SELECT * FROM tb_siswa ORDER BY NamaSiswa ASC"); ?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa - SMKN 1 Tenggarong</title>

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

        .page-content-wrapper {
            margin-left: 250px;
            flex-grow: 1;
            width: calc(100% - 250px);
        }

        .main-content-area {
            padding: 20px !important;
        }

        .table-responsive {
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .page-content-wrapper {
                margin-left: 0;
                width: 100%;
            }
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
                <a href="testing.php" class="menu-item  active">
                    <i class="fas fa-user-graduate"></i> Data Siswa
                </a>
                <a href="Tugas.php" class="menu-item">
                    <i class="fas fa-ticket-alt"></i> Daftar Tugas
                </a>
                <a href="kelompok.php" class="menu-item">
                    <i class="fas fa-users"></i> Kelompok
                </a>
            </div>

            <div class="logout-section">
                <a href="loguot.php" class="menu-item">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>

        <div class="sidebar-overlay" id="sidebar-overlay"></div>

        <div class="page-content-wrapper">
            <div class="navbar-top">
                <div class="page-title">
                    <i class="fas fa-bars menu-toggle" id="menu-toggle"></i>
                    <h2>Manajemen Data Siswa</h2>
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

                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahSiswaModal">
                        <i class="fas fa-plus me-2"></i> Tambah Siswa Baru
                    </button>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Jurusan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                while ($data = mysqli_fetch_assoc($query_siswa)):
                                ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= htmlspecialchars($data['NamaSiswa']); ?></td>
                                        <td><?= htmlspecialchars($data['KelasSiswa']); ?></td>
                                        <td><?= htmlspecialchars($data['JurusanSiswa']); ?></td>
                                        <td class="text-center">
                                            <a href="?aksi=edit&id=<?= $data['IDSiswa']; ?>"
                                                class="btn btn-sm btn-warning me-2">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="?aksi=hapus_siswa&id=<?= $data['IDSiswa']; ?>"
                                                onclick="return confirm('Yakin hapus data <?= $data['NamaSiswa']; ?>?')"
                                                class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash-alt"></i> Hapus </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>

                                <?php if (mysqli_num_rows($query_siswa) == 0): ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada data siswa di database.</td>
                                    </tr>
                                <?php endif; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tambahSiswaModal" tabindex="-1" aria-labelledby="tambahSiswaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahSiswaModalLabel">Tambah Siswa Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="nama_siswa_baru" class="form-label">Nama Siswa</label>
                            <input type="text" class="form-control" id="nama_siswa_baru" name="nama_siswa_baru" required>
                        </div>
                        <div class="mb-3">
                            <label for="kelas_baru" class="form-label">Kelas</label>
                            <select class="form-select" id="kelas_baru" name="kelas_baru" required>
                                <option value="" disabled selected>Pilih Kelas</option>
                                <option value="X PPLG">X PPLG</option>
                                <option value="XI RPL">XI RPL</option>
                                <option value="X TJKT">X TJKT</option>
                                <option value="XI TKJ">XI TKJ</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jurusan_baru" class="form-label">Jurusan</label>
                            <select class="form-select" id="jurusan_baru" name="jurusan_baru" required>
                                <option value="" disabled selected>Pilih Jurusan</option>
                                <option value="RPL">Rekayasa Perangkat Lunak</option>
                                <option value="TKJ">T. Komputer & Jaringan</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" name="tambah_siswa_baru" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php if ($data_edit): ?>
        <div class="modal fade show" id="editSiswaModal" tabindex="-1" aria-labelledby="editSiswaModalLabel" aria-hidden="true" style="display: block;" aria-modal="true" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editSiswaModalLabel">Edit Siswa: <?= htmlspecialchars($data_edit['NamaSiswa']); ?></h5>
                            <a href="testing.php" class="btn-close" aria-label="Close"></a>
                        </div>
                        <div class="modal-body">

                            <input type="hidden" name="id_siswa_update" value="<?= htmlspecialchars($data_edit['IDSiswa']); ?>">

                            <div class="mb-3">
                                <label for="nama_siswa_update" class="form-label">Nama Siswa</label>
                                <input type="text" class="form-control" id="nama_siswa_update" name="nama_siswa_update"
                                    value="<?= htmlspecialchars($data_edit['NamaSiswa']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="kelas_update" class="form-label">Kelas</label>
                                <select class="form-select" id="kelas_update" name="kelas_update" required>
                                    <option value="X PPLG" <?= ($data_edit['KelasSiswa'] == 'X PPLG') ? 'selected' : ''; ?>>X PPLG</option>
                                    <option value="XI RPL" <?= ($data_edit['KelasSiswa'] == 'XI RPL') ? 'selected' : ''; ?>>XI RPL</option>
                                    <option value="X TJKT" <?= ($data_edit['KelasSiswa'] == 'X TJKT') ? 'selected' : ''; ?>>X TJKT</option>
                                    <option value="XI TKJ" <?= ($data_edit['KelasSiswa'] == 'XI TKJ') ? 'selected' : ''; ?>>XI TKJ</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="jurusan_update" class="form-label">Jurusan</label>
                                <select class="form-select" id="jurusan_update" name="jurusan_update" required>
                                    <option value="RPL" <?= ($data_edit['JurusanSiswa'] == 'RPL') ? 'selected' : ''; ?>>Rekayasa Perangkat Lunak</option>
                                    <option value="TKJ" <?= ($data_edit['JurusanSiswa'] == 'TKJ') ? 'selected' : ''; ?>>T. Komputer & Jaringan</option>
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <a href="testing.php" class="btn btn-secondary">Tutup</a>
                            <button type="submit" name="update_siswa" class="btn btn-warning">Update Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            // Modal Edit tetap jalan
            document.addEventListener('DOMContentLoaded', function() {
                var myModal = new bootstrap.Modal(document.getElementById('editSiswaModal'));
                myModal.show();
            });
        </script>
        <div class="modal-backdrop fade show"></div>
    <?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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
