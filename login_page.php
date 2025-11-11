<?php
session_start();

if (isset($_SESSION['user_id'])) {
  header("location: manajemen_siswa.php");
  exit;
}

require_once 'koneksi.php';

$feedback_message = "";
$feedback_type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $user_input = trim($_POST["user"]);
  $password = trim($_POST["password"]);

  if (empty($user_input) || empty($password)) {
    $feedback_message = "Isi semua bidang sebelum masuk.";
    $feedback_type = "error";
  } else {
    $login_field = 'email';

    $sql = "SELECT id, email, password, role FROM tb_users WHERE {$login_field} = ? AND is_active = 1";

    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("s", $param_user);
      $param_user = $user_input;

      if ($stmt->execute()) {
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
          $stmt->bind_result($user_id, $email, $hashed_password, $role);
          if ($stmt->fetch()) {
            if ($password === $hashed_password) {
              session_start();
              $_SESSION["loggedin"] = true;
              $_SESSION["user_id"] = $user_id;
              $_SESSION["email"] = $email;
              $_SESSION["role"] = $role;

              $feedback_message = "Login berhasil! Mengalihkan...";
              $feedback_type = "success";

              header("refresh:0.9;url=manajemen_siswa.php");
              exit;
            } else {
              $feedback_message = "Kredensial salah. Periksa kembali username dan kata sandi.";
              $feedback_type = "error";
            }
          }
        } else {
          $feedback_message = "Kredensial salah. Periksa kembali username dan kata sandi.";
          $feedback_type = "error";
        }
      } else {
        $feedback_message = "Terjadi kesalahan saat memproses permintaan.";
        $feedback_type = "error";
      }
      $stmt->close();
    }
  }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login - SMKN 1 Tenggarong</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="login_page.css">
</head>

<body>
  <div class="page-wrap">
    <div class="login-card" role="main" aria-labelledby="login-title">
      <aside class="login-hero" aria-hidden="false">
        <div class="brand">
          <div class="logo">SMK</div>
          <div>
            <h3>SMK Negeri 1 Tenggarong</h3>
            <small>Profil Sekolah — Portal Admin</small>
          </div>
        </div>
        <p class="hero-content">Selamat datang! Masuk untuk mengelola data siswa, jadwal, dan tugas. Pastikan akun Anda memiliki hak akses sebagai Admin atau Guru.</p>
        <div class="hero-stats">
          <div class="hero-stat">
            <h4>1330</h4>
            <p>Siswa</p>
          </div>
          <div class="hero-stat">
            <h4>B</h4>
            <p>Akreditasi</p>
          </div>
          <div class="hero-stat">
            <h4>7</h4>
            <p>Jurusan</p>
          </div>
        </div>
      </aside>

      <section class="login-form-wrap">
        <div class="form-header">
          <h2 id="login-title">Masuk Akun</h2>
          <div class="form-desc">Masukkan NIP/NIS atau email & kata sandi Anda</div>
        </div>

        <div id="feedback" class="feedback <?php echo htmlspecialchars($feedback_type); ?>"
          style="display:<?php echo empty($feedback_message) ? 'none' : 'block'; ?>" role="status" aria-live="polite">
          <?php echo htmlspecialchars($feedback_message); ?>
        </div>

        <form id="login-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
          <div class="field">
            <label for="user">NIP / NIS / Email</label>
            <input id="user" name="user" type="text" placeholder="contoh: 19930908 atau rahmat@example.com" required autocomplete="username" value="<?php echo isset($user_input) ? htmlspecialchars($user_input) : ''; ?>">
          </div>

          <div class="field password-wrap">
            <label for="password">Kata Sandi</label>
            <input id="password" name="password" type="password" placeholder="Masukkan kata sandi" required autocomplete="current-password">
            <button type="button" class="toggle-pass" aria-label="Tampilkan kata sandi" title="Tampilkan kata sandi"><i class="fa-regular fa-eye" id="eye-icon"></i></button>
          </div>

          <div class="row">
            <label class="checkbox"><input type="checkbox" id="remember" name="remember"> <span>Ingat saya</span></label>
            <a class="forgot" href="#">Lupa kata sandi?</a>
          </div>

          <button type="submit" class="btn btn-primary"> <i class="fa-solid fa-right-to-bracket"></i> Masuk</button>

          <div class="divider"></div>

          <div class="helper">Atau masuk dengan:</div>
          <div class="socials">
            <button type="button" class="btn" id="sso-google"><i class="fa-brands fa-google"></i> Google</button>
            <button type="button" class="btn" id="sso-local"><i class="fa-solid fa-building"></i> LDAP</button>
          </div>

        </form>

        <div class="form-footer">
          <small class="helper">Belum punya akun? <a href="#">Hubungi admin</a></small>
          <small class="helper">Versi <strong>Portal v1.0</strong></small>
        </div>
      </section>

    </div>
  </div>

  <script>
    const togglePass = document.querySelector('.toggle-pass');
    const password = document.getElementById('password');
    const eyeIcon = document.getElementById('eye-icon');

    // toggle show/hide password
    togglePass.addEventListener('click', () => {
      const isPwd = password.getAttribute('type') === 'password';
      password.setAttribute('type', isPwd ? 'text' : 'password');
      eyeIcon.classList.toggle('fa-eye');
      eyeIcon.classList.toggle('fa-eye-slash');
      togglePass.setAttribute('aria-pressed', isPwd ? 'true' : 'false');
    });

    // Optional: keyboard accessibility - submit on Enter from password field
    password.addEventListener('keyup', (e) => {
      if (e.key === 'Enter') document.getElementById('login-form').submit();
    });
  </script>
</body>

</html>
