              <li class="menu-header">Dashboard</li>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Kode Akun</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="<?= site_url('akun1') ?>"><i class="fas fa-layer-group"></i> Akun - 1</a></li>
                  <li><a class="nav-link" href="<?= site_url('akun2') ?>"><i class="fas fa-stream"></i> Akun - 2</a></li>
                  <li><a class="nav-link" href="<?= site_url('akun3') ?>"><i class="fas fa-list-ul"></i> Akun - 3</a></li>
                </ul>
              </li>
              <li class="menu-header">Aktiviti</li>
            <li><a class="nav-link" href="<?= site_url('jurnalumum') ?>"><i class="fas fa-calendar-alt"></i> <span>Jurnal Umum</span></a></li>
            <li><a class="nav-link" href="<?= site_url('posting') ?>"><i class="fas fa-book"></i> <span>Posting</span></a></li>
            <li><a class="nav-link" href="<?= site_url('neracasaldo') ?>"><i class="fas fa-balance-scale"></i> <span>Neraca Saldo</span></a></li>
            <li><a class="nav-link" href="<?= site_url('neracalajur') ?>"><i class="fas fa-table"></i> <span>Neraca Lajur</span></a></li>

              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Transaksi</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="<?= site_url('transaksi') ?>"><i class="fas fa-file-invoice-dollar"></i> Transaksi Jurnal</a></li>
                  <li><a class="nav-link" href="<?= site_url('penyesuaian') ?>"><i class="fas fa-sliders-h"></i> Transaksi Penyesuaian</a></li>
                </ul>
              </li>
             
              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-th"></i> <span>Laporan Keuangan</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="<?= site_url('labarugi') ?>"><i class="fas fa-chart-line"></i> Laba Rugi</a></li>
                  <li><a class="nav-link" href="<?= site_url('perubahanmodal') ?>"><i class="fas fa-coins"></i> Perubahan Modal</a></li>
                  <li><a class="nav-link" href="<?= site_url('neraca') ?>"><i class="fas fa-balance-scale"></i> Neraca</a></li>
                  <li><a class="nav-link" href="<?= site_url('aruskas') ?>"><i class="fas fa-money-bill-wave"></i> Arus Kas</a></li>
                </ul>
              </li>

              <li class="menu-header">Setting</li>
              <li><a class="nav-link" href="<?= site_url('user') ?>"><i class="fas fa-users"></i> <span>Management User</span></a></li>
