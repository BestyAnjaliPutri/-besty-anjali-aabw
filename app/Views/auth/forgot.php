<?= $this->extend($config->viewLayout) ?>
<?= $this->section('title') ?>Lupa Password &mdash; SIA-IPB<?= $this->endSection() ?>
<?= $this->section('main') ?>

<div class="card card-primary">
  <div class="card-header"><h4><?= lang('Auth.forgotPassword') ?></h4></div>

  <div class="card-body">
    <?= view('Myth\Auth\Views\_message_block') ?>

    <p class="text-muted"><?= lang('Auth.enterEmailForInstructions') ?></p>

    <form method="POST" action="<?= url_to('forgot') ?>">
      <?= csrf_field() ?>

      <div class="form-group">
        <label for="email"><?= lang('Auth.emailAddress') ?></label>
        <input id="email" type="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" name="email" placeholder="<?= lang('Auth.email') ?>" autofocus required>
        <div class="invalid-feedback">
          <?= session('errors.email') ?>
        </div>
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-lg btn-block">
          <?= lang('Auth.sendInstructions') ?>
        </button>
      </div>
    </form>
  </div>
</div>

<div class="mt-5 text-muted text-center">
  Ingat akun Anda? <a href="<?= url_to('login') ?>"><?= lang('Auth.signIn') ?></a>
</div>

<?= $this->endSection() ?>
