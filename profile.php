<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Smakensa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>
     <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="#"> <img src="logo_smk.jpg" width="40" height="45" > </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.html">Profile</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="jadwal.php">Jadwal</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="tugas.php">Tugas</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="daftar_siswa.php">Daftar Siswa</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="struktur_kelas.php">Struktur Kelas</a>
            </li>
          </ul>
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <span class="nav-link" id="realTimeClock"></span>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container profile-container">
        <div class="profile-card">
            <div class="row">
                <!-- table samping dengan foto profile dan info kelas -->
                <div class="col-md-4 profile-sidebar">
                    <div class="profile-avatar">
                      <img src="logo jurusan.jpg" alt="Foto Profil">
                    </div>
                    <h2 class="profile-name">Shamad Nugi Faiza</h2>
                    <p class="profile-class">Siswa Kelas XI RPL</p>
                    
        
                    <div class="school-info">
                        <p><i class="fas fa-school me-2"></i> SMK Negeri 1 Tenggarong</p>
                        <p><i class="fas fa-calendar me-2"></i> Tahun Ajaran 2024/2025</p>
                    </div>
              
                </div>
                
                <!-- table dengan informasi pribadi -->
                <div class="col-md-8 profile-content">
                    <div class="card-header">
                        <i class="fas fa-user me-2"></i>Informasi Pribadi
                    </div>
                    
                    <div class="info-group">
                        <div class="info-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="info-content">
                            <h4>Nama Lengkap</h4>
                            <p>Shamad Nugi Faiza</p>
                        </div>
                    </div>
                    
                    <div class="info-group">
                        <div class="info-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="info-content">
                            <h4>Tanggal Lahir</h4>
                            <p>25 April 2009</p>
                        </div>
                    </div>
                    
                    <div class="info-group">
                        <div class="info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="info-content">
                            <h4>Alamat</h4>
                            <p>Jl. Kencana Ungu II No. 07, Timbau, Kec. Tenggarong, Kabupaten Kutai Kartanegara, Kalimantan Timur 75513</p>
                        </div>
                    </div>
                    
                    <div class="info-group">
                        <div class="info-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="info-content">
                            <h4>Nomor Telepon</h4>
                            <p>+62 821-4816-2934</p>
                        </div>
                    </div>
                    
                    <div class="info-group">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="info-content">
                            <h4>Email</h4>
                            <p>zinox4123@gmail.com</p>
                        </div>
                    </div>
                    
                    <div class="info-group">
                        <div class="info-icon">
                            <i class="fas fa-male"></i>
                        </div>
                        <div class="info-content">
                            <h4>Jenis Kelamin</h4>
                            <p>Laki-laki</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function updateClock() {
            const now = new Date();
            
            const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", 
                           "Juli", "Agustus", "September", "Oktober", "November", "December"];
            const month = months[now.getMonth()];
            const day = now.getDate();
            const year = now.getFullYear();
            
            let hours = now.getHours();
            const ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; 
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');
           
            const timeString = `${month} ${day}, ${year} - ${hours}:${minutes}:${seconds}${ampm}`;
            
            document.getElementById('realTimeClock').textContent = timeString;
        }
        
        setInterval(updateClock, 1000);
        updateClock();
    </script>

        <style>
        :root {
            --primary: #3498db;
            --secondary: #2c3e50;
            --accent: #e74c3c;
            --light: #ecf0f1;
            --dark: #2c3e50;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.6;
        }
        
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .profile-container {
            max-width: 1000px;
            margin: 40px auto;
        }
        
        .profile-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        
        .profile-sidebar {
            background: #2c3e50;
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .profile-content {
            padding: 30px;
        }
        
        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid rgba(255,255,255,0.3);
            margin: 0 auto 20px;
            overflow: hidden;
            background-color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        

        
        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .profile-name {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .profile-class {
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 20px;
        }
        
        
        .card-header {
            background: #2c3e50;
            color: white;
            padding: 15px 20px;
            font-weight: 600;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        
        .info-group {
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
        }
        
        .info-icon {
            width: 40px;
            height: 40px;
            background-color: rgba(52, 152, 219, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }
        
        .info-icon i {
            color: var(--primary);
            font-size: 15px;
        }
        
        .info-content h4 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--dark);
        }
        
        .info-content p {
            margin-bottom: 0;
            color: #666;
        }
        
        
        
    </style>
</body>
</html>
