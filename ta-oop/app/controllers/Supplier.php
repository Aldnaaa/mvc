<?php

class Supplier extends Controller
{
    public function index(){
        $this->view('template/header');
        $this->view('supplier/index');
        $dataSupplier = $this->model('SupplierModel')->getSuppliers();

        // Inisialisasi variabel
        $searchTerm = '';
        // Memeriksa apakah ada data pencarian
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
            // Jika ada data pencarian, panggil fungsi untuk mendapatkan data barang berdasarkan pencarian
            $searchTerm = $_POST['search'];
            $dataSupplier = $this->model('SupplierModel')->searchDataSupplier($searchTerm);
        } else {
            // Jika tidak ada data pencarian, panggil fungsi untuk mendapatkan semua data supplier
            $dataSupplier = $this->model('SupplierModel')->getSuppliers();
        }

        $no = 1;
        foreach ($dataSupplier as $supplierData) {
            echo "<tr class='py-3' style='height: 3rem'>";
            echo "<td>" . $no . "</td>";
            echo "<td>" . $supplierData['nama_supplier'] . "</td>";
            echo "<td>" . $supplierData['tanggal_input'] . "</td>";
            echo "<td>
                        <a href='admin/fungsi/editSupplier.php?action=edit&id=" . $supplierData['id_supplier'] . "' class='edit'>Edit</a>
                        <a href='http://localhost/ta-oo/public/" . $supplierData['id_supplier'] . "' class='hapus' onclick='return confirm(\"Hapus Data Supplier ?\");'>Delete</a>
                    </td>";
            echo "</tr>";
            $no++;
        }


        $this->view('supplier/footer');
        $this->view('template/footer');
    }
}