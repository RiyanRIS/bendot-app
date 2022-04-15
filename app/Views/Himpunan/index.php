<?= view("template/header") ?>
<?= view("template/navigasi") ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-2">
            <a href="<?= site_url("himpunan/add") ?>" class="btn btn-block btn-primary"><i class="fa fa-plus"></i> Insert</a>
          </div>
          <div class="col-sm-10">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= site_url() ?>">Home</a></li>
              <li class="breadcrumb-item active"><?= $title ?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <table id="datatable" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Tipe</th>
                    <th>Nama</th>
                    <th>Waktu</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
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
                    <td><span class="badge <?= $himpunan['tipe'] == "Pemasukan" ? "bg-success" : "bg-danger" ?>"><?= $himpunan['tipe'] ?></span></td>
                    <td><?= $himpunan['nama'] ?></td>
                    <td><?= date("Y-m-d H:i", strtotime($himpunan['waktu'])) ?></td>
                    <td><img src="<?= $himpunan['tipe'] == "Pemasukan" ? base_url("assets/img/plus.png") : base_url("assets/img/min.png") ?>" width="16px" alt="" />  Rp <?= number_format($himpunan['jumlah'], 0, ",", ".") ?>,-</td>
                    <td>Rp <?= number_format($saldo, 0, ".", ".") ?>,-</td>

                    <td>
                      <a href="<?= site_url('himpunan/update/'.$himpunan['id']) ?>" title="Ubah Data" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Update</a>
                      <a onclick="confirmation(event)" href="<?= site_url('himpunan/delete/'.$himpunan['id']) ?>" title="Hapus Data" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</a>  
                    </td>
                  </tr>
                  <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

  <div class="modal fade" id="modal-sm">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Konfirmasi Hapus Data?</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary"><i class="fa fa-trash"></i> Hapus</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

<?= view("template/footer") ?>

<script>
$(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false, "searching": false,
      // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      // "buttons": ["excel", "pdf"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });

</script>