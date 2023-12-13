<?php

class Transaksi extends Controller
{
    public function index(){
        $this->view('template/header');
        // Memeriksa apakah ada data pencarian
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
            // Jika ada data pencarian, panggil fungsi untuk mendapatkan data barang berdasarkan pencarian
            $searchTerm = $_POST['search'];
            $dataBarang = $this->model('BarangModel')->searchDataBarang($searchTerm);
          } else if (isset($_GET['kategori'])) {
            // Jika ada parameter kategori
            $kategori = $_GET['kategori'];
            $dataBarang = $this->model('BarangModel')->getDataBarangByCategory($kategori);
          } else {
            // Jika tidak ada data pencarian atau parameter kategori, tampilkan semua data barang
            $dataBarang = $this->model('BarangModel')->getDataBarang();
          }


        $this->view('transaksi/index', $dataBarang);
        
        $this->view('transaksi/cart');

        $this->view('template/footer');
    }
    public function cart(){
        $this->view('transaksi/cart');
    }
}