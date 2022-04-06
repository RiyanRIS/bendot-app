<?= view("template/header") ?>
<?= view("template/navigasi") ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-2">
            <div class="form-group">
              <select class="custom-select" id="year">
                <option value="2021" 
                  <?= $year == "2021" ? "selected='true'" : "" ?>>2021</option>
                <option value="2022" 
                  <?= $year == "2022" ? "selected='true'" : "" ?>>2022</option>
              </select>
            </div>
          </div>
          <div class="col-sm-2">
            <div class="form-group">
              <select class="custom-select" id="month">
                <option value="1" <?= $month == "1" ? "selected='true'" : "" ?>>Januari</option>
                <option value="2" <?= $month == "2" ? "selected='true'" : "" ?>>Februari</option>
                <option value="3" <?= $month == "3" ? "selected='true'" : "" ?>>Maret</option>
                <option value="4" <?= $month == "4" ? "selected='true'" : "" ?>>April</option>
                <option value="5" <?= $month == "5" ? "selected='true'" : "" ?>>Mei</option>
                <option value="6" <?= $month == "6" ? "selected='true'" : "" ?>>Juni</option>
                <option value="7" <?= $month == "7" ? "selected='true'" : "" ?>>Juli</option>
                <option value="8" <?= $month == "8" ? "selected='true'" : "" ?>>Agustus</option>
                <option value="9" <?= $month == "9" ? "selected='true'" : "" ?>>September</option>
                <option value="10" <?= $month == "10" ? "selected='true'" : "" ?>>Oktober</option>
                <option value="11" <?= $month == "11" ? "selected='true'" : "" ?>>November</option>
                <option value="12" <?= $month == "12" ? "selected='true'" : "" ?>>Desember</option>
              </select>
            </div>
          </div>
          <div class="col-sm-2">
            <div class="form-group">
              <button type="button" onclick="refress(event)" class="btn btn-primary">Filter</button>
            </div>
          </div>
          <div class="col-sm-6">
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
                    <th>Nama</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                      $no = 1;
                      foreach($anggotas as $anggota){
                        $stt = false;
                        foreach($bulanans as $bulanan){
                          if($anggota['id'] == $bulanan['id_anggota'] 
                                && $bulanan['year'] == $year 
                                && $bulanan['month'] == $month){
                            $stt = true;
                          }
                        }
                    ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $anggota['nama'] ?></td>
                    <td><span class="badge <?= $stt ? "bg-success" : "bg-danger" ?>"><?= $stt ? "Sudah" : "Belum" ?> Bayar</span></td>
                    <td>
                      <?php
                      if(!$stt){ ?>
                        <a onclick="confirmation(event)" href="<?= site_url('bulanan/bayar/'.$anggota['id']."/".$year.'/'.$month) ?>" title="Konfirmasi pembayaran?" class="btn btn-danger btn-sm"><i class="fas fa-dollar-sign"></i> Bayar</a>
                      <?php } else { ?>
                        <button type="button" disabled="true" class="btn btn-danger btn-sm"><i class="fas fa-dollar-sign"></i> Bayar</button>
                      <?php } ?>
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

<?= view("template/footer") ?>

<script>
function refress(ev){
  ev.preventDefault();
  let month = $('#month').val()
  let year = $('#year').val()
  let urlToRedirect = "<?= site_url("bulanan?month=") ?>" + month + "&year=" + year
  // console.log(urlToRedirect)
  window.location.href=urlToRedirect
}
</script>