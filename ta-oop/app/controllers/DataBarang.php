<?php

class DataBarang extends Controller
{
    public function index($kategori = null)
    {
        $this->view('template/header');

        $data['suppliers'] = $this->model('SupplierModel')->getSuppliers();
        $searchTerm = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
            $searchTerm = $_POST['search'];
            $data['barang'] = $this->model('BarangModel')->searchDataBarang($searchTerm);
        } elseif (isset($_POST['kategori'])) {
            $kategori = $_POST['kategori'];
            $data['barang'] = $this->model('BarangModel')->getDataBarangByCategory($kategori);
        } else {
            $data['barang'] = $this->model('BarangModel')->getDataBarang();
        }
        
        $this->view('data_barang/index', $data);
        $this->view('template/footer');
    }


    public function tambahBarang(){
        if (isset($_POST['submit']) && $_POST['submit'] == 'simpan') {
            // Ambil data dari form
            $namaBarang = $_POST['nama-barang'];
            $kategori = $_POST['kategori'];
            $hargaBeli = $_POST['harga-beli'];
            $hargaJual = $_POST['harga-jual'];
            $supplier = $_POST['supplier'];
            $stock = $_POST['stock'];
            $fotoBarang = $_FILES['foto-barang']['name'];

            // Lakukan validasi data jika diperlukan

            // Simpan foto ke direktori tertentu (misalnya 'uploads/')
            $targetDir = "../public/uploads/";
            $targetFile = $targetDir . basename($_FILES["foto-barang"]["name"]);
            move_uploaded_file($_FILES["foto-barang"]["tmp_name"], $targetFile);

            // Panggil method untuk menambahkan barang
            if ($this->model('BarangModel')->tambahBarang($namaBarang, $kategori,$hargaBeli, $hargaJual,$supplier, $stock, $fotoBarang)) {
                // Redirect atau tampilkan pesan berhasil
                header("Location: ../DataBarang");
                exit();
            } else {
                // Tampilkan pesan gagal
                echo "Gagal menambah barang";
            }
        }
    }


    // public function editBarang(){
    //     if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
    //         $id_barang = $_GET['id'];

    //         // Ambil data barang berdasarkan ID
    //         $data_barang = $this->model('BarangModel')->getBarangById($id_barang);

    //         if (!$data_barang) {
    //             echo "Barang tidak ditemukan.";
    //             exit();
    //         }
    //     }
    // }


    public function deleteBarang($id){
        $idBarangToDelete = $id;

        // Memanggil method untuk menghapus barang
        if ($this->model('BarangModel')->deleteBarang($idBarangToDelete)) {
            // Redirect atau tampilkan pesan berhasil
            header('Location: ' . BASEURL . '/DataBarang');
            exit();
        } else {
            // Tampilkan pesan gagal
            echo "Gagal menghapus barang";
        }
    }

    public function getBarangById($idBarang)
    {
        $barang = $this->model("BarangModel")->getBarangById($idBarang);
        echo json_encode($barang);
    }

    public function updateBarang(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Ambil data dari form
            $idBarang = $_POST['idBarang'];
            $namaBarang = $_POST['nama-barang'];
            $idKategori = $_POST['id_kategori'];
            $hargaBeli = $_POST['harga-beli'];
            $hargaJual = $_POST['harga-jual'];
            $supplier = $_POST['supplier'];
            $stokBarang = $_POST['stock'];
            $gambarBarang = '';
    
            // Cek apakah ada file yang di-upload
            if (isset($_FILES['foto-barang']) && $_FILES['foto-barang']['error'] == 0) {
                // Simpan foto ke direktori tertentu (misalnya 'uploads/')
                $targetDir = "../public/uploads/";
                $gambarBarang = basename($_FILES["foto-barang"]["name"]);
                $targetFile = $targetDir . $gambarBarang;
                
                if (move_uploaded_file($_FILES["foto-barang"]["tmp_name"], $targetFile)) {
                    // File berhasil di-upload
                } else {
                    echo "File upload failed.";
                    exit();
                }
            } else {
                // If no new photo uploaded, retain the existing photo
                $existingData = $this->model('BarangModel')->getBarangById($idBarang);
                $gambarBarang = $existingData['gambar'];
            }
    
            // Panggil method untuk memperbarui barang
            $this->model('BarangModel')->updateBarang($idBarang, $namaBarang, $idKategori, $hargaBeli,$hargaJual,$supplier, $stokBarang, $gambarBarang);
    
            // Redirect atau tampilkan pesan berhasil
            header('Location: ' . BASEURL . '/DataBarang');
            exit();
        } else {
            // Tampilkan pesan gagal
            echo "Akses tidak sah.";
        }
    }


    
}