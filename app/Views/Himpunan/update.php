<?= view("template/header") ?>
<?= view("template/navigasi") ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-2">
          </div>
          <div class="col-sm-10">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= site_url() ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?= site_url("himpunan") ?>">Kas Himpunan</a></li>
              <li class="breadcrumb-item active"><?= $title ?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-md-6">
          <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Update Kas Himpunan</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?= form_open(site_url("himpunan/update")) ?>
                <input type="hidden" name="id" value="<?= $input['id'] ?>">
                <div class="card-body">
                  <div class="form-group">
                    <label for="tipe">Tipe</label>
                      <select 
                        name="tipe" 
                        required="true" 
                        class="custom-select" 
                        id="tipe" >
                        <option value="Pemasukan" <?= (@$input['tipe']!='Pemasukan'?:'selected') ?>>Pemasukan</option>
                        <option value="Pengeluaran" <?= (@$input['tipe']!='Pengeluaran'?:'selected') ?>>Pengeluaran</option>
                      </select>
                  </div>
                  <div class="form-group">
                    <label for="nama">Nama</label>
                    <input 
                      type="text" 
                      name="nama" 
                      id="nama" 
                      class="form-control <?= (@$errors['nama']?'is-invalid':'') ?>"
                      placeholder="Kas Bulan September" 
                      value="<?= @$input['nama'] ?>" 
                      required="true" />
                    <div class="invalid-feedback">
                      <?= @$errors['nama'] ?>
                    </div>
                  </div>
                  <?= @date("c", strtotime($input['waktu'])) ?>
                  <div class="form-group">
                    <label for="waktu">Tanggal</label>
                    <input 
                      type="datetime-local" 
                      name="waktu" 
                      id="waktu" 
                      class="form-control <?= (@$errors['waktu']?'is-invalid':'') ?>"
                      placeholder="" 
                      value="<?= @date("Y-m-d\TH:i:s", strtotime($input['waktu'])) ?>" 
                      required="true" />
                    <div class="invalid-feedback">
                      <?= @$errors['waktu'] ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="jumlah">Jumlah</label>
                    <input 
                      type="text" 
                      name="jumlah" 
                      id="jumlah" 
                      class="form-control number <?= (@$errors['jumlah']?'is-invalid':'') ?>"
                      placeholder="9999999999" 
                      value="<?= @number_format($input['jumlah']) ?>" 
                      required="true" />
                    <div class="invalid-feedback">
                      <?= @$errors['jumlah'] ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="total">Total</label>
                    <input 
                      type="text" 
                      name="total" 
                      id="total" 
                      class="form-control number <?= (@$errors['total']?'is-invalid':'') ?>"
                      placeholder="9999999999" 
                      value="<?= @number_format($input['total']) ?>" 
                      required="true" />
                    <div class="invalid-feedback">
                      <?= @$errors['total'] ?>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <a href="<?= site_url("himpunan") ?>" class="btn btn-danger">Back</a>
                </div>
              <?= form_close() ?>
            </div>
          </div>
        </div>
      
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

<?= view("template/footer") ?>

<!-- bs-custom-file-input -->
<script src="<?= base_url() ?>/assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

<script>
$(document).on('keyup', '.number', function() {
    var x = $(this).val();
    $(this).val(x.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
});



</script>