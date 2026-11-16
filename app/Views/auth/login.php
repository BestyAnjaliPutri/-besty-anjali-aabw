<?= $this->extend($config->viewLayout) ?>
<?= $this->section('title') ?>Login &mdash; SIA AKN 🌸<?= $this->endSection() ?>
<?= $this->section('card_header') ?><i class="fas fa-sign-in-alt"></i> Masuk ke Sistem 💖<?= $this->endSection() ?>
<?= $this->section('main') ?>

<?= view('Myth\Auth\Views\_message_block') ?>

<form method="POST" action="<?= url_to('login') ?>" class="needs-validation" novalidate="">
  <?= csrf_field() ?>

<?php if ($config->validFields === ['email']): ?>
  <div class="form-group">
    <label for="login"><i class="fas fa-envelope mr-1" style="color: #ff758f; font-size: 12px;"></i> <?= lang('Auth.email') ?></label>
    <input id="login" type="email" class="form-control <?= session('errors.login') ? 'is-invalid' : '' ?>" name="login" placeholder="Masukkan email anda..." tabindex="1" required autofocus value="<?= old('login') ?>">
    <div class="invalid-feedback">
      <?= session('errors.login') ?? 'Silakan isi email Anda' ?>
    </div>
  </div>
<?php else: ?>
  <div class="form-group">
    <label for="login"><i class="fas fa-user mr-1" style="color: #ff758f; font-size: 12px;"></i> <?= lang('Auth.emailOrUsername') ?></label>
    <input id="login" type="text" class="form-control <?= session('errors.login') ? 'is-invalid' : '' ?>" name="login" placeholder="Masukkan email atau username..." tabindex="1" required autofocus value="<?= old('login') ?>">
    <div class="invalid-feedback">
      <?= session('errors.login') ?? 'Silakan isi email atau username Anda' ?>
    </div>
  </div>
<?php endif; ?>

  <div class="form-group">
    <div class="d-block">
      <label for="password" class="control-label"><i class="fas fa-lock mr-1" style="color: #ff758f; font-size: 12px;"></i> <?= lang('Auth.password') ?></label>
<?php if ($config->activeResetter): ?>
      <div class="float-right">
        <a href="<?= url_to('forgot') ?>" class="text-small">
          <?= lang('Auth.forgotYourPassword') ?>
        </a>
      </div>
<?php endif; ?>
    </div>
    <input id="password" type="password" class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" name="password" placeholder="Masukkan password..." tabindex="2" required autocomplete="off">
    <div class="invalid-feedback">
      <?= session('errors.password') ?? 'Silakan isi password Anda' ?>
    </div>
  </div>

<?php if ($config->allowRemembering): ?>
  <div class="form-group">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me" <?= old('remember') ? 'checked' : '' ?>>
      <label class="custom-control-label" for="remember-me">🌸 <?= lang('Auth.rememberMe') ?></label>
    </div>
  </div>
<?php endif; ?>

  <div class="form-group mt-4">
    <button type="submit" class="btn btn-primary btn-lg btn-block btn-login-sakura" tabindex="4">
      <i class="fas fa-sign-in-alt mr-2"></i> <?= lang('Auth.loginAction') ?>
    </button>
  </div>
</form>

<?php if ($config->allowRegistration) : ?>
<div class="text-center mt-3">
  <span class="register-link" style="font-size: 13.5px; font-weight: 700; color: #8c737c;">
    <?= lang('Auth.needAnAccount') ?> <a href="<?= url_to('register') ?>" style="color: #ff4d6d; font-weight: 800;"><?= lang('Auth.register') ?></a>
  </span>
</div>
<?php endif; ?>

<?= $this->endSection() ?>
