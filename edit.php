<?php
include 'config.php';
require_once 'validation.php';

// Initialize variables
$validator = new FormValidation();
$errors = [];
$success = false;

// Validate and sanitize ID parameter
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header("Location: data.php?status=error&message=Invalid ID parameter");
    exit();
}

// Prepare statement for initial data fetch
try {
    $stmt = $conn->prepare("SELECT * FROM Abimanyu WHERE id_pembeli = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if (!$result->num_rows) {
        header("Location: data.php?status=error&message=Record not found");
        exit();
    }
    
    $row = $result->fetch_assoc();
} catch (Exception $e) {
    header("Location: data.php?status=error&message=Database error");
    exit();
}

if (isset($_POST['update'])) {
    $validation = $validator->validateAddData($_POST);
    
    if ($validation['isValid']) {
        $data = $validation['sanitizedData'];
        
        try {
            $sql = "UPDATE Abimanyu SET 
                nama=?, alamat=?, no_telp=?, Tgl_Transaksi=?, 
                Jenis_barang=?, Nama_barang=?, Jumlah=?, Harga=? 
                WHERE id_pembeli=?";
            
            $stmt = $conn->prepare($sql);
            
            // Validate data types before binding
            $jumlah = filter_var($data['jumlah'], FILTER_VALIDATE_INT);
            $harga = filter_var($data['harga'], FILTER_VALIDATE_FLOAT);
            
            $stmt->bind_param("ssssssddi", 
                $data['nama'],
                $data['alamat'],
                $data['no_telp'],
                $data['tgl_transaksi'],
                $data['jenis_barang'],
                $data['nama_barang'],
                $jumlah,
                $harga,
                $id
            );
            
            if ($stmt->execute()) {
                $success = true;
                header("Location: data.php?status=success&message=" . urlencode("Data berhasil diupdate"));
                exit();
            } else {
                throw new Exception("Gagal mengupdate data");
            }
        } catch (Exception $e) {
            $errors['db'] = "Error: " . htmlspecialchars($e->getMessage());
        }
    } else {
        $errors = $validation['errors'];
        // Use POST data when there are errors to maintain user input
        $row = array_merge($row, $_POST);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/shared.css">
    <link rel="stylesheet" href="css/data.css">
    <title>Edit Data Transaksi</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
                        <a class="nav-link" href="index.php"><i class="fas fa-home me-1"></i>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="data.php"><i class="fas fa-database me-1"></i>Data Transaksi</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Data Transaksi</h4>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?php echo htmlspecialchars($error); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <?php if ($success): ?>
                            <div class="alert alert-success">
                                Data berhasil diupdate!
                            </div>
                        <?php endif; ?>

                        <form method="POST" novalidate class="needs-validation">
                            <!-- Nama -->
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control <?php echo isset($errors['nama']) ? 'is-invalid' : ''; ?>" 
                                       name="nama" value="<?php echo htmlspecialchars($row['nama'] ?? ''); ?>" required>
                                <div class="invalid-feedback">
                                    <?php echo $errors['nama'] ?? ''; ?>
                                </div>
                            </div>

                            <!-- Alamat -->
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <input type="text" class="form-control <?php echo isset($errors['alamat']) ? 'is-invalid' : ''; ?>" 
                                       name="alamat" value="<?php echo htmlspecialchars($row['alamat'] ?? ''); ?>" required>
                                <div class="invalid-feedback">
                                    <?php echo $errors['alamat'] ?? ''; ?>
                                </div>
                            </div>

                            <!-- No Telp -->
                            <div class="mb-3">
                                <label class="form-label">No. Telp</label>
                                <input type="tel" class="form-control <?php echo isset($errors['no_telp']) ? 'is-invalid' : ''; ?>" 
                                       name="no_telp" value="<?php echo htmlspecialchars($row['no_telp'] ?? ''); ?>" required>
                                <div class="invalid-feedback">
                                    <?php echo $errors['no_telp'] ?? ''; ?>
                                </div>
                            </div>

                            <!-- Tanggal Transaksi -->
                            <div class="mb-3">
                                <label class="form-label">Tanggal Transaksi</label>
                                <input type="date" class="form-control <?php echo isset($errors['tgl_transaksi']) ? 'is-invalid' : ''; ?>" 
                                       name="tgl_transaksi" value="<?php echo htmlspecialchars($row['Tgl_Transaksi'] ?? ''); ?>" required>
                                <div class="invalid-feedback">
                                    <?php echo $errors['tgl_transaksi'] ?? ''; ?>
                                </div>
                            </div>

                            <!-- Jenis Barang -->
                            <div class="mb-3">
                                <label class="form-label">Jenis Barang</label>
                                <input type="text" class="form-control <?php echo isset($errors['jenis_barang']) ? 'is-invalid' : ''; ?>" 
                                       name="jenis_barang" value="<?php echo htmlspecialchars($row['Jenis_barang'] ?? ''); ?>" required>
                                <div class="invalid-feedback">
                                    <?php echo $errors['jenis_barang'] ?? ''; ?>
                                </div>
                            </div>

                            <!-- Nama Barang -->
                            <div class="mb-3">
                                <label class="form-label">Nama Barang</label>
                                <input type="text" class="form-control <?php echo isset($errors['nama_barang']) ? 'is-invalid' : ''; ?>" 
                                       name="nama_barang" value="<?php echo htmlspecialchars($row['Nama_barang'] ?? ''); ?>" required>
                                <div class="invalid-feedback">
                                    <?php echo $errors['nama_barang'] ?? ''; ?>
                                </div>
                            </div>

                            <!-- Jumlah -->
                            <div class="mb-3">
                                <label class="form-label">Jumlah</label>
                                <input type="number" class="form-control <?php echo isset($errors['jumlah']) ? 'is-invalid' : ''; ?>" 
                                       name="jumlah" value="<?php echo htmlspecialchars($row['Jumlah'] ?? ''); ?>" required min="1">
                                <div class="invalid-feedback">
                                    <?php echo $errors['jumlah'] ?? ''; ?>
                                </div>
                            </div>

                            <!-- Harga -->
                            <div class="mb-3">
                                <label class="form-label">Harga</label>
                                <input type="number" class="form-control <?php echo isset($errors['harga']) ? 'is-invalid' : ''; ?>" 
                                       name="harga" value="<?php echo htmlspecialchars($row['Harga'] ?? ''); ?>" required min="0" step="0.01">
                                <div class="invalid-feedback">
                                    <?php echo $errors['harga'] ?? ''; ?>
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" name="update" class="btn btn-primary">Update Data</button>
                                <a href="data.php" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Custom validation script
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
</body>
</html>