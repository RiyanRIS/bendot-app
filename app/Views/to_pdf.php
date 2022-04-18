<style type="text/css">
            table
            {
                width: 100%;
                font-size: 13px;
                border: none;
                border-collapse:collapse;
            }

            td, th, tr
            {
                border:1px solid black;
                border-collapse:collapse;
            }
        </style>
        <h1>List himpunan</h1>
<table>
    <tr>
      <th>No</th>
      <th>Tipe</th>
      <th>Nama</th>
      <th>Waktu</th>
      <th>Jumlah</th>
      <th>Total</th>
    </tr>
  <?php
    $no = 1; $saldo = 0;
      foreach($himpunans as $himpunan){
        if($himpunan['tipe'] == "Pemasukan"){
          $saldo += $himpunan['jumlah'];
        } else {
          $saldo -= $himpunan['jumlah'];
        }
    ?>
  <tr>
    <td><?= $no++ ?></td>
    <td><?= $himpunan['tipe'] ?></td>
    <td><?= $himpunan['nama'] ?></td>
    <td><?= date("d F Y H:i", strtotime($himpunan['waktu'])) ?></td>
    <td>Rp <?= number_format($himpunan['jumlah'], 0, ",", ".") ?>,-</td>
    <td>Rp <?= number_format($saldo, 0, ".", ".") ?>,-</td>
  </tr>
  <?php } ?>
</table>