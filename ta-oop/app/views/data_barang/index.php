<?php

//namespace data_barang;

//<?php
//    require_once 'config/config.php'; // Pastikan file Database.php sudah di-include
//    require_once 'classes/Barang.php'; // Pastikan file Item.php sudah di-include
//    require_once 'classes/Supplier.php'; // Pastikan file Item.php sudah di-include
//
//    // Membuat instance dari class Database
//    $database = new Database();
//    $conn = $database->conn;

    // Membuat instance dari class Item
//    $barang = new BarangModel();
//    $supplier = new SupplierModel();
?>

    <main class="d-flex flex-nowrap">
    <?php
    include "../app/views/template/sidebar.php";
    ?>

    <div class="data-barang overflow-auto" style="width: 100%">
        <div class="nav-utama"></div>
        <div class="wrap-barang bg-gray pt-5">
          <div class="header pt-4 pt-5 border-bot ms-4 me-5">
            <h2 class="fw-bold mb-3">Product</h2>
            <div class="wrap-header d-flex justify-content-between align-items-center">
              <ul class="list-grup gap-3 ps-0">

                <li class="list-item"><a href="DataBarang" ><i class="fa-solid fa-border-all me-1"></i> All Items</a></li>
                <li class="list-item"><a href="http://localhost/ta-oop/public/DataBarang/filterBarang/1" ><i class="fa-solid fa-utensils me-1"></i> Food</a></li>
                  <form action='http://localhost/ta-oop/public/DataBarang' method='post';'>
                  <input type='hidden' name='kategori' value=1>
                  <button type='submit' class='fa-solid fa-utensils me-1'>Food</button>
                  </form>
                  <form action='http://localhost/ta-oop/public/DataBarang' method='post';'>
                  <input type='hidden' name='kategori' value=2>
                  <button type='submit' class='fa-solid fa-wine-glass me-1'>Drink</button>

                  </form><form action='http://localhost/ta-oop/public/DataBarang' method='post';'>
                  <input type='hidden' name='kategori' value=3>
                  <button type='submit' class='fa-solid fa-burger me-1'>Snack</button>
                  </form>

<!--                <li class="list-item"><a href="DataBarang/index?kategori=2" ><i class="fa-solid fa-wine-glass me-1"></i> Drink</a></li>-->
<!--                <li class="list-item"><a href="index.php?page=dataBarang&kategori=3" ><i class="fa-solid fa-burger me-1"></i> Snack</a></li>-->
              </ul>
              <div class="grup pe-0 d-flex">
                <button type="button" class="me-3 rounded-3 px-3 py-1 add-barang" data-bs-toggle="modal" data-bs-target="#addModal">Add Product</button>
                <form action="http://localhost/ta-oop/public/DataBarang" method="post">
                    <input type="text" name="search" id="search" placeholder="Search..." class="px-3 py-1 rounded-3 search" style="width: 13rem" />
                    <button type="submit" class="me-3 rounded-3 px-3 py-1 cari-barang">
                      <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
              </div>
            </div>
          </div>
          <table class="ms-4 mt-2">
            <thead>
              <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Nama</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Nama Supplier</th>
                <th>Stock</th>
                <th>Option</th>
              </tr>
            </thead>


            <tbody>
            <?php
//            include "../app/controllers/DataBarang.php";
//            tampilDataBarang();
            ?>
<!--              --><?php
//                $dataSupplier = $data['supplier'];
//                echo "isi supp";
//                var_dump($dataSupplier);
//                // Memeriksa apakah ada data pencarian
//
//                // Inisialisasi variabel
//                $searchTerm = '';
//
//                // Memeriksa apakah ada data pencarian
//                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
//                    // Jika ada data pencarian, panggil fungsi untuk mendapatkan data barang berdasarkan pencarian
//                    $searchTerm = $_POST['search'];
//                    $dataBarang = $data['barang']->searchDataBarang($searchTerm);
//                } else if (isset($_GET['kategori'])) {
//                    // Jika ada parameter kategori
//                    $kategori = $_GET['kategori'];
//                    $dataBarang = $data['barang']->getDataBarangByCategory($kategori);
//                } else {
//                    // Jika tidak ada data pencarian atau parameter kategori, tampilkan semua data barang
//                    $dataBarang = $data['barang']->getDataBarang();
//                }
//
//                $no = 1;
//                foreach ($dataBarang as $item) {
//                  echo "<tr>";
//                  echo "<td>" . $no++ . "</td>";
//                  echo "<td><img src='uploads/" . $item['gambar'] . "' alt='' style='width: 4rem' class='rounded-3' /></td>";
//                  echo "<td>" . $item['nama_barang'] . "</td>";
//                  echo "<td>Rp. " . number_format($item['harga_beli']) . "</td>";
//                  echo "<td>Rp. " . number_format($item['harga_jual']) . "</td>";
//                  $supplierName = "";
//                  foreach ($dataSupplier as $supplier) {
//                      if ($supplier['id_supplier'] == $item['id_supplier']) {
//                          $supplierName = $supplier['nama_supplier'];
//                          break;
//                      }
//                  }
//                  echo "<td>" . $supplierName . "</td>";
//                  echo "<td>" . $item['stok_barang'] . "</td>";
//                  echo "<td>
//                          <a href='admin/fungsi/editBarang.php?action=edit&id=" . $item['id_barang'] . "' class='edit'>Edit</a>
//                          <a href='admin/fungsi/deleteBarang.php?action=delete&id=" . $item['id_barang'] . "' class='hapus' onclick='return confirm(\"Hapus Data Barang ?\");'>Delete</a>
//                      </td>";
//                  echo "</tr>";
//                }
//              ?>
