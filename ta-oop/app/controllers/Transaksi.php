<?php

class Transaksi extends Controller
{
    // public function index(){
    //   $this->view('template/header');
    //   $searchTerm = '';
    
    //   if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    //       $searchTerm = $_POST['search'];
    //       $data['barang'] = $this->model('BarangModel')->searchDataBarang($searchTerm);
    //   } elseif (isset($_POST['kategori'])) {
    //       $kategori = $_POST['kategori'];
    //       $data['barang'] = $this->model('BarangModel')->getDataBarangByCategory($kategori);
    //   } else {
    //       $data['barang'] = $this->model('BarangModel')->getDataBarang();
    //   }

    //   $data['totalPrice'] = $this->calculateTotalPrice($_SESSION["cart"]);
    //   $this->view('transaksi/index', $data);
      
    //   // $this->view('transaksi/cart');

    //   $this->view('template/footer');
    // }

        public function index()
    {
        $this->view('template/header');
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

        if (!isset($_SESSION["cart"]) || !is_array($_SESSION["cart"])) {
            $_SESSION["cart"] = array();
        }

        $data['totalPrice'] = $this->calculateTotalPrice($_SESSION["cart"]);

        // Membuat array baru untuk menyimpan data barang untuk keranjang
        $data['cartItems'] = array();

        // Loop untuk menambahkan informasi barang ke setiap item di keranjang
        foreach ($_SESSION["cart"] as $cartItem) {
            $id_barang = $cartItem["id_barang"];
            $itemQuantity = $cartItem["quantity_" . $id_barang];

            // Query ke database untuk mendapatkan informasi barang
            $item = $this->model('BarangModel')->getBarangById($id_barang);
            $item['quantity'] = $itemQuantity; // Menambahkan jumlah barang ke array

            // Menambahkan data barang ke array
            $data['cartItems'][] = $item;
        }

        $this->view('transaksi/index', $data);

        $this->view('template/footer');
    }

    public function tambahKeranjang(){
      // Handle adding items to the session cart
      if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
        $id_barang_to_add = $_POST['id_barang'];

        // Check if the item is already in the cart
        $item_exists_in_cart = false;
        foreach ($_SESSION["cart"] as $cartItem) {
            if ($cartItem["id_barang"] == $id_barang_to_add) {
                $item_exists_in_cart = true;
                break;
            }
        }

        // If the item is not in the cart, add it
        if (!$item_exists_in_cart) {
            // Include the product ID in the quantity name
            $quantity_to_add = isset($_POST['quantity_' . $id_barang_to_add]) ? $_POST['quantity_' . $id_barang_to_add] : 1;

            $_SESSION["cart"][] = array("id_barang" => $id_barang_to_add, "quantity_" . $id_barang_to_add => $quantity_to_add);
        }

        header('Location: ' . BASEURL . '/Transaksi');
        exit();
      }

    }

    public function hapusKeranjang(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_from_cart'])) {
            $id_barang_to_remove = $_POST['id_barang'];
        
            // Ensure $_SESSION["cart"] is initialized as an array
            if (!isset($_SESSION["cart"]) || !is_array($_SESSION["cart"])) {
                $_SESSION["cart"] = array();
            }
        
            // Loop through the cart items and remove the matching item
            foreach ($_SESSION["cart"] as $key => $cartItem) {
                if ($cartItem["id_barang"] == $id_barang_to_remove) {
                    unset($_SESSION["cart"][$key]);
                    break;
                }
            }
        
            header('Location: ' . BASEURL . '/Transaksi');
            exit();
        
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear_cart'])) {
            // Clear the entire shopping cart
            $_SESSION["cart"] = array();
            
            header('Location: ' . BASEURL . '/Transaksi');
            exit();
        }        
    }

    public function calculateTotalPrice($cart) {
      $totalPrice = 0;
  
      if (!empty($cart)) {
          foreach ($cart as $cartItem) {
              $id_barang = $cartItem["id_barang"];
              $itemQuantity = $cartItem["quantity_" . $id_barang];
  
              $item = $this->model('BarangModel')->getBarangById($id_barang);
              $itemPrice = $item['harga_jual'] * $itemQuantity;
  
              $totalPrice += $itemPrice;
          }
      }
  
      return $totalPrice;
    }

    public function checkout()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bayar'])) {
            // Get the money paid by the user
            $uangBayar = isset($_POST['uangBayar']) ? $_POST['uangBayar'] : 0;
    
            // Check if the cart is not empty
            if (!empty($_SESSION["cart"])) {
                // Calculate total price using the function
                $totalPrice = $this->calculateTotalPrice($_SESSION["cart"]);
    
                // Check if the payment is sufficient
                if ($uangBayar >= $totalPrice) {
                    // Perform the transaction and insert data into the database
    
                    // Step 1: Insert into 'transaksi' table
                    $idUser = 2; // Replace with the actual user ID
                    $totalTransaksi = $totalPrice;
    
                    $idTransaksi = $this->model('TransaksiModel')->addTransaksi($idUser, $totalTransaksi);
    
                    // Step 2: Insert into 'detail_transaksi' table for each item in the cart
                    foreach ($_SESSION["cart"] as $cartItem) {
                        $idBarang = $cartItem["id_barang"];
                        $quantity = $cartItem["quantity_" . $idBarang];
    
                        // Update the stock in 'barang' table
                        $this->model('BarangModel')->updateStock($idBarang, $quantity);
    
                        // Insert into 'detail_transaksi' table
                        $this->model('TransaksiModel')->addDetailTransaksi($idBarang, $idTransaksi, $quantity);
                    }
    
                    // Store values in session
                    $_SESSION['last_transaction_id'] = $idTransaksi;
                    $_SESSION['totalTunai'] = $uangBayar;
    
                    // Clear the entire shopping cart
                    $_SESSION["cart"] = array();
    
                    header("Location: strukCart.php");
                    exit();
                } else {
                    echo '<script>alert("Uang Anda Kurang."); window.location.href = "../../index.php?page=transaksi";</script>';
                    exit();
                }
            } else {
                // Display an error message if the cart is empty
                echo '<script>alert("Anda belum menambahkan barang."); window.location.href = "../../index.php?page=transaksi";</script>';
            }
        }
    }
    
}