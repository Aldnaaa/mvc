<?php
class HistoryModel {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // Metode lain tetap sama

    public function getHistory() {
        $sql = "  
            SELECT 
                t.tanggal_transaksi, 
                t.id_transaksi,
                CASE
                    WHEN LENGTH(GROUP_CONCAT(' ', b.nama_barang)) > 40 
                    THEN 
                        CONCAT(LEFT(GROUP_CONCAT(' ', b.nama_barang), 40), ' ...')
                    ELSE 
                        GROUP_CONCAT(' ',b.nama_barang)
                END AS nama_barang,
                t.total_transaksi,
                SUM(qty * harga_beli) AS total_beli,
                SUM(dt.qty) AS total_qty
            FROM 
                transaksi t
            INNER JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
            INNER JOIN barang b ON dt.id_barang = b.id_barang
            GROUP BY t.id_transaksi, t.tanggal_transaksi;
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : array();
    }

    public function searchHistoryByMonthYear($month, $year) {
        $sql = "
            SELECT 
                t.tanggal_transaksi, 
                t.id_transaksi,
                CASE
                    WHEN LENGTH(GROUP_CONCAT(' ', b.nama_barang)) > 40 
                    THEN 
                        CONCAT(LEFT(GROUP_CONCAT(' ', b.nama_barang), 40), ' ...')
                    ELSE 
                        GROUP_CONCAT(' ', b.nama_barang)
                END AS nama_barang,
                t.total_transaksi,
                SUM(qty * harga_beli) AS total_beli,
                SUM(dt.qty) AS total_qty
            FROM 
                transaksi t
            INNER JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
            INNER JOIN barang b ON dt.id_barang = b.id_barang
            WHERE MONTH(tanggal_transaksi) = :month AND YEAR(tanggal_transaksi) = :year
            GROUP BY t.id_transaksi, t.tanggal_transaksi;
        ";
    
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':month', $month, PDO::PARAM_INT);
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } else {
            return array();
        }
    }

    public function searchHistoryByMonth($month) {
        $sql = "  
            SELECT 
                t.tanggal_transaksi, 
                t.id_transaksi,
                CASE
                    WHEN LENGTH(GROUP_CONCAT(' ', b.nama_barang)) > 40 
                    THEN 
                        CONCAT(LEFT(GROUP_CONCAT(' ', b.nama_barang), 40), ' ...')
                    ELSE 
                        GROUP_CONCAT(' ',b.nama_barang)
                END AS nama_barang,
                t.total_transaksi,
                SUM(qty * harga_beli) AS total_beli,
                SUM(dt.qty) AS total_qty
            FROM 
                transaksi t
            INNER JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
            INNER JOIN barang b ON dt.id_barang = b.id_barang
            WHERE MONTH(tanggal_transaksi) = :month
            GROUP BY t.id_transaksi, t.tanggal_transaksi;
        ";
    
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':month', $month, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $result ? $result : array();
    }
    
    public function searchHistoryByYear($year) {
        $sql = "  
            SELECT 
                t.tanggal_transaksi, 
                t.id_transaksi,
                CASE
                    WHEN LENGTH(GROUP_CONCAT(' ', b.nama_barang)) > 40 
                    THEN 
                        CONCAT(LEFT(GROUP_CONCAT(' ', b.nama_barang), 40), ' ...')
                    ELSE 
                        GROUP_CONCAT(' ',b.nama_barang)
                END AS nama_barang,
                t.total_transaksi,
                SUM(qty * harga_beli) AS total_beli,
                SUM(dt.qty) AS total_qty
            FROM 
                transaksi t
            INNER JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
            INNER JOIN barang b ON dt.id_barang = b.id_barang
            WHERE YEAR(tanggal_transaksi) = :year
            GROUP BY t.id_transaksi, t.tanggal_transaksi;        
        ";
    
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $result ? $result : array();
    }
    
    public function getHistoryByDate($date) {
        $sql = "
            SELECT 
                t.tanggal_transaksi, 
                t.id_transaksi,
                CASE
                    WHEN LENGTH(GROUP_CONCAT(' ', b.nama_barang)) > 40 
                    THEN 
                        CONCAT(LEFT(GROUP_CONCAT(' ', b.nama_barang), 40), ' ...')
                    ELSE 
                        GROUP_CONCAT(' ',b.nama_barang)
                END AS nama_barang,
                SUM(qty * b.harga_jual) AS harga_jual,
                SUM(qty * b.harga_beli) AS harga_beli,
                SUM(dt.qty) AS total_qty
            FROM 
                transaksi t
            INNER JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
            INNER JOIN barang b ON dt.id_barang = b.id_barang
            INNER JOIN supplier s ON s.id_supplier = b.id_supplier
            WHERE DATE(t.tanggal_transaksi) = :date
            GROUP BY t.id_transaksi, t.tanggal_transaksi;
        ";
    
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $result ? $result : array();
    }
    
    public function getHistoryBySupplier($idx) {
        $sql = "
            SELECT 
                t.tanggal_transaksi, 
                t.id_transaksi,
                CASE
                    WHEN LENGTH(GROUP_CONCAT(' ', b.nama_barang)) > 40 
                    THEN 
                        CONCAT(LEFT(GROUP_CONCAT(' ', b.nama_barang), 40), ' ...')
                    ELSE 
                        GROUP_CONCAT(' ',b.nama_barang)
                END AS nama_barang,
                SUM(qty * b.harga_jual) AS harga_jual,
                SUM(qty * b.harga_beli) AS harga_beli,
                SUM(dt.qty) AS total_qty
            FROM 
                transaksi t
            INNER JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
            INNER JOIN barang b ON dt.id_barang = b.id_barang
            INNER JOIN supplier s ON s.id_supplier = b.id_supplier
            WHERE s.id_supplier = :idx
            GROUP BY t.id_transaksi, t.tanggal_transaksi;   
        ";
    
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idx', $idx, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $result ? $result : array();
    }
}
?>