<?php
include 'config.php';
require_once 'validation.php';

$validator = new FormValidation();
$errors = [];
$old = [];
$showModal = false;

if (isset($_POST['submit'])) {
    $showModal = true;
    $validation = $validator->validateAddData($_POST);
    
    if ($validation['isValid']) {
        $data = $validation['sanitizedData'];
        
        try {
            $sql = "INSERT INTO Abimanyu (nama, alamat, no_telp, Tgl_Transaksi, Jenis_barang, 
                    Nama_barang, Jumlah, Harga) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssdd", 
                $data['nama'],
                $data['alamat'],
                $data['no_telp'],
                $data['tgl_transaksi'],
                $data['jenis_barang'],
                $data['nama_barang'],
                $data['jumlah'],
                $data['harga']
            );
            
            if ($stmt->execute()) {
                header("Location: data.php?status=success&message=Data berhasil ditambahkan");
                exit();
            } else {
                throw new Exception("Gagal menyimpan data");
            }
        } catch (Exception $e) {
            $errors['db'] = "Error: " . $e->getMessage();
        }
    } else {
        $errors = $validation['errors'];
        $old = $_POST;
    }
}


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM Abimanyu WHERE id_pembeli=$id");
    header("Location: data.php");
}

// Add delete all functionality
if (isset($_POST['delete_all'])) {
    mysqli_query($conn, "TRUNCATE TABLE Abimanyu");
    header("Location: data.php");
}

// Pagination Configuration
$records_per_page = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// Search Configuration
$search = [];
$where_conditions = [];
$search_fields = ['id_pembeli', 'nama', 'alamat'];

foreach ($search_fields as $field) {
    if (isset($_GET[$field]) && !empty($_GET[$field])) {
        $search[$field] = $_GET[$field];
        $search_value = mysqli_real_escape_string($conn, $_GET[$field]);
        if ($field === 'id_pembeli') {
            $where_conditions[] = "$field = '$search_value'";
        } else {
            $where_conditions[] = "$field LIKE '%$search_value%'";
        }
    }
}

// Build SQL query
$sql = "SELECT * FROM Abimanyu";
if (!empty($where_conditions)) {
    $sql .= " WHERE " . implode(" OR ", $where_conditions);
}

// Get total records for pagination
$total_records_query = mysqli_query($conn, "SELECT COUNT(*) as count FROM Abimanyu" . 
    (!empty($where_conditions) ? " WHERE " . implode(" OR ", $where_conditions) : ""));
$total_records = mysqli_fetch_assoc($total_records_query)['count'];
$total_pages = ceil($total_records / $records_per_page);

