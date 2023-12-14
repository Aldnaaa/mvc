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
              <ul class="list-grup gap-3 ps-0 mb-0">
                <li class="list-item"><a href="DataBarang" ><i class="fa-solid fa-border-all me-1"></i> All Items</a></li>
                <li class="list-item">                  
                  <form action='<?= BASEURL; ?>/DataBarang' method='post'>
                    <input type='hidden' name='kategori' value=1>
                    <button type='submit'><i class="fa-solid fa-utensils me-1"></i> Food</button>
                  </form>
                </li>
                <li class="list-item">                  
                  <form action='<?= BASEURL; ?>/DataBarang' method='post'>
                    <input type='hidden' name='kategori' value=2>
                    <button type='submit'><i class="fa-solid fa-wine-glass me-1"></i> Drink</button>
                  </form>
                </li>
                <li class="list-item">                  
                  <form action='<?= BASEURL; ?>/DataBarang' method='post'>
                    <input type='hidden' name='kategori' value=3>
                    <button type='submit'><i class="fa-solid fa-burger me-1"></i> Snack</button>
                  </form>
                </li>
              </ul>
              <div class="grup pe-0 d-flex">
                <button type="button" class="me-3 rounded-3 px-3 py-1 cari-barang" data-bs-toggle="modal" data-bs-target="#addModal"><i class="fa-solid fa-plus"></i> Add Product</button>
                <form action="<?= BASEURL; ?>/DataBarang" method="post">
                    <input type="text" name="search" id="search" placeholder="Search..." class="px-3 py-1 rounded-3 search" style="width: 13rem" />
                    <button type="submit" class="me-3 rounded-3 px-3 py-1 cari-barang">
                      <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
              </div>
            </div>
          </div>
          <div class="table-responsive mx-4 me-5">
                <table class="mt-2 table table-secondary table-bordered">
                    <thead>
                    <tr class="table-light">
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Supplier</th>
                        <th>Stock</th>
                        <th>Option</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $no = 1;
                    foreach ($data['barang'] as $item) { ?>
                    <tr>
                    <td><?php echo $no++; ?></td>
                    <td><img src='uploads/<?php echo $item['gambar']; ?>' alt='' style='width: 4rem' class='rounded-3' /></td>
                    <td><?php echo $item['nama_barang']; ?></td>
                    <td>Rp. <?php echo number_format($item['harga_beli']); ?></td>
                    <td>Rp. <?php echo number_format($item['harga_jual']); ?></td>
                    <?php
                    $supplierName = "";
                    foreach ($data['suppliers'] as $supplier) {
                        if ($supplier['id_supplier'] == $item['id_supplier']) {
                            $supplierName = $supplier['nama_supplier'];
                            break;
                        }
                    }
                    ?>
                    <td><?php echo $supplierName; ?></td>
                    <td><?php echo $item['stok_barang']; ?></td>
                    <td>
                        <a href="#" class='edit' data-bs-toggle="modal" data-bs-target="#editModal" data-id="<?= $item['id_barang']; ?>">Edit</a>
                        <!-- <a href="<?= BASEURL; ?>/mahasiswa/hapus/<?= $mhs['id'];?>" class='edit'>Edit</a> -->
                        <a href="<?= BASEURL; ?>/dataBarang/deleteBarang/<?= $item['id_barang'];?>" class='hapus' onclick='return confirm("Hapus Data Barang ?");'>Delete</a>
                    </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
          </div>
      </div>
    </div>

  </main>
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Barang Baru</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= BASEURL; ?>/DataBarang/tambahBarang" method="post" enctype="multipart/form-data" >
                        <div class="mb-1">
                            <label for="nama-barang" class="col-form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="nama-barang" name="nama-barang" />
                        </div>
                        <div class="mb-1">
                            <label for="kategori" class="col-form-label">Kategori</label><br />
                            <select id="kategori" name="kategori" class="px-2 py-1 rounded-2" style="width: 29rem">
                                <option value="1">Makanan</option>
                                <option value="2">Minuman</option>
                                <option value="3">Snack</option>
                            </select>
                        </div>
                        <div class="mb-1">
                            <label for="harga-beli" class="col-form-label">Harga Beli</label>
                            <input type="text" class="form-control" id="harga-beli" name="harga-beli" />
                        </div>
                        <div class="mb-1">
                            <label for="harga-jual" class="col-form-label">Harga Jual</label>
                            <input type="text" class="form-control" id="harga-jual" name="harga-jual" />
                        </div>
                        <div class="mb-1">
                            <label for="supplier" class="col-form-label">Supplier</label><br />
                            <select id="supplier" name="supplier" class="px-2 py-1 rounded-2" style="width: 29rem">
                                <?php foreach ($data['suppliers'] as $option): ?>
                                    <option value="<?= $option['id_supplier'] ?>"><?= $option['nama_supplier'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-1">
                            <label for="stock" class="col-form-label">Stock</label>
                            <input type="text" class="form-control" id="stock" name="stock" />
                        </div>
                        <div class="mb-1">
                            <label for="foto-barang" class="col-form-label">Foto</label>
                            <input type="file" class="form-control" id="foto-barang" name="foto-barang" accept="image/*" />
                        </div>
                        <div class="mb-1 d-flex justify-content-end mt-3 gap-2">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" name="submit" value="simpan">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Barang</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <form action="<?= BASEURL; ?>/DataBarang/updateBarang" method="post" enctype="multipart/form-data" id="editForm">
                      <!-- Add a hidden field to store the ID -->
                      <input type="hidden" name="idBarang" id="idBarang-edit">
                      <div class="mb-1">
                          <label for="nama-barang-edit" class="col-form-label">Nama Barang</label>
                          <input type="text" class="form-control" id="nama-barang-edit" name="nama-barang" />
                      </div>
                      <div class="mb-1">
                          <label for="kategori-edit" class="col-form-label">Kategori</label><br />
                          <select id="kategori-edit" name="kategori" class="px-2 py-1 rounded-2" style="width: 29rem">
                              <option value="1">Makanan</option>
                              <option value="2">Minuman</option>
                              <option value="3">Snack</option>
                          </select>
                      </div>
                      <div class="mb-1">
                          <label for="harga-beli-edit" class="col-form-label">Harga Beli</label>
                          <input type="text" class="form-control" id="harga-beli-edit" name="harga-beli" />
                      </div>
                      <div class="mb-1">
                          <label for="harga-jual-edit" class="col-form-label">Harga Jual</label>
                          <input type="text" class="form-control" id="harga-jual-edit" name="harga-jual" />
                      </div>
                      <div class="mb-1">
                          <label for="supplier-edit" class="col-form-label">Supplier</label><br />
                          <select id="supplier-edit" name="supplier" class="px-2 py-1 rounded-2" style="width: 29rem">
                              <?php foreach ($data['suppliers'] as $option): ?>
                                  <option value="<?= $option['id_supplier'] ?>"><?= $option['nama_supplier'] ?></option>
                              <?php endforeach; ?>
                          </select>
                      </div>
                      <div class="mb-1">
                          <label for="stock-edit" class="col-form-label">Stock</label>
                          <input type="text" class="form-control" id="stock-edit" name="stock" />
                      </div>
                      <div class="mb-1">
                          <label for="foto-barang-edit" class="col-form-label">Foto</label>
                          <input type="file" class="form-control" id="foto-barang-edit" name="foto-barang" accept="image/*" />
                      </div>
                      <div class="mb-1 d-flex justify-content-end mt-3 gap-2">
                          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                          <button type="submit" class="btn btn-primary" name="submit" value="simpan">Simpan</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>

  <script>
    $(document).ready(function () {
    $("#editModal").on("shown.bs.modal", function () {
        $("a.edit").on("click", function (e) {
            e.preventDefault(); // Prevent the default behavior of the anchor tag

            var id = $(this).data("id");

            $.ajax({
                url: '<?= BASEURL; ?>/DataBarang/getBarangById/' + id,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    // Populate the form fields with received data
                    $('#idBarang-edit').val(data.id_barang);
                    $('#nama-barang-edit').val(data.nama_barang);
                    $('#kategori-edit').val(data.id_kategori);
                    $('#harga-beli-edit').val(data.harga_beli);
                    $('#harga-jual-edit').val(data.harga_jual);
                    $('#supplier-edit').val(data.id_supplier);
                    $('#stock-edit').val(data.stok_barang);
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    // Handle error (e.g., display an alert, log to console, etc.)
                }
            });
        });
    });
    });
</script>

