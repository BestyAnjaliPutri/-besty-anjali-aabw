<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="robots" content="noindex">
    <title>SIA-AKN &mdash; Terjadi Kendala Sistem</title>
    <link rel="icon" type="image/svg+xml" href="<?= function_exists('base_url') ? base_url('favicon.svg') : '' ?>">
    <style>
        body {
            background: linear-gradient(135deg, #fff0f3 0%, #ffccd5 50%, #ffe5ec 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
            color: #5c4d54;
        }
        .error-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-radius: 24px;
            padding: 35px 30px;
            box-shadow: 0 20px 50px rgba(255, 117, 143, 0.25);
            border: 2px solid rgba(255, 117, 143, 0.25);
            max-width: 680px;
            width: 100%;
            text-align: center;
            animation: fadeIn 0.4s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .error-badge {
            display: inline-block;
            background: #ffe5ec;
            color: #ff758f;
            padding: 6px 16px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 13px;
            margin-bottom: 12px;
            box-shadow: 0 2px 8px rgba(255, 117, 143, 0.15);
        }
        .error-title {
            color: #5c4d54;
            font-size: 24px;
            margin: 0 0 10px 0;
            font-weight: 800;
        }
        .error-lead {
            color: #7a5c68;
            font-size: 14px;
            margin: 0 0 20px 0;
            line-height: 1.5;
        }
        .error-box {
            background: #fff5f8;
            border: 1px dashed #ff758f;
            border-radius: 14px;
            padding: 16px 18px;
            text-align: left;
            margin-bottom: 22px;
            font-size: 13px;
        }
        .error-box-header {
            color: #c9184a;
            font-weight: 700;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .error-box code {
            color: #800f2f;
            font-family: Consolas, Monaco, "Courier New", monospace;
            word-break: break-all;
            display: block;
            margin-top: 4px;
            background: rgba(255, 255, 255, 0.7);
            padding: 8px 10px;
            border-radius: 8px;
            border: 1px solid #ffd1dc;
        }
        .btn-retry {
            display: inline-block;
            background: linear-gradient(135deg, #ff758f, #ff8fa3);
            color: #fff;
            padding: 12px 28px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            box-shadow: 0 6px 18px rgba(255, 117, 143, 0.35);
            transition: all 0.25s ease;
        }
        .btn-retry:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(255, 117, 143, 0.45);
            color: #fff;
        }
        .hint-text {
            margin-top: 15px;
            font-size: 12px;
            color: #a37081;
        }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="error-badge">🌸 SIA-AKN System Status</div>
        <h1 class="error-title">Whoops! Perlu Sedikit Pengaturan 🌸</h1>
        <p class="error-lead">Aplikasi belum terhubung dengan sempurna ke database atau konfigurasi server.</p>

        <?php if (isset($exception) && $exception instanceof Throwable): ?>
            <div class="error-box">
                <div class="error-box-header">🔍 Detail Kendala:</div>
                <code><?= esc($exception->getMessage()) ?></code>
                <div style="margin-top: 8px; font-size: 11px; color: #a37081;">
                    Lokasi: <?= esc(basename($exception->getFile())) ?>:<?= esc($exception->getLine()) ?>
                </div>
            </div>
        <?php else: ?>
            <div class="error-box">
                <div class="error-box-header">💡 Petunjuk:</div>
                <div>Periksa kembali pengaturan koneksi TiDB Cloud dan pastikan tabel database sudah diimpor.</div>
            </div>
        <?php endif; ?>

        <a href="<?= function_exists('base_url') ? base_url('login') : '/login' ?>" class="btn-retry">🔄 Refresh / Coba Lagi</a>

        <div class="hint-text">
            SIA-AKN SV-IPB &bull; Cute Pink Pastel Sakura Edition
        </div>
    </div>
</body>
</html>
