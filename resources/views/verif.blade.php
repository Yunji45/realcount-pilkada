<!DOCTYPE html>
<html>
<head>
    <title>Registrasi Berhasil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            margin: 0 auto;
            padding: 20px;
            max-width: 600px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2e6da4;
        }
        p {
            font-size: 16px;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #888;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Selamat, {{ $data['name'] }}!</h1>
        <p>Terima kasih telah mendaftar di aplikasi kami. Registrasi Anda telah lolos verifikasi.</p>
        <p>Berikut adalah detail akun Anda:</p>
        <ul>
            <li><strong>Nik:</strong> {{ $data['nik'] }}</li>
            <li><strong>Nama:</strong> {{ $data['name'] }}</li>
            <li><strong>Email:</strong> {{ $data['email'] }}</li>
            <li><strong>Status:</strong> {{ $data['status'] }}</li>
        </ul>
        <p>Jika Anda memiliki pertanyaan atau butuh bantuan, jangan ragu untuk menghubungi kami.</p>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} DPC Gerindra Kota Bandung. Semua hak dilindungi.</p>
        </div>
    </div>
</body>
</html>