<?= $this->extend($config->viewLayout) ?>
<?= $this->section('title') ?>Register &mdash; SIA-IPB<?= $this->endSection() ?>
<?= $this->section('main') ?>

<div class="card card-primary">
  <div class="card-header"><h4><?= lang('Auth.register') ?></h4></div>

  <div class="card-body">
    <?= view('Myth\Auth\Views\_message_block') ?>

    <form method="POST" action="<?= url_to('register') ?>" class="needs-validation" novalidate="">
      <?= csrf_field() ?>

      <div class="form-group">
        <label for="email"><?= lang('Auth.email') ?></label>
        <input id="email" type="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" name="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required autofocus>
        <div class="invalid-feedback">
          <?= session('errors.email') ?? 'Silakan isi alamat email Anda' ?>
        </div>
      </div>

      <div class="form-group">
        <label for="username"><?= lang('Auth.username') ?></label>
        <input id="username" type="text" class="form-control <?= session('errors.username') ? 'is-invalid' : '' ?>" name="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>" required>
        <div class="invalid-feedback">
          <?= session('errors.username') ?? 'Silakan isi username Anda' ?>
        </div>
      </div>

      <div class="form-group">
        <label for="password"><?= lang('Auth.password') ?></label>
        <input id="password" type="password" class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" name="password" placeholder="<?= lang('Auth.password') ?>" autocomplete="off" required>
        <div class="invalid-feedback">
          <?= session('errors.password') ?? 'Silakan isi password' ?>
        </div>
      </div>

      <div class="form-group">
        <label for="pass_confirm"><?= lang('Auth.repeatPassword') ?></label>
        <input id="pass_confirm" type="password" class="form-control <?= session('errors.pass_confirm') ? 'is-invalid' : '' ?>" name="pass_confirm" placeholder="<?= lang('Auth.repeatPassword') ?>" autocomplete="off" required>
        <div class="invalid-feedback">
          <?= session('errors.pass_confirm') ?? 'Silakan ulangi password' ?>
        </div>
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-lg btn-block">
          <?= lang('Auth.register') ?>
        </button>
      </div>
    </form>
  </div>
</div>

<div class="mt-5 text-muted text-center">
  <?= lang('Auth.alreadyRegistered') ?> <a href="<?= url_to('login') ?>"><?= lang('Auth.signIn') ?></a>
</div>

<?= $this->endSection() ?>
