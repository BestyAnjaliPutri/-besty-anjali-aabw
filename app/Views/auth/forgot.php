<?= $this->extend($config->viewLayout) ?>
<?= $this->section('title') ?>Lupa Password &mdash; SIA AKN 🌸<?= $this->endSection() ?>
<?= $this->section('card_header') ?><i class="fas fa-key"></i> Lupa Password 💌<?= $this->endSection() ?>
<?= $this->section('main') ?>

<?= view('Myth\Auth\Views\_message_block') ?>

<p style="font-size: 13px; font-weight: 600; color: #8c737c; margin-bottom: 18px;">
  <?= lang('Auth.enterEmailForInstructions') ?>
</p>

<form method="POST" action="<?= url_to('forgot') ?>">
  <?= csrf_field() ?>

  <div class="form-group">
    <label for="email"><i class="fas fa-envelope mr-1" style="color: #ff758f; font-size: 12px;"></i> <?= lang('Auth.emailAddress') ?></label>
    <input id="email" type="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" name="email" placeholder="Masukkan email anda..." autofocus required>
    <div class="invalid-feedback">
      <?= session('errors.email') ?>
    </div>
  </div>

  <div class="form-group mt-4">
    <button type="submit" class="btn btn-primary btn-lg btn-block btn-login-sakura">
      <i class="fas fa-paper-plane mr-2"></i> <?= lang('Auth.sendInstructions') ?>
    </button>
  </div>
</form>

<div class="text-center mt-3">
  <span style="font-size: 13.5px; font-weight: 700; color: #8c737c;">
    Ingat akun Anda? <a href="<?= url_to('login') ?>" style="color: #ff4d6d; font-weight: 800;"><?= lang('Auth.signIn') ?></a>
  </span>
</div>

<?= $this->endSection() ?>
