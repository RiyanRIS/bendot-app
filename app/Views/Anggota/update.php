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
              <li class="breadcrumb-item"><a href="<?= site_url("anggota") ?>">Anggota</a></li>
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
                <h3 class="card-title">Update Anggota</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?= form_open(site_url("anggota/update")) ?>
                <input type="hidden" name="id" value="<?= $input['id'] ?>">
                <div class="card-body">
                  <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input 
                      type="text" 
                      name="nama" 
                      id="nama" 
                      class="form-control <?= (@$errors['nama']?'is-invalid':'') ?>"
                      placeholder="Joko Widodo" 
                      value="<?= @$input['nama'] ?>" 
                      required="true"
                      autofocus="true" />
                    <div class="invalid-feedback">
                      <?= @$errors['nama'] ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="role">Role</label>
                      <select 
                        name="role" 
                        required="true" 
                        class="custom-select" 
                        id="role" >
                        <option value="Anggota" <?= (@$input['role']!='Anggota'?:'selected') ?>>Anggota</option>
                        <option value="Bendahara" <?= (@$input['role']!='Bendahara'?:'selected') ?>>Bendahara</option>
                        <option value="Admin" <?= (@$input['role']!='Admin'?:'selected') ?>>Admin</option>
                      </select>
                  </div>
                  <div class="form-group">
                    <label for="id_tele">ID Telegram</label>
                    <input 
                      type="text" 
                      name="id_tele" 
                      id="id_tele" 
                      class="form-control <?= (@$errors['id_tele']?'is-invalid':'') ?>"
                      placeholder="6621378" 
                      value="<?= @$input['id_tele'] ?>" 
                      required="true" />
                    <div class="invalid-feedback">
                      <?= @$errors['id_tele'] ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="username">Username</label>
                    <input 
                      type="text" 
                      name="username" 
                      id="username" 
                      class="form-control <?= (@$errors['username']?'is-invalid':'') ?>"
                      placeholder="Jokowi3^" 
                      value="<?= @$input['username'] ?>" 
                      required="true" />
                    <div class="invalid-feedback">
                      <?= @$errors['username'] ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group">
                      <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        class="input form-control <?= (@$errors['password']?'is-invalid':'') ?>"
                        placeholder="Isi jika merubah password" />
                      <div class="input-group-append">
                        <span class="input-group-text" onclick="password_show_hide();">
                          <i class="fas fa-eye" id="show_eye"></i>
                          <i class="fas fa-eye-slash d-none" id="hide_eye"></i>
                        </span>
                      </div>
                    </div>
                    <div class="invalid-feedback">
                      <?= @$errors['password'] ?>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <a href="<?= site_url("anggota") ?>" class="btn btn-danger">Back</a>
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
$(function () {
    
  });

</script>