<?php

class DataBarang extends Controller
{
    public function index($kategori= null){
        $this->view('template/header');
        $this->view('data_barang/index');
        $dataSupplier = $this->model('SupplierModel')->getSuppliers();

        // Inisialisasi variabel
        $searchTerm = '';
//        var_dump($_GET['kategori']);
        // Memeriksa apakah ada data pencarian
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
            // Jika ada data pencarian, panggil fungsi untuk mendapatkan data barang berdasarkan pencarian
            $searchTerm = $_POST['search'];
            $dataBarang = $this->model('BarangModel')->searchDataBarang($searchTerm);
        } else if (isset($_POST['kategori'])) {
            // Jika ada parameter kategori
            $kategori = $_POST['kategori'];
            $dataBarang = $this->model('BarangModel')->getDataBarangByCategory($kategori);
        } else {
            // Jika tidak ada data pencarian atau parameter kategori, tampilkan semua data barang
            $dataBarang = $this->model('BarangModel')->getDataBarang();
//            var_dump($dataBarang);
        }

        $no = 1;
        foreach ($dataBarang as $item) {
            echo "<tr>";
            echo "<td>" . $no++ . "</td>";
            echo "<td><img src='uploads/" . $item['gambar'] . "' alt='' style='width: 4rem' class='rounded-3' /></td>";
            echo "<td>" . $item['nama_barang'] . "</td>";
            echo "<td>Rp. " . number_format($item['harga_beli']) . "</td>";
            echo "<td>Rp. " . number_format($item['harga_jual']) . "</td>";
            $supplierName = "";
            foreach ($dataSupplier as $supplier) {
                if ($supplier['id_supplier'] == $item['id_supplier']) {
                    $supplierName = $supplier['nama_supplier'];
                    break;
                }
            }
            echo "<td>" . $supplierName . "</td>";
            echo "<td>" . $item['stok_barang'] . "</td>";
            echo "<td>
                 <a href='admin/fungsi/editBarang.php?action=edit&id=" . $item['id_barang'] . "' class='edit'>Edit</a>
                 <a href='http://localhost/ta-oop/public/DataBarang/deleteBarang/" . $item['id_barang'] . "' class='hapus' onclick='return confirm(\"Hapus Data Barang ?\");'>Delete</a>
                        </td>";
                
            echo "</tr>";

        }
        $this->view('data_barang/fitur', $dataSupplier);

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


    public function editBarang(){
        if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
            $id_barang = $_GET['id'];

            // Ambil data barang berdasarkan ID
            $data_barang = $this->model('BarangModel')->getBarangById($id_barang);

            if (!$data_barang) {
                echo "Barang tidak ditemukan.";
                exit();
            }
        }
    }


    public function deleteBarang($id){
        $idBarangToDelete = $id;

        // Memanggil method untuk menghapus barang
        if ($this->model('BarangModel')->deleteBarang($idBarangToDelete)) {
            // Redirect atau tampilkan pesan berhasil
            header("Location: ../../DataBarang");
            exit();
        } else {
            // Tampilkan pesan gagal
            echo "Gagal menghapus barang";
        }
    }
//    public function deleteBarang(){
//        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
//            $idBarangToDelete = $_POST["id"];
//            var_dump($idBarangToDelete);
//
//            // Memanggil method untuk menghapus barang
//            if ($this->model('BarangModel')->deleteBarang($idBarangToDelete)) {
//                // Redirect atau tampilkan pesan berhasil
//                header("Location: ../DataBarang");
//                exit();
//            } else {
//                // Tampilkan pesan gagal
//                echo "Gagal menghapus barang";
//            }
//        }
//    }

    public function filterBarang(){

    }
}