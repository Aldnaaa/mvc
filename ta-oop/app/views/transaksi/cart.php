 <!-- Baris di bawah adalah tempat di mana orderMenu.php akan diletakkan -->
 <div class="order-menu bg-white p-3 ms-0" style="width: 22%; height: 88%">
            <div class="header-order-menu border-bot">
              <h5 class="fw-bold">Order Menu</h5>
              <p class="date-menu">01/Sep/2023</p>
            </div>
            <div class="items pt-3" style="height: 72%">
              <div class="title d-flex align-items-center justify-content-between">
                <h5 class="fw-bold mb-1">Items</h5>
                <form method="POST" action="admin/fungsi/deleteCart.php">
                  <button type="submit" name="clear_cart" class="btn bg-dongker text-white remove-items p-0" style="height: 1.5rem; width: 3rem; font-size: .7rem">Clear</button>
                </form>
              </div>
              <div class="items-wrap mb-0" style="height: 20rem">
              <?php
                  // Ensure $_SESSION["cart"] is initialized as an array
                  if (!isset($_SESSION["cart"]) || !is_array($_SESSION["cart"])) {
                    $_SESSION["cart"] = array();
                  }
                  
                  $totalQuantity = 0;

                  // Calculate total price using the function
                  $totalPrice = $this->model('TransaksiModel')->calculateTotalPrice($_SESSION["cart"], $barang);

                  // Loop untuk menampilkan item di keranjang
                  if (isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) {
                    foreach ($_SESSION["cart"] as $cartItem) {
                        $id_barang = $cartItem["id_barang"];
                        $itemQuantity = $cartItem["quantity_" . $id_barang];

                        // Query ke database untuk mendapatkan informasi barang
                        $item = $barang->getBarangById($id_barang);
                        ?>
                        <div class="list-items-order d-flex border-bot py-2 justify-content-between">
                          <div class="d-flex py-2">
                            <img src="uploads/<?php echo $item['gambar']; ?>" alt="order items" style="height: 50px;width:70px;" />
                            <div class="inner-items-order ms-2 d-flex flex-column justify-content-center">
                                <p class="items-order-title fw-bold mb-1"><?php echo $item['nama_barang']; ?></p>
                                <p class="items-order-harga mb-1">Rp. <?php echo number_format($item['harga_jual']); ?></p>
                            </div>
                          </div>
                          <div class="items-kuantiti d-flex flex-column justify-content-between align-items-end gap-1 me-1" >
                              <form method="POST" action="admin/fungsi/deleteCart.php">
                                <input type="hidden" name="id_barang" value="<?php echo $item['id_barang']; ?>">
                                <button type="submit" name="remove_from_cart" class="remove-items btn btn-danger p-0" style="height: 1rem; width: 1rem; font-size: .6rem">x</button>
                              </form>
                              <div class="items-kuantiti d-flex align-items-end gap-1 ms-4 me-0">
                                <p class="m-0"><?php echo $itemQuantity . ' item'; ?></p>
                              </div>
                          </div>
                        </div>
              <?php
                        $totalQuantity += $itemQuantity;
                    }
                  }
              ?>
            </div>
            </div>
            <div class="bayar-container border-top py-2 px-1 mt-2">
              <div class="bayar-items d-flex justify-content-between bg-dongker py-2 px-2 rounded-4 align-items-center">
                  <div class="bayar-teks ms-2">
                      <p class="mb-1 jml-item"><?php echo $totalQuantity . " items"; ?></p>
                      <p class="text-white mb-0 jml-harga"><?php echo "Rp. " . number_format($totalPrice); ?></p>
                  </div>
                  <button type="submit" class="rounded-5 px-3  bg-white" style="height: 2rem" data-bs-toggle="modal" data-bs-target="#bayarModal">Entry</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="bayarModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Proses Transaksi</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="admin/fungsi/checkout.php">
                  <div class="modal-body d-flex flex-column align-items-center">
                      <p class="mb-2">Harga Total</p>
                      <h4 class="fw-bold"><?php echo "Rp. " . number_format($totalPrice); ?></h4>
                  </div>
                  <div class="modal-body">
                      <p class="mb-1">Uang yang dibayar</p>
                      <input type="text" class="form-control" id="uangBayar" name="uangBayar" />
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-danger" name="bayar">Bayar</button>
                  </div>
                  </form>
              </div>
        </div>
      </div>
