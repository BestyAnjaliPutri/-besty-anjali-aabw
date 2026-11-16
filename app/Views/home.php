<?= $this->extend('layout/backend') ?>

<?= $this->section("content") ?>

<!-- Cute Pink Pastel Sakura Overview Dashboard Theme -->
<link rel="stylesheet" href="<?= base_url('template/assets/css/overview-cute.css') ?>?v=<?= time() ?>">

<section class="section">
  <!-- Cute Section Header: "🌸 Overview Dashboard ✨" -->
  <div class="cute-overview-header">
    <h1 class="cute-header-title">🌸 Overview Dashboard ✨</h1>
    <div class="d-flex align-items-center" style="gap: 12px;">
      <span class="cute-sys-status-badge">
        <i class="fas fa-heart mr-1"></i> STATUS: AKTIF 💖
      </span>
    </div>
  </div>

  <div class="section-body">
    <!-- Main Command Center Card (Cute Pink Pastel Sakura Edition) -->
    <div class="cute-command-card">
      <!-- Decorative Corner Sakura Elements -->
      <div class="card-corner-sakura corner-tl">🌸</div>
      <div class="card-corner-sakura corner-tr">✨</div>
      <div class="card-corner-sakura corner-bl">🌷</div>
      <div class="card-corner-sakura corner-br">🌸</div>

      <div class="row align-items-center">
        
        <!-- Left Column: System Status Badges, Title, Subtitle, Description & 3 Cute Action Buttons -->
        <div class="col-lg-7 pr-lg-4">
          <!-- Status Badges Row -->
          <div class="cute-badges-row">
            <span class="cute-pill-badge pill-online">
              <i class="fas fa-heart mr-1"></i> SYSTEM ONLINE 🌸
            </span>
            <span class="cute-pill-badge pill-version">
              <i class="fas fa-check-circle mr-1"></i> VER: 2.3.5
            </span>
            <span class="cute-tag-text">// SV_IPB_AKUNTANSI 💖</span>
          </div>

          <!-- Main Title -->
          <h2 class="cute-main-title">
            Accounting Information System &mdash; <span class="cute-title-akn">SIA AKN 🌸</span>
          </h2>

          <!-- Subtitle -->
          <div class="cute-main-subtitle">
            School of Vocational Studies &bull; IPB University ✨
          </div>

          <!-- Description Paragraph -->
          <p class="cute-main-desc">
            Sistem Informasi Akuntansi berbasis web terintegrasi &mdash; buku besar, jurnal umum, ayat jurnal penyesuaian, neraca lajur, serta laporan keuangan otomatis yang seimbang (balance).
          </p>

          <!-- 3 Cute Squishy Action Buttons Row -->
          <div class="cute-action-btn-group">
            <a href="<?= site_url('transaksi') ?>" class="cute-btn cute-btn-rose">
              <i class="fas fa-file-invoice-dollar mr-1"></i> Buka Transaksi
            </a>
            <a href="<?= site_url('neracalajur') ?>" class="cute-btn cute-btn-outline-sakura">
              <i class="fas fa-table mr-1"></i> Neraca Lajur
            </a>
            <a href="<?= site_url('labarugi') ?>" class="cute-btn cute-btn-peach">
              <i class="fas fa-chart-line mr-1"></i> Laba Rugi
            </a>
          </div>
        </div>

        <!-- Right Column: Cute Sakura Operator Deck & 3D Interactive Chibi Mascot -->
        <div class="col-lg-5 mt-4 mt-lg-0">
          <div class="cute-sakura-deck">
            <!-- Operator Header Bar -->
            <div class="cute-deck-header">
              <span class="cute-operator-label">
                🌸 OPERATOR // <?= function_exists('logged_in') && logged_in() ? strtoupper(esc(user()->username)) : 'BESTY ANJALI' ?> 💖
              </span>
              <span class="cute-pilot-pill">👑 [Pilot 002]</span>
            </div>

            <!-- Viewport with 4 Cute Sakura Corner Brackets -->
            <div class="cute-viewport-box">
              <div class="cute-corner-flower corner-flower-tl">🌸</div>
              <div class="cute-corner-flower corner-flower-tr">🌸</div>
              <div class="cute-corner-flower corner-flower-bl">🌸</div>
              <div class="cute-corner-flower corner-flower-br">🌸</div>

              <!-- Interactive 3D Model: Zero Two (Tencent Hunyuan3D AI) -->
              <model-viewer
                id="zerotwo-3d-model"
                src="<?= site_url('home/zerotwomodel') ?>"
                alt="Zero Two Chibi 3D Model"
                auto-rotate
                auto-rotate-delay="400"
                rotation-per-second="22deg"
                camera-controls
                camera-orbit="0deg 75deg 2.4m"
                min-camera-orbit="auto auto 1.5m"
                max-camera-orbit="auto auto 5m"
                shadow-intensity="1.2"
                shadow-softness="0.8"
                exposure="1.15"
                interaction-prompt="none"
                style="width: 100%; height: 100%; display: block; outline: none; background: transparent; --poster-color: transparent;"
              >
                <!-- Loading State with Cute Sakura Spinner -->
                <div slot="poster" class="d-flex flex-column align-items-center justify-content-center h-100" style="color: #ff4d6d; font-weight: 700;">
                  <div class="spinner-border text-danger mb-2" role="status" style="width: 2.2rem; height: 2.2rem; border-color: #ff758f; border-right-color: transparent;"></div>
                  <span style="font-size: 12px; letter-spacing: 0.5px;">Memuat Zero Two 3D... 🌸</span>
                </div>
              </model-viewer>

              <!-- Viewport Footer -->
              <div class="cute-viewport-footer">
                <span class="cute-drag-hint">
                  <i class="fas fa-arrows-alt mr-1"></i> Geser untuk memutar Zero Two ✨
                </span>
                <span class="cute-render-tag">PILOT 002 💖</span>
              </div>

              <!-- Mini Floating HUD Card on Bottom-Right -->
              <div class="cute-floating-hud">
                <div class="cute-hud-avatar">👑</div>
                <div class="cute-hud-info">
                  <div class="cute-hud-title">ZERO TWO</div>
                  <div class="cute-hud-status">
                    <i class="fas fa-heart mr-1" style="font-size: 8px;"></i>
                    PILOT 002 &bull; READY ✨
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- 4 Gemas Metric Stat Cards (Matching Format with Sweet Kawaii Palette) -->
    <div class="row">
      <!-- 1. Total Account Codes (Strawberry Pink) -->
      <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4 d-flex">
        <a href="<?= site_url('akun1') ?>" style="text-decoration: none; color: inherit; display: block; width: 100%;">
          <div class="cute-stat-card cute-stat-pink h-100">
            <span class="stat-tag-badge">🎀 Akun</span>
            <div class="cute-stat-icon-squircle">
              <i class="fas fa-wallet btn-button-big"></i>
            </div>
            <div class="stat-title-label">Total Account Codes</div>
            <div class="stat-value-wrap">
              <span class="stat-value-text"><?= esc($totalAkun ?? 30) ?></span>
              <span class="stat-sub-text">Accounts 🍓</span>
            </div>
          </div>
        </a>
      </div>

      <!-- 2. Journal Entries (Pastel Sky Blue) -->
      <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4 d-flex">
        <a href="<?= site_url('transaksi') ?>" style="text-decoration: none; color: inherit; display: block; width: 100%;">
          <div class="cute-stat-card cute-stat-blue h-100">
            <span class="stat-tag-badge">☁️ Jurnal</span>
            <div class="cute-stat-icon-squircle">
              <i class="fas fa-file-invoice btn-big"></i>
            </div>
            <div class="stat-title-label">Journal Entries</div>
            <div class="stat-value-wrap">
              <span class="stat-value-text"><?= esc($totalTransaksi ?? 19) ?></span>
              <span class="stat-sub-text">Dec 2025 ⭐</span>
            </div>
          </div>
        </a>
      </div>

      <!-- 3. Adjusting Entries (Honey Peach) -->
      <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4 d-flex">
        <a href="<?= site_url('penyesuaian') ?>" style="text-decoration: none; color: inherit; display: block; width: 100%;">
          <div class="cute-stat-card cute-stat-peach h-100">
            <span class="stat-tag-badge">🧁 AJP</span>
            <div class="cute-stat-icon-squircle">
              <i class="fas fa-sliders-h btn-big"></i>
            </div>
            <div class="stat-title-label">Adjusting Entries</div>
            <div class="stat-value-wrap">
              <span class="stat-value-text"><?= esc($totalPenyesuaian ?? 5) ?></span> 
              <span class="stat-sub-text">Cases 🍯</span>
            </div>
          </div>
        </a>
      </div>

      <!-- 4. Balance Status (Apple Mint Green) -->
      <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4 d-flex">
        <a href="<?= site_url('neracalajur') ?>" style="text-decoration: none; color: inherit; display: block; width: 100%;">
          <div class="cute-stat-card cute-stat-mint h-100">
            <span class="stat-tag-badge">✨ Balance!</span>
            <div class="cute-stat-icon-squircle">
              <i class="fas fa-balance-scale btn-bigtitle"></i>
            </div>
            <div class="stat-title-label">Balance Status</div>
            <div class="stat-value-wrap">
              <span class="stat-value-text stat-value-balance d-inline-flex align-items-center justify-content-center">
                <?= esc($balanceStatus ?? 'BALANCED') ?>
                <i class="fas fa-check-circle ml-1" style="color: #10b981; font-size: 18px;"></i>
              </span>
              <span class="stat-sub-text">Balanced 🌿</span>
            </div>
          </div>
        </a>
      </div>
    </div>

  </div>
</section>

<!-- Google's 3D Web Component Engine for Zero Two GLB Model -->
<script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/4.0.0/model-viewer.min.js"></script>

<?= $this->endSection() ?>