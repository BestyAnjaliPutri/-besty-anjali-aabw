<?= $this->extend('layout/backend') ?>

<?= $this->section("title") ?>
<title>SIA-IPB &mdash; Buku Besar (Posting)</title>
<?= $this->endSection() ?>

<?= $this->section("content") ?>

<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <div>
      <h1 style="color: #c9184a; font-weight: 800; font-size: 24px;">🌸 Buku Besar (Posting) ✨</h1>
      <small class="text-muted" style="font-weight: 600;">PERUSAHAAN AKN-IPB &bull; Posting Transaksi Jurnal ke Buku Besar Bentuk 4 Kolom (Saldo Rangkap)</small>
    </div>
    <div class="d-flex" style="gap: 8px;">
      <?php 
        $params = [];
        if (!empty($kode_akun3)) $params['kode_akun3'] = $kode_akun3;
        if (!empty($tgl_awal)) $params['tgl_awal'] = $tgl_awal;
        if (!empty($tgl_akhir)) $params['tgl_akhir'] = $tgl_akhir;
        $queryString = !empty($params) ? '?' . http_build_query($params) : '';
      ?>
      <a href="<?= site_url('posting/cetakposting' . $queryString) ?>" target="_blank" class="btn btn-outline-danger btn-sm" style="border-radius: 20px; font-weight: 700;">
        <i class="fas fa-print mr-1"></i> Cetak Buku Besar
      </a>
      <a href="<?= site_url('posting/postingpdf' . $queryString) ?>" target="_blank" class="btn btn-danger btn-sm" style="border-radius: 20px; font-weight: 700; background: linear-gradient(135deg, #ff758f, #ff4d6d); border: none;">
        <i class="fas fa-file-pdf mr-1"></i> Export PDF
      </a>
    </div>
  </div>

  <div class="section-body">
    <!-- Filter Card -->
    <div class="card mb-4" style="border-radius: 18px; border: 1.5px solid #ffe5ec; box-shadow: 0 4px 16px rgba(255, 117, 143, 0.08);">
      <div class="card-body py-3">
        <form method="get" action="<?= site_url('posting') ?>">
          <div class="row align-items-end">
            <div class="col-md-4">
              <label class="font-weight-bold" style="color: #c9184a; font-size: 13px;">Filter Akun</label>
              <select name="kode_akun3" class="form-control" style="border-radius: 12px; border-color: #ffd1dc;">
                <option value="">- Semua Akun (Tampilkan Seluruh Buku Besar) -</option>
                <?php foreach ($dtakun3 as $akun) : 
                  $ak = (object)$akun;
                ?>
                  <option value="<?= $ak->kode_akun3 ?>" <?= ($kode_akun3 == $ak->kode_akun3) ? 'selected' : '' ?>>
                    <?= $ak->kode_akun3 ?> &mdash; <?= esc($ak->nama_akun3 ?? $ak->nama_akun ?? '') ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-3">
              <label class="font-weight-bold" style="color: #c9184a; font-size: 13px;">Tanggal Awal</label>
              <input type="date" name="tgl_awal" class="form-control" value="<?= $tgl_awal ?? '' ?>" style="border-radius: 12px; border-color: #ffd1dc;">
            </div>
            <div class="col-md-3">
              <label class="font-weight-bold" style="color: #c9184a; font-size: 13px;">Tanggal Akhir</label>
              <input type="date" name="tgl_akhir" class="form-control" value="<?= $tgl_akhir ?? '' ?>" style="border-radius: 12px; border-color: #ffd1dc;">
            </div>
            <div class="col-md-2 mt-3 mt-md-0 d-flex" style="gap: 6px;">
              <button type="submit" class="btn btn-primary flex-fill" style="border-radius: 12px; font-weight: 700; background: linear-gradient(135deg, #ff758f, #ff4d6d); border: none;">
                <i class="fas fa-search mr-1"></i> Filter
              </button>
              <?php if (!empty($kode_akun3) || !empty($tgl_awal) || !empty($tgl_akhir)) : ?>
                <a href="<?= site_url('posting') ?>" class="btn btn-light" style="border-radius: 12px;" title="Reset Filter">
                  <i class="fas fa-undo"></i>
                </a>
              <?php endif; ?>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Per-Account Buku Besar Blocks (Strictly Following SV-IPB Accounting Format) -->
    <?php if (empty($bukuBesar)) : ?>
      <div class="card" style="border-radius: 18px; border: 1.5px solid #ffe5ec;">
        <div class="card-body text-center py-5 text-muted">
          <i class="fas fa-folder-open fa-3x mb-3" style="color: #ffccd5;"></i>
          <h5>Tidak ada data akun atau transaksi ditemukan.</h5>
        </div>
      </div>
    <?php else : ?>
      <?php foreach ($bukuBesar as $acc) : ?>
        <div class="card mb-4" style="border-radius: 18px; border: 1.5px solid #ffe5ec; box-shadow: 0 4px 16px rgba(255, 117, 143, 0.08); overflow: hidden;">
          <!-- Account Header Bar (Matching PDF: Nama Akun on Left, No & Currency on Right) -->
          <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #fff0f3 0%, #ffe5ec 100%); border-bottom: 1.5px solid #ffd1dc; padding: 12px 20px;">
            <div style="font-size: 15px; font-weight: 800; color: #a4133c;">
              <span>Nama Akun: </span>
              <span style="color: #590d22;"><?= esc($acc['nama_akun3']) ?></span>
            </div>
            <div style="font-size: 15px; font-weight: 800; color: #a4133c;">
              <span>No : </span>
              <span class="badge badge-danger mr-2" style="background: #ff4d6d; font-size: 13px; font-weight: 800;"><?= esc($acc['kode_akun3']) ?></span>
              <span style="color: #8c737c; font-size: 13px;">(Rp,-)</span>
            </div>
          </div>

          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-bordered table-sm mb-0" style="font-size: 13.5px; table-layout: fixed;">
                <thead>
                  <tr class="text-center" style="background-color: #fff5f8; color: #590d22; font-weight: 700;">
                    <th rowspan="2" style="vertical-align: middle; width: 13%; border-color: #ffd1dc;">Tanggal</th>
                    <th rowspan="2" style="vertical-align: middle; width: 31%; border-color: #ffd1dc;">Keterangan</th>
                    <th rowspan="2" style="vertical-align: middle; width: 8%; border-color: #ffd1dc;">Ref</th>
                    <th rowspan="2" style="vertical-align: middle; width: 12%; border-color: #ffd1dc;">Debit</th>
                    <th rowspan="2" style="vertical-align: middle; width: 12%; border-color: #ffd1dc;">Kredit</th>
                    <th colspan="2" style="width: 24%; border-color: #ffd1dc;">Saldo</th>
                  </tr>
                  <tr class="text-center" style="background-color: #fff0f3; color: #590d22; font-weight: 700;">
                    <th style="width: 12%; border-color: #ffd1dc;">Debit</th>
                    <th style="width: 12%; border-color: #ffd1dc;">Kredit</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (empty($acc['mutasi'])) : ?>
                    <tr>
                      <td class="text-center text-muted" style="border-color: #ffe5ec;">-</td>
                      <td class="text-muted font-italic" style="border-color: #ffe5ec;">Saldo Awal (Tidak ada mutasi transaksi)</td>
                      <td class="text-center text-muted" style="border-color: #ffe5ec;">-</td>
                      <td class="text-right text-muted" style="border-color: #ffe5ec;">-</td>
                      <td class="text-right text-muted" style="border-color: #ffe5ec;">-</td>
                      <td class="text-right text-muted" style="border-color: #ffe5ec;">-</td>
                      <td class="text-right text-muted" style="border-color: #ffe5ec;">-</td>
                    </tr>
                  <?php else : ?>
                    <?php foreach ($acc['mutasi'] as $row) : 
                        $valDebet  = floatval($row->debet ?? $row->debit ?? 0);
                        $valKredit = floatval($row->kredit ?? 0);
                    ?>
                      <tr style="transition: background-color 0.2s;">
                        <td class="text-center font-weight-bold" style="border-color: #ffe5ec;"><?= date('d/m/Y', strtotime($row->tanggal)) ?></td>
                        <td style="border-color: #ffe5ec;"><?= esc($row->deskripsi ?? 'Transaksi') ?></td>
                        <td class="text-center" style="border-color: #ffe5ec;">
                          <span class="badge badge-light border" style="font-size: 11px;"><?= esc($row->kwitansi ?? 'J1') ?></span>
                        </td>
                        <td class="text-right" style="border-color: #ffe5ec;"><?= $valDebet > 0 ? number_format($valDebet, 0, ',', '.') : '-' ?></td>
                        <td class="text-right" style="border-color: #ffe5ec;"><?= $valKredit > 0 ? number_format($valKredit, 0, ',', '.') : '-' ?></td>
                        <td class="text-right font-weight-bold" style="border-color: #ffe5ec; color: #047857;">
                          <?= ($row->saldo_debet ?? 0) > 0 ? number_format($row->saldo_debet, 0, ',', '.') : '-' ?>
                        </td>
                        <td class="text-right font-weight-bold" style="border-color: #ffe5ec; color: #0369a1;">
                          <?= ($row->saldo_kredit ?? 0) > 0 ? number_format($row->saldo_kredit, 0, ',', '.') : '-' ?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </tbody>
                <tfoot>
                  <tr style="background-color: #fff8fa; font-weight: 800; border-top: 2px solid #ffd1dc;">
                    <td colspan="3" class="text-right" style="color: #a4133c; border-color: #ffd1dc;">Total Mutasi & Saldo Akhir:</td>
                    <td class="text-right" style="border-color: #ffd1dc; color: #590d22;"><?= $acc['totDebet'] > 0 ? number_format($acc['totDebet'], 0, ',', '.') : '-' ?></td>
                    <td class="text-right" style="border-color: #ffd1dc; color: #590d22;"><?= $acc['totKredit'] > 0 ? number_format($acc['totKredit'], 0, ',', '.') : '-' ?></td>
                    <td class="text-right" style="border-color: #ffd1dc; color: #047857;">
                      <?= (($acc['posisiNormal'] === 'debet' && $acc['saldoAkhir'] >= 0) || ($acc['posisiNormal'] === 'kredit' && $acc['saldoAkhir'] < 0)) && abs($acc['saldoAkhir']) > 0 ? number_format(abs($acc['saldoAkhir']), 0, ',', '.') : '-' ?>
                    </td>
                    <td class="text-right" style="border-color: #ffd1dc; color: #0369a1;">
                      <?= (($acc['posisiNormal'] === 'kredit' && $acc['saldoAkhir'] >= 0) || ($acc['posisiNormal'] === 'debet' && $acc['saldoAkhir'] < 0)) && abs($acc['saldoAkhir']) > 0 ? number_format(abs($acc['saldoAkhir']), 0, ',', '.') : '-' ?>
                    </td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>

  </div>
</section>

<?= $this->endSection() ?>
