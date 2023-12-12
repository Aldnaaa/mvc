<?php

//namespace Model;

class BarangModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function tambahBarang($nama, $kategori, $hargaBeli, $hargaJual, $supplier, $stock, $foto)
    {
        $sql = "INSERT INTO barang (nama_barang, id_kategori, harga_beli, harga_jual, id_supplier, stok_barang, gambar) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);

        // Bind nilai parameter
        $stmt->bindValue(1, $nama, PDO::PARAM_STR);
        $stmt->bindValue(2, $kategori, PDO::PARAM_INT);
        $stmt->bindValue(3, $hargaBeli, PDO::PARAM_INT);
        $stmt->bindValue(4, $hargaJual, PDO::PARAM_INT);
        $stmt->bindValue(5, $supplier, PDO::PARAM_INT);
        $stmt->bindValue(6, $stock, PDO::PARAM_INT);
        $stmt->bindValue(7, $foto, PDO::PARAM_STR);

        // Eksekusi query
        if ($stmt->execute()) {
            return true; // Berhasil menambah barang
        } else {
            return false; // Gagal menambah barang
        }
    }

    public function getDataBarang()
    {
        // Ambil data barang dari database
        $sql = "SELECT * FROM barang";
        $stmt = $this->db->prepare($sql);
//        $stmt = $this->db->prepare($query);
        $result = $stmt->execute();
        // Cek jika ada data
        $data = array();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $data;
//        if ($result) {
//            $data = array();
//            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
//                $data[] = $row;
//            }
//            return $data;
//        } else {
//            return array();
//        }
    }

    public function deleteBarang($idBarang)
    {
        // Hapus barang berdasarkan ID
        $sql = "DELETE FROM barang WHERE id_barang = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, $idBarang, PDO::PARAM_INT);

        // Eksekusi query
        return $stmt->execute();
    }

    public function getBarangById($idBarang)
    {
        // Ambil data barang berdasarkan ID
        $sql = "SELECT * FROM barang WHERE id_barang = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $idBarang);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function updateBarang($idBarang, $nama, $kategori, $hargaBeli, $hargaJual, $supplier, $stock, $foto)
    {
        // Update data barang berdasarkan ID
        $sql = "UPDATE barang SET nama_barang = ?, id_kategori = ?, harga_beli = ?, harga_jual = ?, id_supplier = ?, stok_barang = ?, gambar = ? WHERE id_barang = ?";
        $stmt = $this->db->prepare($sql);

        // Assuming id_kategori, harga_beli, harga_jual, and stok_barang are integers,
        // and supplier is a string, adjust the data types accordingly
        $stmt->bind_param("siiiiisi", $nama, $kategori, $hargaBeli, $hargaJual, $supplier, $stock, $foto, $idBarang);

        return $stmt->execute();
    }


//    public function searchDataBarang($searchTerm)
//    {
//        // Saring data barang berdasarkan nama_barang
//        $sql = "SELECT * FROM barang WHERE nama_barang LIKE ?";
//        $stmt = $this->db->prepare($sql);
//
//        // Tambahkan tanda persen (%) pada awal dan akhir search term untuk mencari nama_barang yang mengandung
//        $searchTerm = "%$searchTerm%";
//        $stmt->bind_param("s", $searchTerm);
//
//        // Eksekusi query
//        $stmt->execute();
//
//        // Ambil hasil
//        $result = $stmt->get_result();
//
//        // Cek jika ada data
//        if ($result->num_rows > 0) {
//            $data = array();
//            while ($row = $result->fetch_assoc()) {
//                $data[] = $row;
//            }
//            return $data;
//        } else {
//            return array();
//        }
//    }
    public function searchDataBarang($searchTerm)
    {
        // Saring data barang berdasarkan nama_barang
        $sql = "SELECT * FROM barang WHERE nama_barang LIKE :searchTerm";
        $stmt = $this->db->prepare($sql);

        // Tambahkan tanda persen (%) pada awal dan akhir search term untuk mencari nama_barang yang mengandung
        $searchTerm = "%$searchTerm%";
        $stmt->bindValue(':searchTerm', $searchTerm, PDO::PARAM_STR);

        // Eksekusi query
        $stmt->execute();

        // Ambil hasil
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Mengembalikan hasil
        return $result;
    }


    public function getDataBarangByCategory($kategori)
    {
        // Ambil data barang berdasarkan kategori
        $sql = "SELECT * FROM barang WHERE id_kategori = :kategori";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':kategori', $kategori, PDO::PARAM_INT);
        $stmt->execute();

        // Mengembalikan hasil dalam bentuk array associative
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


//    public function getJenisBarang()
//    {
//        $query = "SELECT COUNT(*) as total_rows FROM barang";
//        $stmt = $this->db->prepare($query);
//        $stmt->execute();
//        $result = $stmt->get_result();
//        $row = $result->fetch_assoc();
//
//        return $row['total_rows'];
//    }
    public function getJenisBarang()
    {
        $query = "SELECT COUNT(*) as total_rows FROM barang";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['total_rows'];
        } else {
            return 0; // Atau nilai default jika tidak ada hasil
        }
    }
}