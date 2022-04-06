<?= view("template/header") ?>
<?= view("template/navigasi") ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-2">
            <a href="<?= site_url("anggota/add") ?>" class="btn btn-block btn-primary"><i class="fa fa-plus"></i> Insert</a>
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
                    <th>Nama</th>
                    <th>Role</th>
                    <th>ID Telegram</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                      foreach($anggotas as $anggota){
                    ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $anggota['nama'] ?></td>
                    <td><?= $anggota['role'] ?></td>
                    <td><?= $anggota['id_tele'] ?></td>
                    <td><?= $anggota['username'] ?></td>
                    <td>********</td>
                    <td>
                      <a href="<?= site_url('anggota/update/'.$anggota['id']) ?>" title="Ubah Data" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Update</a>
                      <a onclick="confirmation(event)" href="<?= site_url('anggota/delete/'.$anggota['id']) ?>" title="Hapus Data" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</a>
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

</script>