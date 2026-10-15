<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kode Verifikasi Pendaftaran PPDB</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
            border: 1px solid #e2e8f0;
        }
        .header {
            background: linear-gradient(135deg, #15803d, #22c55e);
            color: #ffffff;
            text-align: center;
            padding: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .header p {
            margin: 5px 0 0 0;
            opacity: 0.9;
            font-size: 14px;
        }
        .content {
            padding: 40px 30px;
            line-height: 1.6;
        }
        .content h2 {
            font-size: 20px;
            color: #0f172a;
            margin-top: 0;
        }
        .code-box {
            background: #f8fafc;
            border: 2px dashed #cbd5e1;
            border-radius: 8px;
            text-align: center;
            padding: 20px;
            margin: 30px 0;
        }
        .code {
            font-size: 36px;
            font-weight: 800;
            letter-spacing: 6px;
            color: #15803d;
            margin: 0;
        }
        .footer {
            background: #f8fafc;
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
        }
        .warning {
            font-size: 13px;
            color: #64748b;
            margin-top: 25px;
            border-top: 1px solid #f1f5f9;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>MI Infarul Ghoyyi Kalijambe</h1>
            <p>Pendaftaran Peserta Didik Baru (PPDB)</p>
        </div>
        <div class="content">
            <h2>Halo Calon Peserta Didik Baru,</h2>
            <p>Terima kasih telah memulai proses pendaftaran akun di PPDB MI Infarul Ghoyyi. Gunakan kode verifikasi di bawah ini untuk melanjutkan pendaftaran dan membuat password akun Anda:</p>
            
            <div class="code-box">
                <p style="margin: 0 0 10px 0; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: #64748b; font-weight: 600;">Kode Verifikasi Anda</p>
                <div class="code">{{ $code }}</div>
                <p style="margin: 10px 0 0 0; font-size: 12px; color: #94a3b8;">Berlaku selama 15 menit</p>
            </div>
            
            <p>Jika Anda tidak merasa melakukan pendaftaran ini, silakan abaikan email ini.</p>
            
            <div class="warning">
                <p style="margin: 0;">Email ini dikirimkan secara otomatis oleh sistem PPDB MI Infarul Ghoyyi Kalijambe. Mohon tidak membalas email ini.</p>
            </div>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} MI Infarul Ghoyyi Kalijambe. Hak Cipta Dilindungi.
        </div>
    </div>
</body>
</html>
