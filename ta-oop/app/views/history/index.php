
    
    <main class="d-flex flex-nowrap">
    <?php
        include "../app/views/template/sidebar.php";
    ?>
    
    <div class="data-barang overflow-auto" style="width: 100%">
        <div class="nav-utama"></div>
        <div class="wrap-barang bg-gray pt-5">
          <div class="header pb-2 pt-4 ms-4 me-5 mt-3 d-flex justify-content-between align-items-center border-bot">
            <h2 class="fw-bold">History Penjualan</h2>
            <div class="grup pe-0 mt-3">
            <form action="" method="post" class="mb-2">
              <select id="supplier" name="supplier" class="px-3 py-1 rounded-3 pilih-bulan me-2" style="width: 10rem">
              <option value="">Supplier</option>
                <?php
                // $dataSup = $supplier->getSuppliers();
                foreach ($data['suppliers'] as $item){
                  echo '<option value="'.$item['id_supplier'].'">'.$item['nama_supplier'].'</option>';
                }        
                ?>
              </select>
              <input type="date" name="date" id="date" class="date px-3 py-1 rounded-3" style="width: 10rem">
              <button type="submit" name="filter1" class="mx-2 rounded-3 px-3 py-1 cari-barang"><i class="fa-solid fa-list"></i></button>
            </form>
              
            <form action="" method="post">
              <select id="bulan" name="bulan" class="px-3 py-1 rounded-3 pilih-bulan me-2" style="width: 10rem">
                <option value="13">Bulan</option>
                <option value="1">Januari</option>
                <option value="2">Februari</option>
                <option value="3">Maret</option>
                <option value="4">April</option>
                <option value="5">Mei</option>
                <option value="6">Juni</option>
                <option value="7">Juli</option>
                <option value="8">Agustus</option>
                <option value="9">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
              </select>
              <select id="tahun" name="tahun" class="px-3 py-1 rounded-3 pilih-tahun" style="width: 10rem">
                <option value="1">Tahun</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
              </select>
              <button type="submit" name="filter2" class="mx-2 rounded-3 px-3 py-1 cari-barang"><i class="fa-solid fa-list"></i></button>
            </form>
            
            </div>
          </div>
          <div class="table-responsive mx-4 me-5">
            <table class="mt-2 table table-secondary table-bordered">
              <thead>
                <tr class="table-light"> 
                  <th>No</th>
                  <th>Date</th>
                  <th style="width: 27%">Nama Barang</th>
                  <th>Total Beli</th>
                  <th>Total Harga</th>
                  <th>Jumlah</th>
                  <th>Option</th>
                </tr>
              </thead>
              <tbody>
              <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filter1'])) {
                  $no = 1;
                  $jumlahBeli = 0;
                  $jumlahJual = 0;
              
                  foreach ($data['history'] as $item) {
                      ?>
                      <tr class="bg-secondary">
                          <td><?php echo $no++; ?></td>
                          <td><?php echo $item['tanggal_transaksi']; ?></td>
                          <td><?php echo $item['nama_barang']; ?></td>
                          <td>Rp. <?php echo number_format($item['harga_beli']); ?></td>
                          <td>Rp. <?php echo number_format($item['harga_jual']); ?></td>
                          <td><?php echo $item['total_qty']; ?></td>
                          <td><a href='admin/fungsi/detailHistory.php?action=detail&id=<?php echo $item['id_transaksi']; ?>' class='edit'>Detail</a></td>
                      </tr>
                      <?php
                      $jumlahBeli += $item['harga_beli'];
                      $jumlahJual += $item['harga_jual'];
                  }
                  ?>
                  <tr>
                      <td  colspan="3">Total Penjualan :</td>
                      <td>Rp. <?php echo number_format($jumlahBeli); ?></td>
                      <td>Rp. <?php echo number_format($jumlahJual); ?></td>
                      <td></td>
                      <td></td>
                  </tr>
                  <tr>
                      <td class="table-success" colspan="3">Total Keuntungan :</td>
                      <td class="table-success"colspan="2" >Rp. <?php echo number_format($jumlahJual - $jumlahBeli); ?></td>
                      <td></td>
                      <td></td>
                  </tr>
                  <?php
                    } else {
                        $no = 1;
                        foreach ($data['history'] as $item) {
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $item['tanggal_transaksi']; ?></td>
                                <td><?php echo $item['nama_barang']; ?></td>
                                <td>Rp. <?php echo number_format($item['total_beli']); ?></td>
                                <td>Rp. <?php echo number_format($item['total_transaksi']); ?></td>
                                <td><?php echo $item['total_qty']; ?></td>
                                <td><a href='admin/fungsi/detailHistory.php?action=detail&id=<?php echo $item['id_transaksi']; ?>' class='edit'>Detail</a></td>
                            </tr>
                            <?php
                        }
                    }
      //           ?>
              </tbody>
            </table>
          </div>
         </div>
       </div>
     </main>