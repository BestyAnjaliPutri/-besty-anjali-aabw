<?= $this->extend($config->viewLayout) ?>
<?= $this->section('title') ?>Reset Password &mdash; SIA-IPB<?= $this->endSection() ?>
<?= $this->section('main') ?>

<div class="card card-primary">
  <div class="card-header"><h4><?= lang('Auth.resetYourPassword') ?></h4></div>

  <div class="card-body">
    <?= view('Myth\Auth\Views\_message_block') ?>

    <p class="text-muted"><?= lang('Auth.enterCodeEmailPassword') ?></p>

    <form method="POST" action="<?= url_to('reset-password') ?>">
      <?= csrf_field() ?>

      <div class="form-group">
        <label for="token"><?= lang('Auth.token') ?></label>
        <input type="text" class="form-control <?= session('errors.token') ? 'is-invalid' : '' ?>" name="token" placeholder="<?= lang('Auth.token') ?>" value="<?= old('token', $token ?? '') ?>" required>
        <div class="invalid-feedback">
          <?= session('errors.token') ?>
        </div>
      </div>

      <div class="form-group">
        <label for="email"><?= lang('Auth.email') ?></label>
        <input type="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" name="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required>
        <div class="invalid-feedback">
          <?= session('errors.email') ?>
        </div>
      </div>

      <div class="form-group">
        <label for="password"><?= lang('Auth.newPassword') ?></label>
        <input type="password" class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" name="password" placeholder="<?= lang('Auth.newPassword') ?>" autocomplete="off" required>
        <div class="invalid-feedback">
          <?= session('errors.password') ?>
        </div>
      </div>

      <div class="form-group">
        <label for="pass_confirm"><?= lang('Auth.newPasswordRepeat') ?></label>
        <input type="password" class="form-control <?= session('errors.pass_confirm') ? 'is-invalid' : '' ?>" name="pass_confirm" placeholder="<?= lang('Auth.newPasswordRepeat') ?>" autocomplete="off" required>
        <div class="invalid-feedback">
          <?= session('errors.pass_confirm') ?>
        </div>
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-lg btn-block">
          <?= lang('Auth.resetPassword') ?>
        </button>
      </div>
    </form>
  </div>
</div>

<?= $this->endSection() ?>
