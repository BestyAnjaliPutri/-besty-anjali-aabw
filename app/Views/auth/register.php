<?= $this->extend($config->viewLayout) ?>
<?= $this->section('title') ?>Register &mdash; SIA AKN 🌸<?= $this->endSection() ?>
<?= $this->section('card_header') ?><i class="fas fa-user-plus"></i> Daftar Akun Baru 🌸<?= $this->endSection() ?>
<?= $this->section('main') ?>

<?= view('Myth\Auth\Views\_message_block') ?>

<form method="POST" action="<?= url_to('register') ?>" class="needs-validation" novalidate="">
  <?= csrf_field() ?>

  <div class="form-group">
    <label for="email"><i class="fas fa-envelope mr-1" style="color: #ff758f; font-size: 12px;"></i> <?= lang('Auth.email') ?></label>
    <input id="email" type="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" name="email" placeholder="Masukkan email anda..." value="<?= old('email') ?>" required autofocus>
    <div class="invalid-feedback">
      <?= session('errors.email') ?? 'Silakan isi alamat email Anda' ?>
    </div>
  </div>

  <div class="form-group">
    <label for="username"><i class="fas fa-user mr-1" style="color: #ff758f; font-size: 12px;"></i> <?= lang('Auth.username') ?></label>
    <input id="username" type="text" class="form-control <?= session('errors.username') ? 'is-invalid' : '' ?>" name="username" placeholder="Masukkan username anda..." value="<?= old('username') ?>" required>
    <div class="invalid-feedback">
      <?= session('errors.username') ?? 'Silakan isi username Anda' ?>
    </div>
  </div>

  <div class="form-group">
    <label for="password"><i class="fas fa-lock mr-1" style="color: #ff758f; font-size: 12px;"></i> <?= lang('Auth.password') ?></label>
    <input id="password" type="password" class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" name="password" placeholder="Masukkan password..." autocomplete="off" required>
    <div class="invalid-feedback">
      <?= session('errors.password') ?? 'Silakan isi password' ?>
    </div>
  </div>

  <div class="form-group">
    <label for="pass_confirm"><i class="fas fa-lock mr-1" style="color: #ff758f; font-size: 12px;"></i> <?= lang('Auth.repeatPassword') ?></label>
    <input id="pass_confirm" type="password" class="form-control <?= session('errors.pass_confirm') ? 'is-invalid' : '' ?>" name="pass_confirm" placeholder="Ulangi password..." autocomplete="off" required>
    <div class="invalid-feedback">
      <?= session('errors.pass_confirm') ?? 'Silakan ulangi password' ?>
    </div>
  </div>

  <div class="form-group mt-4">
    <button type="submit" class="btn btn-primary btn-lg btn-block btn-login-sakura">
      <i class="fas fa-user-plus mr-2"></i> <?= lang('Auth.register') ?>
    </button>
  </div>
</form>

<div class="text-center mt-3">
  <span style="font-size: 13.5px; font-weight: 700; color: #8c737c;">
    <?= lang('Auth.alreadyRegistered') ?> <a href="<?= url_to('login') ?>" style="color: #ff4d6d; font-weight: 800;"><?= lang('Auth.signIn') ?></a>
  </span>
</div>

<?= $this->endSection() ?>
