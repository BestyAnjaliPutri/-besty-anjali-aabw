<?= $this->extend('layout/backend') ?>

<?= $this->section('title') ?>
<title>SIA-IPB &mdash; Detail Transaksi</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <a href="<?= site_url('transaksi') ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back</a>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Detail Transaksi</h4>
            </div>
            <div class="card-body p-4">
                <!-- Information Header Transaksi -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td style="width: 140px; font-weight: 600;">No Kwitansi</td>
                                <td style="width: 20px;">:</td>
                                <td><?= $dttransaksi->kwitansi ?? $dttransaksi->id_transaksi ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: 600;">Tanggal</td>
                                <td>:</td>
                                <td><?= date('d/m/Y', strtotime($dttransaksi->tanggal)) ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: 600;">Deskripsi</td>
                                <td>:</td>
                                <td><?= $dttransaksi->deskripsi ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: 600;">Ket Jurnal</td>
                                <td>:</td>
                                <td><?= $dttransaksi->ketjurnal ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Tabel Detail Nilai Transaksi -->
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-md">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th style="width: 15%">Kode Akun</th>
                                <th style="width: 30%">Nama Akun</th>
                                <th style="width: 20%">Debit</th>
                                <th style="width: 20%">Kredit</th>
                                <th style="width: 10%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $totDebet = 0;
                            $totKredit = 0;
                            foreach ($dtnilai as $key => $item) : 
                                $item = (object) $item;
                                $valDebet = $item->debet ?? $item->debit ?? 0;
                                $valKredit = $item->kredit ?? 0;
                                $totDebet += $valDebet;
                                $totKredit += $valKredit;
                            ?>
                                <tr>
                                    <td class="text-center"><?= $key + 1 ?></td>
                                    <td><?= $item->kode_akun3 ?></td>
                                    <td><?= $item->nama_akun3 ?? '-' ?></td>
                                    <td>Rp <?= number_format($valDebet, 0, ',', '.') ?></td>
                                    <td>Rp <?= number_format($valKredit, 0, ',', '.') ?></td>
                                    <td><?= $item->status ?? $item->id_status ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="font-weight-bold" style="background-color: #f4f6f9;">
                                <td colspan="3" class="text-center">Total</td>
                                <td>Rp <?= number_format($totDebet, 0, ',', '.') ?></td>
                                <td>Rp <?= number_format($totKredit, 0, ',', '.') ?></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>