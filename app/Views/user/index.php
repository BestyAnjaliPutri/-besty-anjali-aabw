<?= $this->extend('layout/backend') ?>

<?= $this->section("content") ?>
<title>SIA-IPB &mdash; Management User</title>
<?= $this->endSection() ?>

<?= $this->section("content") ?>

<section class="section">
  <div class="section-header">
    <h1>Management User</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?= site_url('/') ?>">Dashboard</a></div>
      <div class="breadcrumb-item">Management User</div>
    </div>
  </div>

  <?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible show fade">
      <div class="alert-body">
        <button class="close" data-dismiss="alert"> &times; </button>
        <?= session()->getFlashdata('success') ?>
      </div>
    </div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible show fade">
      <div class="alert-body">
        <button class="close" data-dismiss="alert"> &times; </button>
        <?= session()->getFlashdata('error') ?>
      </div>
    </div>
  <?php endif; ?>

  <div class="section-body">
    <div class="card">
      <div class="card-header">
        <h4>Daftar Pengguna</h4>
        <div class="card-header-action">
          <a href="<?= site_url('register') ?>" class="btn btn-primary"><i class="fas fa-user-plus"></i> Tambah User</a>
        </div>
      </div>
      <div class="card-body p-4">
        <div class="table-responsive">
          <table class="table table-striped table-md" id="myTable">
            <thead>
              <tr>
                <th style="width: 5%">No</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role / Grup</th>
                <th>Status</th>
                <th class="text-center" style="width: 25%">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($users as $key => $u) : ?>
              <tr>
                <td><?= $key + 1 ?></td>
                <td><strong><?= esc($u->username) ?></strong></td>
                <td><?= esc($u->email) ?></td>
                <td>
                  <?php if (strtolower($u->group_name ?? '') === 'admin') : ?>
                    <span class="badge badge-primary"><i class="fas fa-user-shield"></i> <?= esc(ucfirst($u->group_name)) ?></span>
                  <?php else : ?>
                    <span class="badge badge-info"><i class="fas fa-user"></i> <?= esc(ucfirst($u->group_name ?? 'User')) ?></span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($u->active == 1) : ?>
                    <span class="badge badge-success">Aktif</span>
                  <?php else : ?>
                    <span class="badge badge-danger">Nonaktif</span>
                  <?php endif; ?>
                </td>
                <td class="text-center">
                  <!-- Button Trigger Modal Ganti Role -->
                  <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalRole-<?= $u->userid ?>">
                    <i class="fas fa-user-tag"></i> Role
                  </button>

                  <!-- Toggle Status Button -->
                  <a href="<?= site_url('user/toggleStatus/' . $u->userid) ?>" class="btn btn-<?= $u->active == 1 ? 'secondary' : 'success' ?> btn-sm" title="<?= $u->active == 1 ? 'Nonaktifkan Akun' : 'Aktifkan Akun' ?>">
                    <i class="fas <?= $u->active == 1 ? 'fa-ban' : 'fa-check' ?>"></i> <?= $u->active == 1 ? 'Nonaktifkan' : 'Aktifkan' ?>
                  </a>

                  <!-- Delete Form -->
                  <form action="<?= site_url('user/delete/' . $u->userid) ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna <?= esc($u->username) ?>?');">
                    <?= csrf_field() ?>
                    <button class="btn btn-danger btn-sm" type="submit">
                      <i class="fas fa-trash"></i> Hapus
                    </button>
                  </form>
                </td>
              </tr>

              <!-- Modal Ganti Role -->
              <div class="modal fade" id="modalRole-<?= $u->userid ?>" tabindex="-1" role="dialog" aria-labelledby="modalRoleLabel-<?= $u->userid ?>" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <form action="<?= site_url('user/changeRole/' . $u->userid) ?>" method="post">
                      <?= csrf_field() ?>
                      <div class="modal-header">
                        <h5 class="modal-title" id="modalRoleLabel-<?= $u->userid ?>">Ubah Role: <?= esc($u->username) ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="form-group">
                          <label>Pilih Role / Grup</label>
                          <select name="group_id" class="form-control" required>
                            <?php foreach ($groups as $g) : ?>
                              <option value="<?= $g->id ?>" <?= ($u->group_id == $g->id) ? 'selected' : '' ?>>
                                <?= ucfirst($g->name) ?> - <?= esc($g->description) ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                      <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<?= $this->endSection() ?>
