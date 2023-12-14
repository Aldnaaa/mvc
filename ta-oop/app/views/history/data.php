            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filter1']) && $data != $history->getHistory()) {
                $no = 1;
                $jumlahBeli = 0;
                $jumlahJual = 0;
                foreach ($data as $item) {
                  echo "<tr>";
                  echo "<td>" . $no++ . "</td>";
                  echo "<td>". $item['tanggal_transaksi'] ."</td>";
                  echo "<td>" . $item['nama_barang'] . "</td>";
                  echo "<td>Rp. ". number_format($item['harga_beli']) ."</td>";
                  echo "<td>Rp. ". number_format($item['harga_jual']) ."</td>";
                  echo "<td>". $item['total_qty'] . "</td>";
                  echo "<td><a href='admin/fungsi/detailHistory.php?action=detail&id=" . $item['id_transaksi'] . "' class='edit'>Detail</a></td>";
                  echo "</tr>";
                  $jumlahBeli += $item['harga_beli'];
                  $jumlahJual += $item['harga_jual'];
                }
                echo "<tr>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td>Total Penjualan : </td>";
                echo "<td>Rp. ".number_format($jumlahBeli)."</td>";
                echo "<td>Rp. ".number_format($jumlahJual)."</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td>Total Keuntungan : </td>";
                echo "<td>Rp. ".number_format($jumlahJual - $jumlahBeli)."</td>";
                echo "<td></td>";
                echo "</tr>";
              } else {
                $no = 1;
                foreach ($data as $item) {
                  echo "<tr>";
                  echo "<td>" . $no++ . "</td>";
                  echo "<td>". $item['tanggal_transaksi'] ."</td>";
                  echo "<td>" . $item['nama_barang'] . "</td>";
                  echo "<td>Rp. " . number_format($item['total_beli']) . "</td>";
                  echo "<td>Rp. " . number_format($item['total_transaksi']) . "</td>";
                  echo "<td>" . $item['total_qty'] . "</td>";
                  echo "<td><a href='admin/fungsi/detailHistory.php?action=detail&id=" . $item['id_transaksi'] . "' class='edit'>Detail</a></td>";
                  echo "</tr>";
                }
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </main>