// Add pagination to the main query
$sql .= " LIMIT $offset, $records_per_page";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/shared.css">
    <link rel="stylesheet" href="css/data.css">
    <title>Data Transaksi</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php"><i class="fas fa-store me-2"></i>Bimzo Store</a>
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
        <h2>Data Transaksi</h2>

        <div class="row mb-3">
            <div class="col-md-8">
                <!-- Action Buttons -->
                <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fas fa-plus me-1"></i>Tambah Data
                </button>
                <form method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus semua data?');">
                    <button type="submit" name="delete_all" class="btn btn-danger me-2">
                        <i class="fas fa-trash-alt me-1"></i>Hapus Semua
                    </button>
                </form>
            </div>
            <div class="col-md-4">
                <!-- Enhanced Search Form -->
                <form method="GET" class="mb-3">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <input type="text" name="id_pembeli" class="form-control" placeholder="ID Pembeli" 
                                   value="<?php echo isset($search['id_pembeli']) ? htmlspecialchars($search['id_pembeli']) : ''; ?>">
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="nama" class="form-control" placeholder="Nama" 
                                   value="<?php echo isset($search['nama']) ? htmlspecialchars($search['nama']) : ''; ?>">
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="alamat" class="form-control" placeholder="Alamat" 
                                   value="<?php echo isset($search['alamat']) ? htmlspecialchars($search['alamat']) : ''; ?>">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-1"></i>Cari
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Data -->
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No. Telp</th>
                        <th>Tanggal</th>
                        <th>Jenis Barang</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        $total_harga = $row['Jumlah'] * $row['Harga'];
                        $total_harga_diskon = $total_harga * 0.95; // Diskon 5%
                        echo "<tr>
                            <td>{$row['id_pembeli']}</td>
                            <td>{$row['nama']}</td>
                            <td>{$row['alamat']}</td>
                            <td>{$row['no_telp']}</td>
                            <td>{$row['Tgl_Transaksi']}</td>
                            <td>{$row['Jenis_barang']}</td>
                            <td>{$row['Nama_barang']}</td>
                            <td>{$row['Jumlah']}</td>
                            <td>Rp " . number_format($row['Harga'], 0, ',', '.') . "</td>
                            <td>Rp " . number_format($total_harga_diskon, 0, ',', '.') . "</td>
                            <td>
                                <a href='edit.php?id={$row['id_pembeli']}' class='btn btn-warning btn-sm'>Edit</a> <br>
                                <a href='?delete={$row['id_pembeli']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Hapus Data?\")'>Hapus</a>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!--Tambah Data -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Data Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" novalidate>
                        <!-- Nama -->
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control <?php echo isset($errors['nama']) ? 'is-invalid' : ''; ?>" 
                                   name="nama" value="<?php echo isset($old['nama']) ? htmlspecialchars($old['nama']) : ''; ?>">
                            <?php if (isset($errors['nama'])): ?>
                                <div class="invalid-feedback"><?php echo $errors['nama']; ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Alamat -->
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <input type="text" class="form-control <?php echo isset($errors['alamat']) ? 'is-invalid' : ''; ?>" 
                                   name="alamat" value="<?php echo isset($old['alamat']) ? htmlspecialchars($old['alamat']) : ''; ?>">
                            <?php if (isset($errors['alamat'])): ?>
                                <div class="invalid-feedback"><?php echo $errors['alamat']; ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- No Telp -->
                        <div class="mb-3">
                            <label class="form-label">No. Telp</label>
                            <input type="text" class="form-control <?php echo isset($errors['no_telp']) ? 'is-invalid' : ''; ?>" 
                                   name="no_telp" value="<?php echo isset($old['no_telp']) ? htmlspecialchars($old['no_telp']) : ''; ?>">
                            <?php if (isset($errors['no_telp'])): ?>
                                <div class="invalid-feedback"><?php echo $errors['no_telp']; ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Tanggal Transaksi -->
                        <div class="mb-3">
                            <label class="form-label">Tanggal Transaksi</label>
                            <input type="date" class="form-control <?php echo isset($errors['tgl_transaksi']) ? 'is-invalid' : ''; ?>" 
                                   name="tgl_transaksi" value="<?php echo isset($old['tgl_transaksi']) ? $old['tgl_transaksi'] : ''; ?>">
                            <?php if (isset($errors['tgl_transaksi'])): ?>
                                <div class="invalid-feedback"><?php echo $errors['tgl_transaksi']; ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Jenis Barang -->
                        <div class="mb-3">
                            <label class="form-label">Jenis Barang</label>
                            <input type="text" class="form-control <?php echo isset($errors['jenis_barang']) ? 'is-invalid' : ''; ?>" 
                                   name="jenis_barang" value="<?php echo isset($old['jenis_barang']) ? htmlspecialchars($old['jenis_barang']) : ''; ?>">
                            <?php if (isset($errors['jenis_barang'])): ?>
                                <div class="invalid-feedback"><?php echo $errors['jenis_barang']; ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Nama Barang -->
                        <div class="mb-3">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" class="form-control <?php echo isset($errors['nama_barang']) ? 'is-invalid' : ''; ?>" 
                                   name="nama_barang" value="<?php echo isset($old['nama_barang']) ? htmlspecialchars($old['nama_barang']) : ''; ?>">
                            <?php if (isset($errors['nama_barang'])): ?>
                                <div class="invalid-feedback"><?php echo $errors['nama_barang']; ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Jumlah -->
                        <div class="mb-3">
                            <label class="form-label">Jumlah</label>
                            <input type="number" class="form-control <?php echo isset($errors['jumlah']) ? 'is-invalid' : ''; ?>" 
                                   name="jumlah" value="<?php echo isset($old['jumlah']) ? htmlspecialchars($old['jumlah']) : ''; ?>">
                            <?php if (isset($errors['jumlah'])): ?>
                                <div class="invalid-feedback"><?php echo $errors['jumlah']; ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Harga -->
                        <div class="mb-3">
                            <label class="form-label">Harga</label>
                            <input type="number" class="form-control <?php echo isset($errors['harga']) ? 'is-invalid' : ''; ?>" 
                                   name="harga" value="<?php echo isset($old['harga']) ? htmlspecialchars($old['harga']) : ''; ?>">
                            <?php if (isset($errors['harga'])): ?>
                                <div class="invalid-feedback"><?php echo $errors['harga']; ?></div>
                            <?php endif; ?>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <nav aria-label="Page navigation" class="mt-4">
            <ul class="pagination justify-content-center">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=1<?php echo !empty($search) ? '&' . http_build_query($search) : ''; ?>">
                            First
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo ($page - 1) . (!empty($search) ? '&' . http_build_query($search) : ''); ?>">
                            Previous
                        </a>
                    </li>
                <?php endif; ?>

                <?php
                // Show pagination numbers
                $start_page = max(1, $page - 2);
                $end_page = min($total_pages, $page + 2);

                for ($i = $start_page; $i <= $end_page; $i++):
                ?>
                    <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i . (!empty($search) ? '&' . http_build_query($search) : ''); ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo ($page + 1) . (!empty($search) ? '&' . http_build_query($search) : ''); ?>">
                            Next
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $total_pages . (!empty($search) ? '&' . http_build_query($search) : ''); ?>">
                            Last
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if ($showModal || !empty($errors)): ?>
        var myModal = new bootstrap.Modal(document.getElementById('addModal'), {
            backdrop: 'static',
            keyboard: true
        });
        myModal.show();
        <?php endif; ?>
    });
    </script>
</body>
</html>