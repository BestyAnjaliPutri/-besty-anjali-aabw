<?= $this->extend($config->viewLayout) ?>
<?= $this->section('title') ?>Reset Password &mdash; SIA AKN 🌸<?= $this->endSection() ?>
<?= $this->section('card_header') ?><i class="fas fa-redo"></i> Reset Password 🔑<?= $this->endSection() ?>
<?= $this->section('main') ?>

<?= view('Myth\Auth\Views\_message_block') ?>

<p style="font-size: 13px; font-weight: 600; color: #8c737c; margin-bottom: 18px;">
  <?= lang('Auth.enterCodeEmailPassword') ?>
</p>

<form method="POST" action="<?= url_to('reset-password') ?>">
  <?= csrf_field() ?>

  <div class="form-group">
    <label for="token"><i class="fas fa-hashtag mr-1" style="color: #ff758f; font-size: 12px;"></i> <?= lang('Auth.token') ?></label>
    <input type="text" class="form-control <?= session('errors.token') ? 'is-invalid' : '' ?>" name="token" placeholder="Masukkan token..." value="<?= old('token', $token ?? '') ?>" required>
    <div class="invalid-feedback">
      <?= session('errors.token') ?>
    </div>
  </div>

  <div class="form-group">
    <label for="email"><i class="fas fa-envelope mr-1" style="color: #ff758f; font-size: 12px;"></i> <?= lang('Auth.email') ?></label>
    <input type="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" name="email" placeholder="Masukkan email..." value="<?= old('email') ?>" required>
    <div class="invalid-feedback">
      <?= session('errors.email') ?>
    </div>
  </div>

  <div class="form-group">
    <label for="password"><i class="fas fa-lock mr-1" style="color: #ff758f; font-size: 12px;"></i> <?= lang('Auth.newPassword') ?></label>
    <input type="password" class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" name="password" placeholder="Password baru..." autocomplete="off" required>
    <div class="invalid-feedback">
      <?= session('errors.password') ?>
    </div>
  </div>

  <div class="form-group">
    <label for="pass_confirm"><i class="fas fa-lock mr-1" style="color: #ff758f; font-size: 12px;"></i> <?= lang('Auth.newPasswordRepeat') ?></label>
    <input type="password" class="form-control <?= session('errors.pass_confirm') ? 'is-invalid' : '' ?>" name="pass_confirm" placeholder="Ulangi password baru..." autocomplete="off" required>
    <div class="invalid-feedback">
      <?= session('errors.pass_confirm') ?>
    </div>
  </div>

  <div class="form-group mt-4">
    <button type="submit" class="btn btn-primary btn-lg btn-block btn-login-sakura">
      <i class="fas fa-sync-alt mr-2"></i> <?= lang('Auth.resetPassword') ?>
    </button>
  </div>
</form>

<?= $this->endSection() ?>
