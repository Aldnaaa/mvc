</tbody>


</table>
</div>
</div>

<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Barang Baru</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="http://localhost/ta-oop/public/DataBarang/tambahBarang" method="post" enctype="multipart/form-data" >
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
                            <?php foreach ($data as $option): ?>
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
</main>
