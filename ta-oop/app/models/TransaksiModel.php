<?php
class TransaksiModel {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function addTransaksi($idUser, $totalTransaksi) {
        // Insert into 'transaksi' table
        $tanggalTransaksi = date("Y-m-d H:i:s"); // Current date and time
    
        $insertTransaksiQuery = "INSERT INTO transaksi (id_user, total_transaksi, tanggal_transaksi) VALUES (:idUser, :totalTransaksi, :tanggalTransaksi)";
        $stmt = $this->db->prepare($insertTransaksiQuery);
        $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
        $stmt->bindParam(':totalTransaksi', $totalTransaksi, PDO::PARAM_STR);
        $stmt->bindParam(':tanggalTransaksi', $tanggalTransaksi, PDO::PARAM_STR);
        $stmt->execute();
    
        // Get the last inserted ID (id_transaksi) using the Database class method
        return $this->db->getLastInsertId();
    }    

    public function addDetailTransaksi($idBarang, $idTransaksi, $quantity) {
        $insertDetailQuery = "INSERT INTO detail_transaksi (id_barang, id_transaksi, qty) VALUES (:idBarang, :idTransaksi, :quantity)";
        $stmt = $this->db->prepare($insertDetailQuery);
        $stmt->bindParam(':idBarang', $idBarang, PDO::PARAM_INT);
        $stmt->bindParam(':idTransaksi', $idTransaksi, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getDetailTransaksiById($idTransaksi)
    {
        $sql = "SELECT dt.*, b.nama_barang, b.harga_jual, (dt.qty * b.harga_jual) as total_harga FROM detail_transaksi dt
                INNER JOIN barang b ON dt.id_barang = b.id_barang
                WHERE dt.id_transaksi = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idTransaksi]);
        $detailTransaksi = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $detailTransaksi;
    }

    public function getTotalTransaksiById($idTransaksi)
    {
        $sql = "SELECT total_transaksi FROM transaksi WHERE id_transaksi = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idTransaksi]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_transaksi'];
    }

    public function getTotalTransaksi() {
        $query = "SELECT COUNT(*) as total_rows FROM transaksi";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_rows'];
    }

    public function getTotalPemasukan() {
        $query = "SELECT SUM(total_transaksi) as total_rows FROM transaksi";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_rows'];
    }
}
?>
