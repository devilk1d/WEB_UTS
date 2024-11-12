<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bimzo Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="css/shared.css">
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-store me-2"></i>Bimzo Store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php"><i class="fas fa-home me-1"></i>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="data.php"><i class="fas fa-database me-1"></i>Data Transaksi</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="card fade-in">
                    <div class="card-body text-center py-5">
                        <h1 class="display-4 mb-4" data-aos="fade-up">Selamat Datang di Bimzo Store</h1>
                        <p class="lead mb-4" data-aos="fade-up" data-aos-delay="100">
                            Akses Data Transaksi Pelanggan Dibawah ini !
                        </p>
                        <div data-aos="fade-up" data-aos-delay="200">
                            <a class="btn btn-primary btn-lg me-2" href="data.php">
                                <i class="fas fa-database me-2"></i>Lihat Data Transaksi
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                        <div class="card text-center p-4">
                            <i class="fas fa-chart-line fa-3x mb-3 text-primary"></i>
                            <h5>Data Real-time</h5>
                            <p class="text-muted">Monitoring transaksi secara langsung</p>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                        <div class="card text-center p-4">
                            <i class="fas fa-shield-alt fa-3x mb-3 text-primary"></i>
                            <h5>Keamanan Data</h5>
                            <p class="text-muted">Data tersimpan dengan aman</p>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="500">
                        <div class="card text-center p-4">
                            <i class="fas fa-sync fa-3x mb-3 text-primary"></i>
                            <h5>Update Otomatis</h5>
                            <p class="text-muted">Data selalu ter-update secara realtime</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>
</body>
</html>