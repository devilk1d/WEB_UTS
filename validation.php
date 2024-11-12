<?php
// validation.php
class FormValidation {
    private $errors = [];
    private $data = [];
    
    public function validateAddData($post) {
        // Nama Validation
        if (empty($post['nama'])) {
            $this->errors['nama'] = "Nama wajib diisi!";
        } elseif (!preg_match("/^[a-zA-Z\s]*$/", $post['nama'])) {
            $this->errors['nama'] = "Nama hanya boleh berisi huruf dan spasi!";
        } elseif (strlen($post['nama']) > 100) {
            $this->errors['nama'] = "Nama maksimal 100 karakter!";
        }

        // Alamat Validation
        if (empty($post['alamat'])) {
            $this->errors['alamat'] = "Alamat wajib diisi!";
        } elseif (strlen($post['alamat']) > 255) {
            $this->errors['alamat'] = "Alamat maksimal 255 karakter!";
        }

        // No Telp Validation
        if (empty($post['no_telp'])) {
            $this->errors['no_telp'] = "Nomor telepon wajib diisi!";
        } elseif (!preg_match("/^[0-9]{10,13}$/", $post['no_telp'])) {
            $this->errors['no_telp'] = "Nomor telepon harus berisi 10-13 digit angka!";
        }

        // Tanggal Transaksi Validation
        if (empty($post['tgl_transaksi'])) {
            $this->errors['tgl_transaksi'] = "Tanggal transaksi wajib diisi!";
        } else {
            $tgl = date('Y-m-d', strtotime($post['tgl_transaksi']));
            if ($tgl > date('Y-m-d')) {
                $this->errors['tgl_transaksi'] = "Tanggal tidak boleh lebih dari hari ini!";
            }
        }

        // Jenis Barang Validation
        if (empty($post['jenis_barang'])) {
            $this->errors['jenis_barang'] = "Jenis barang wajib diisi!";
        } elseif (strlen($post['jenis_barang']) > 50) {
            $this->errors['jenis_barang'] = "Jenis barang maksimal 50 karakter!";
        }

        // Nama Barang Validation
        if (empty($post['nama_barang'])) {
            $this->errors['nama_barang'] = "Nama barang wajib diisi!";
        } elseif (strlen($post['nama_barang']) > 100) {
            $this->errors['nama_barang'] = "Nama barang maksimal 100 karakter!";
        }

        // Jumlah Validation
        if (empty($post['jumlah'])) {
            $this->errors['jumlah'] = "Jumlah wajib diisi!";
        } elseif (!is_numeric($post['jumlah']) || $post['jumlah'] <= 0) {
            $this->errors['jumlah'] = "Jumlah harus berupa angka positif!";
        } elseif ($post['jumlah'] > 999999) {
            $this->errors['jumlah'] = "Jumlah tidak boleh lebih dari 999999!";
        }

        // Harga Validation
        if (empty($post['harga'])) {
            $this->errors['harga'] = "Harga wajib diisi!";
        } elseif (!is_numeric($post['harga']) || $post['harga'] <= 0) {
            $this->errors['harga'] = "Harga harus berupa angka positif!";
        } elseif ($post['harga'] > 999999999) {
            $this->errors['harga'] = "Harga tidak boleh lebih dari 999999999!";
        }

        // Sanitize data if no errors
        if (empty($this->errors)) {
            $this->data = [
                'nama' => strip_tags(trim($post['nama'])),
                'alamat' => strip_tags(trim($post['alamat'])),
                'no_telp' => strip_tags(trim($post['no_telp'])),
                'tgl_transaksi' => $post['tgl_transaksi'],
                'jenis_barang' => strip_tags(trim($post['jenis_barang'])),
                'nama_barang' => strip_tags(trim($post['nama_barang'])),
                'jumlah' => (int)$post['jumlah'],
                'harga' => (float)$post['harga']
            ];
        }

        return [
            'isValid' => empty($this->errors),
            'errors' => $this->errors,
            'sanitizedData' => $this->data
        ];
    }
}