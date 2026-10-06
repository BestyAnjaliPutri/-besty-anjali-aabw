<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title><?= $this->renderSection('title') ?? 'SIA-IPB &mdash; Akuntansi' ?></title>

  <!-- General CSS Files (CDN for Vercel compatibility) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= base_url('template/assets/css/style.css') ?>">
  <link rel="stylesheet" href="<?= base_url('template/assets/css/components.css') ?>">
  <link rel="stylesheet" href="<?= base_url('template/assets/css/custom.css') ?>">
  <!-- Cute Pink Pastel Sakura Theme -->
  <link rel="stylesheet" href="<?= base_url('template/assets/css/cute-theme.css') ?>">
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="<?= base_url('template/assets/img/stisla-fill.svg') ?>" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>

            <?= $this->renderSection('main') ?>

            <div class="simple-footer">
              Copyright &copy; SIA-IPB 2026
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts (CDN for Vercel compatibility) -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="<?= base_url('template/assets/js/stisla.js') ?>"></script>

  <!-- Template JS File -->
  <script src="<?= base_url('template/assets/js/scripts.js') ?>"></script>
  <script src="<?= base_url('template/assets/js/custom.js') ?>"></script>
  <!-- Cute Pink Pastel Sakura Theme JS -->
  <script src="<?= base_url('template/assets/js/cute-theme.js') ?>"></script>
</body>
</html>
