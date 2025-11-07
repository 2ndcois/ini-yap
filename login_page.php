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
          <div class="form-desc">Masukkan Nama Lengkap & kata sandi Anda</div>
        </div>

        <div id="feedback" class="feedback" style="display:none" role="status" aria-live="polite"></div>

        <form id="login-form" novalidate>
          <div class="field">
            <label for="user">Nama Lengkap</label>
            <input id="user" name="user" type="text" placeholder="contoh: SHAMAD NUGI FAIZA" required autocomplete="username">
          </div>

          <div class="field password-wrap">
            <label for="password">Kata Sandi</label>
            <input id="password" name="password" type="password" placeholder="Masukkan kata sandi" required autocomplete="current-password">
            <button type="button" class="toggle-pass" aria-label="Tampilkan kata sandi" title="Tampilkan kata sandi"><i class="fa-regular fa-eye" id="eye-icon"></i></button>
          </div>

          <div class="row">
            <label class="checkbox"><input type="checkbox" id="remember"> <span>Ingat saya</span></label>
          </div>

          <button type="submit" class="btn btn-primary"> <i class="fa-solid fa-right-to-bracket"></i> Masuk</button>


        </form>

        <div class="form-footer">
          <small class="helper">Versi <strong>Portal v1.0</strong></small>
        </div>
      </section>

    </div>
  </div>

  <script>
    // elemen
    const form = document.getElementById('login-form');
    const feedback = document.getElementById('feedback');
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

    // simple client-side validation + demo "fake" auth response
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      feedback.style.display = 'none';
      const user = document.getElementById('user').value.trim();
      const pwd = password.value.trim();

      if (!user || !pwd) {
        showFeedback('Isi semua bidang sebelum masuk.', 'error');
        return;
      }

      // contoh validasi pola email atau numeric id
      const isEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(user);
      const isNumericId = /^\d{4,}$/.test(user);

      if (!isEmail && !isNumericId) {
        showFeedback('Masukkan NIS/NIP (angka) atau email yang valid.', 'error');
        return;
      }

      // simulasi pemrosesan (DI SITUS NYATA: kirim ke server via fetch POST)
      showFeedback('Memeriksa kredensial...', 'success');
      // simulasi respons
      setTimeout(() => {
        // contoh: jika password == "admin123" -> sukses (hanya demo)
        if (pwd === 'admin123') {
          showFeedback('Login berhasil! Mengalihkan...', 'success');
          // redirect demo
          setTimeout(() => {
            window.location.href = 'manajemen_siswa.php';
          }, 900);
        } else {
          showFeedback('Kredensial salah. Periksa kembali username dan kata sandi.', 'error');
        }
      }, 900);
    });

    function showFeedback(message, type) {
      feedback.textContent = message;
      feedback.className = 'feedback ' + (type === 'error' ? 'error' : 'success');
      feedback.style.display = 'block';
    }

    // Optional: keyboard accessibility - submit on Enter from password field
    password.addEventListener('keyup', (e) => {
      if (e.key === 'Enter') form.dispatchEvent(new Event('submit', {
        cancelable: true,
        bubbles: true
      }));
    });
  </script>
</body>

</html>