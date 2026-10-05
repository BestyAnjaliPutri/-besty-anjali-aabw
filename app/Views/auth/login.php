<?= $this->extend($config->viewLayout) ?>
<?= $this->section('title') ?>Login &mdash; SIA-IPB<?= $this->endSection() ?>
<?= $this->section('main') ?>

<div class="card card-primary">
  <div class="card-header"><h4><?= lang('Auth.loginTitle') ?></h4></div>

  <div class="card-body">
    <?= view('Myth\Auth\Views\_message_block') ?>

    <form method="POST" action="<?= url_to('login') ?>" class="needs-validation" novalidate="">
      <?= csrf_field() ?>

<?php if ($config->validFields === ['email']): ?>
      <div class="form-group">
        <label for="login"><?= lang('Auth.email') ?></label>
        <input id="login" type="email" class="form-control <?= session('errors.login') ? 'is-invalid' : '' ?>" name="login" placeholder="<?= lang('Auth.email') ?>" tabindex="1" required autofocus value="<?= old('login') ?>">
        <div class="invalid-feedback">
          <?= session('errors.login') ?? 'Silakan isi email Anda' ?>
        </div>
      </div>
<?php else: ?>
      <div class="form-group">
        <label for="login"><?= lang('Auth.emailOrUsername') ?></label>
        <input id="login" type="text" class="form-control <?= session('errors.login') ? 'is-invalid' : '' ?>" name="login" placeholder="<?= lang('Auth.emailOrUsername') ?>" tabindex="1" required autofocus value="<?= old('login') ?>">
        <div class="invalid-feedback">
          <?= session('errors.login') ?? 'Silakan isi email atau username Anda' ?>
        </div>
      </div>
<?php endif; ?>

      <div class="form-group">
        <div class="d-block">
          <label for="password" class="control-label"><?= lang('Auth.password') ?></label>
<?php if ($config->activeResetter): ?>
          <div class="float-right">
            <a href="<?= url_to('forgot') ?>" class="text-small">
              <?= lang('Auth.forgotYourPassword') ?>
            </a>
          </div>
<?php endif; ?>
        </div>
        <input id="password" type="password" class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" name="password" placeholder="<?= lang('Auth.password') ?>" tabindex="2" required autocomplete="off">
        <div class="invalid-feedback">
          <?= session('errors.password') ?? 'Silakan isi password Anda' ?>
        </div>
      </div>

<?php if ($config->allowRemembering): ?>
      <div class="form-group">
        <div class="custom-control custom-checkbox">
          <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me" <?= old('remember') ? 'checked' : '' ?>>
          <label class="custom-control-label" for="remember-me"><?= lang('Auth.rememberMe') ?></label>
        </div>
      </div>
<?php endif; ?>

      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
          <?= lang('Auth.loginAction') ?>
        </button>
      </div>
    </form>
  </div>
</div>

<?php if ($config->allowRegistration) : ?>
<div class="mt-5 text-muted text-center">
  <?= lang('Auth.needAnAccount') ?> <a href="<?= url_to('register') ?>"><?= lang('Auth.register') ?></a>
</div>
<?php endif; ?>

<?= $this->endSection() ?>
