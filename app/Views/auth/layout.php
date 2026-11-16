<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title><?= $this->renderSection('title') ?? 'SIA-IPB &mdash; Akuntansi' ?></title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700;800&family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
  <!-- General CSS Files (CDN for Vercel compatibility) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= base_url('template/assets/css/style.css') ?>">
  <link rel="stylesheet" href="<?= base_url('template/assets/css/components.css') ?>">
  <!-- Cute Pink Sakura Favicon -->
  <link rel="icon" type="image/svg+xml" href="<?= base_url('favicon.svg') ?>">
  <link rel="alternate icon" type="image/png" href="<?= base_url('favicon.png') ?>">
  <link rel="shortcut icon" href="<?= base_url('favicon.ico') ?>">

  <style>
    :root {
      --login-font: 'Quicksand', 'Nunito', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    * { box-sizing: border-box; }

    body {
      margin: 0;
      padding: 0;
      min-height: 100vh;
      font-family: var(--login-font);
      background: linear-gradient(135deg, #fff5f8 0%, #ffe5ec 30%, #ffccd5 60%, #fff0f3 100%);
      overflow-x: hidden;
      position: relative;
    }

    /* Animated floating sakura petals background */
    body::before {
      content: '';
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      background-image:
        radial-gradient(circle at 15% 20%, rgba(255, 117, 143, 0.08) 0%, transparent 50%),
        radial-gradient(circle at 85% 30%, rgba(255, 77, 109, 0.06) 0%, transparent 50%),
        radial-gradient(circle at 50% 80%, rgba(255, 179, 193, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 20% 70%, rgba(201, 24, 74, 0.04) 0%, transparent 40%),
        radial-gradient(circle at 80% 85%, rgba(255, 143, 163, 0.07) 0%, transparent 45%);
      pointer-events: none;
      z-index: 0;
    }

    /* Floating decorative blobs */
    .deco-blob {
      position: fixed;
      border-radius: 50%;
      opacity: 0.12;
      pointer-events: none;
      z-index: 0;
      animation: blobFloat 8s ease-in-out infinite alternate;
    }
    .deco-blob-1 {
      width: 300px; height: 300px;
      background: radial-gradient(circle, #ff758f, #ff8fa3);
      top: -80px; left: -80px;
      animation-delay: 0s;
    }
    .deco-blob-2 {
      width: 200px; height: 200px;
      background: radial-gradient(circle, #ffb3c1, #ffccd5);
      top: 50%; right: -60px;
      animation-delay: 2s;
      animation-duration: 10s;
    }
    .deco-blob-3 {
      width: 250px; height: 250px;
      background: radial-gradient(circle, #ff4d6d, #ff758f);
      bottom: -100px; left: 30%;
      animation-delay: 4s;
      animation-duration: 12s;
    }
    .deco-blob-4 {
      width: 160px; height: 160px;
      background: radial-gradient(circle, #ffccd5, #ffe5ec);
      top: 20%; left: 60%;
      animation-delay: 1s;
      animation-duration: 9s;
    }

    @keyframes blobFloat {
      0% { transform: translate(0, 0) scale(1); }
      50% { transform: translate(15px, -20px) scale(1.05); }
      100% { transform: translate(-10px, 10px) scale(0.95); }
    }

    /* Floating sakura emojis - removed, replaced by canvas */
    #sakura-login-canvas {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      pointer-events: none;
      z-index: 0;
    }

    /* Main wrapper */
    .login-wrapper {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 30px 16px;
      position: relative;
      z-index: 1;
    }

    /* Login container */
    .login-container {
      width: 100%;
      max-width: 440px;
      position: relative;
    }

    /* Brand/Logo area */
    .login-brand-area {
      text-align: center;
      margin-bottom: 24px;
    }

    .login-logo-wrap {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 100px;
      height: 100px;
      border-radius: 28px;
      background: linear-gradient(135deg, #ff758f 0%, #ff4d6d 100%);
      box-shadow: 0 12px 40px rgba(255, 77, 109, 0.35), 0 4px 12px rgba(255, 117, 143, 0.2);
      margin-bottom: 16px;
      position: relative;
      animation: logoPulse 3s ease-in-out infinite;
    }

    .login-logo-wrap img {
      width: 80px;
      height: 80px;
      border-radius: 18px;
    }

    /* Sparkle dots around logo */
    .login-logo-wrap::before,
    .login-logo-wrap::after {
      content: '✨';
      position: absolute;
      font-size: 14px;
      animation: sparkleOrbit 4s linear infinite;
    }
    .login-logo-wrap::before { top: -8px; right: -8px; animation-delay: 0s; }
    .login-logo-wrap::after { bottom: -6px; left: -8px; animation-delay: 2s; }

    @keyframes logoPulse {
      0%, 100% { transform: scale(1); box-shadow: 0 12px 40px rgba(255, 77, 109, 0.35); }
      50% { transform: scale(1.04); box-shadow: 0 16px 48px rgba(255, 77, 109, 0.45); }
    }

    @keyframes sparkleOrbit {
      0%, 100% { opacity: 0.4; transform: scale(0.8); }
      50% { opacity: 1; transform: scale(1.2); }
    }

    .login-brand-title {
      font-family: var(--login-font);
      font-size: 26px;
      font-weight: 900;
      color: #590d22;
      margin-bottom: 2px;
      letter-spacing: -0.5px;
    }

    .login-brand-title .accent {
      background: linear-gradient(135deg, #ff4d6d, #c9184a);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .login-brand-subtitle {
      font-family: var(--login-font);
      font-size: 13px;
      font-weight: 700;
      color: #ff758f;
      letter-spacing: 0.5px;
    }

    /* Card */
    .login-card {
      background: rgba(255, 255, 255, 0.92);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1.5px solid #ffe5ec;
      border-radius: 24px;
      box-shadow:
        0 20px 60px rgba(255, 117, 143, 0.15),
        0 8px 24px rgba(255, 77, 109, 0.08),
        inset 0 1px 0 rgba(255, 255, 255, 0.8);
      overflow: hidden;
      animation: cardSlideUp 0.6s cubic-bezier(0.34, 1.4, 0.64, 1) forwards;
      transform: translateY(20px);
      opacity: 0;
    }

    @keyframes cardSlideUp {
      to { transform: translateY(0); opacity: 1; }
    }

    .login-card-header {
      background: linear-gradient(135deg, #ff758f 0%, #ff4d6d 50%, #c9184a 100%);
      padding: 20px 28px;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    /* Decorative pattern on header */
    .login-card-header::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: repeating-linear-gradient(
        45deg,
        transparent,
        transparent 20px,
        rgba(255, 255, 255, 0.03) 20px,
        rgba(255, 255, 255, 0.03) 40px
      );
      pointer-events: none;
    }

    .login-card-header::after {
      content: '🌸';
      position: absolute;
      right: 20px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 24px;
      opacity: 0.4;
    }

    .login-card-header h4 {
      margin: 0;
      font-family: var(--login-font);
      font-size: 20px;
      font-weight: 800;
      color: #ffffff;
      letter-spacing: 0.3px;
      position: relative;
      z-index: 1;
    }

    .login-card-header h4 i {
      margin-right: 8px;
      font-size: 16px;
    }

    .login-card-body {
      padding: 28px 28px 24px;
    }

    /* Form elements */
    .login-card-body .form-group label {
      font-family: var(--login-font);
      font-weight: 700;
      font-size: 13px;
      color: #590d22;
      margin-bottom: 6px;
    }

    .login-card-body .form-control {
      font-family: var(--login-font);
      font-weight: 600;
      font-size: 14px;
      border: 1.5px solid #ffd1dc;
      border-radius: 14px;
      padding: 12px 16px;
      background: #fff8fa;
      color: #590d22;
      transition: all 0.25s ease;
    }

    .login-card-body .form-control:focus {
      border-color: #ff758f;
      box-shadow: 0 0 0 4px rgba(255, 117, 143, 0.15);
      background: #ffffff;
      outline: none;
    }

    .login-card-body .form-control::placeholder {
      color: #d4a0ac;
      font-weight: 500;
    }

    .login-card-body .text-small a {
      color: #ff758f;
      font-weight: 700;
      font-size: 12.5px;
      text-decoration: none;
      transition: color 0.2s;
    }

    .login-card-body .text-small a:hover {
      color: #c9184a;
    }

    /* Custom Checkbox */
    .login-card-body .custom-control-label {
      font-family: var(--login-font);
      font-weight: 600;
      font-size: 13px;
      color: #8c737c;
      cursor: pointer;
    }

    .login-card-body .custom-control-input:checked ~ .custom-control-label::before {
      background-color: #ff758f;
      border-color: #ff758f;
    }

    /* Login Button */
    .btn-login-sakura {
      font-family: var(--login-font) !important;
      font-weight: 800 !important;
      font-size: 15px !important;
      letter-spacing: 0.5px;
      background: linear-gradient(135deg, #ff758f 0%, #ff4d6d 100%) !important;
      border: none !important;
      border-radius: 16px !important;
      padding: 14px 24px !important;
      color: #ffffff !important;
      box-shadow: 0 8px 24px rgba(255, 77, 109, 0.35) !important;
      transition: all 0.3s cubic-bezier(0.34, 1.4, 0.64, 1) !important;
      position: relative;
      overflow: hidden;
    }

    .btn-login-sakura:hover {
      transform: translateY(-3px) scale(1.02);
      box-shadow: 0 12px 32px rgba(255, 77, 109, 0.45) !important;
      background: linear-gradient(135deg, #ff4d6d 0%, #c9184a 100%) !important;
    }

    .btn-login-sakura:active {
      transform: translateY(0) scale(0.98);
    }

    .btn-login-sakura::after {
      content: '🌸';
      position: absolute;
      right: 18px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 16px;
      opacity: 0.6;
    }

    /* Footer & Registration Link */
    .login-footer {
      text-align: center;
      margin-top: 20px;
      font-family: var(--login-font);
      animation: cardSlideUp 0.8s cubic-bezier(0.34, 1.4, 0.64, 1) forwards;
      animation-delay: 0.15s;
      transform: translateY(15px);
      opacity: 0;
    }

    .login-footer .register-link {
      font-size: 13.5px;
      font-weight: 700;
      color: #8c737c;
    }

    .login-footer .register-link a {
      color: #ff4d6d;
      font-weight: 800;
      text-decoration: none;
      transition: color 0.2s;
    }

    .login-footer .register-link a:hover {
      color: #c9184a;
      text-decoration: underline;
    }

    .login-copyright {
      margin-top: 16px;
      font-size: 12px;
      font-weight: 600;
      color: #c9a0ab;
    }

    .login-copyright a {
      color: #ff758f !important;
      font-weight: 700;
    }

    /* Info badges below logo */
    .login-info-badges {
      display: flex;
      justify-content: center;
      gap: 8px;
      margin-top: 10px;
      margin-bottom: 6px;
      flex-wrap: wrap;
    }

    .login-info-badge {
      font-family: var(--login-font);
      font-size: 10.5px;
      font-weight: 800;
      padding: 4px 12px;
      border-radius: 20px;
      letter-spacing: 0.3px;
      display: inline-flex;
      align-items: center;
      gap: 4px;
    }

    .badge-ipb {
      background: linear-gradient(135deg, #ff758f, #ff8fa3);
      color: #fff;
      box-shadow: 0 3px 10px rgba(255, 117, 143, 0.3);
    }

    .badge-akn {
      background: linear-gradient(135deg, #10b981, #34d399);
      color: #fff;
      box-shadow: 0 3px 10px rgba(16, 185, 129, 0.3);
    }

    /* Hide stisla default elements */
    .login-brand { display: none !important; }

    /* Responsive */
    @media (max-width: 480px) {
      .login-container { max-width: 100%; }
      .login-card-body { padding: 20px 20px 18px; }
      .login-brand-title { font-size: 22px; }
      .login-logo-wrap { width: 80px; height: 80px; border-radius: 22px; }
      .login-logo-wrap img { width: 64px; height: 64px; }
    }
  </style>
</head>

<body>
  <!-- Floating blobs -->
  <div class="deco-blob deco-blob-1"></div>
  <div class="deco-blob deco-blob-2"></div>
  <div class="deco-blob deco-blob-3"></div>
  <div class="deco-blob deco-blob-4"></div>

  <!-- Sakura Canvas (hundreds of petals like spring in Japan!) -->
  <canvas id="sakura-login-canvas"></canvas>

  <div class="login-wrapper">
    <div class="login-container">

      <!-- Brand Area -->
      <div class="login-brand-area">
        <div class="login-logo-wrap">
          <img src="<?= base_url('template/assets/img/sia-akn-logo.svg') ?>" alt="SIA AKN Logo">
        </div>
        <div class="login-brand-title">
          <span class="accent">SIA AKN</span> 🌸
        </div>
        <div class="login-brand-subtitle">
          School of Vocational Studies &bull; IPB University ✨
        </div>
        <div class="login-info-badges">
          <span class="login-info-badge badge-ipb">
            <i class="fas fa-heart" style="font-size: 8px;"></i> SV-IPB AKUNTANSI
          </span>
          <span class="login-info-badge badge-akn">
            <i class="fas fa-check-circle" style="font-size: 8px;"></i> VER 2.3.5
          </span>
        </div>
      </div>

      <!-- Login Card -->
      <div class="login-card">
        <div class="login-card-header">
          <h4><?= $this->renderSection('card_header') ?? '<i class="fas fa-sign-in-alt"></i> Masuk ke Sistem 💖' ?></h4>
        </div>
        <div class="login-card-body">
          <?= $this->renderSection('main') ?>
        </div>
      </div>

      <!-- Footer -->
      <div class="login-footer">
        <div class="login-copyright">
          🌸 Copyright &copy; 2026 by <a href="#">Besty Anjali Putri Setyadi</a> &bull; SV-IPB 🌸
        </div>
      </div>

    </div>
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
  <!-- Lush Japanese Sakura Fubuki Canvas Simulation -->
  <script src="<?= base_url('template/assets/js/sakura-petals.js') ?>?v=<?= time() ?>"></script>
</body>
</html>
