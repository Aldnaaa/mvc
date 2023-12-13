<?php

class Supplier extends Controller
{
    public function index(){
        $this->view('template/header');

        // Inisialisasi variabel
        $searchTerm = '';
        // Memeriksa apakah ada data pencarian
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
            // Jika ada data pencarian, panggil fungsi untuk mendapatkan data barang berdasarkan pencarian
            $searchTerm = $_POST['search'];
            $data['suppliers'] = $this->model('SupplierModel')->searchDataSupplier($searchTerm);
        } else {
            // Jika tidak ada data pencarian, panggil fungsi untuk mendapatkan semua data supplier
            $data['suppliers'] = $this->model('SupplierModel')->getSuppliers();
        }

        $this->view('supplier/index',$data);
        $this->view('template/footer');
    }

    public function tambahSupplier(){
        if (isset($_POST['submit']) && $_POST['submit'] == 'Simpan') {
            $supplierName = $_POST['nama-supplier'];
            $supplierTelepon = $_POST['telepon'];

            $result = $this->model('SupplierModel')->tambahSupplier($supplierName,$supplierTelepon);

            if ($result) {
                header("Location: ../Supplier");
                exit();
            } else {
                echo "Gagal menambahkan data supplier.";
            }
        }
    }

    public function deleteSupplier($id){
        $idSupplierToDelete = $id;

        // Memanggil method untuk menghapus barang
        if ($this->model('SupplierModel')->deleteSuppliers($idSupplierToDelete)) {
            // Redirect atau tampilkan pesan berhasil
            header('Location: ' . BASEURL . '/Supplier');
            exit();
        } else {
            // Tampilkan pesan gagal
            echo "Gagal menghapus barang";
        }
    }
}