<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>14. Implementasi API Print & Jilid - Pusat Mercis UINMA</title>
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; background:#fafafa; color: #333; margin: 0; padding: 20px; line-height: 1.5; }
        .container { max-width: 1200px; margin: 0 auto; }
        nav { background:#fff; padding: 10px 15px; border: 1px solid #e5e5e5; border-radius: 6px; margin-bottom: 20px; font-size: 12px; display: flex; gap: 8px; flex-wrap: wrap; }
        nav a { color:#666; text-decoration: none; padding: 4px 8px; border-radius: 4px; }
        nav a:hover, nav a.active { background:#e5e7eb; color:#000; font-weight: 600; }
        .box { background:#fff; border: 1px solid #e5e5e5; border-radius: 6px; padding: 16px; margin-bottom: 20px; }
        h2 { font-size: 15px; margin: 0 0 12px 0; font-weight: 600; border-bottom: 1px solid #eee; padding-bottom: 6px; }

        .api-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 10px; margin-bottom: 15px; }
        .api-card { border: 1px solid #e2e8f0; border-radius: 6px; padding: 12px; background: #f8fafc; }
        .api-card h3 { margin: 0 0 6px 0; font-size: 13px; color: #1e293b; display: flex; justify-content: space-between; align-items: center; }
        .method { font-size: 9px; padding: 2px 6px; border-radius: 3px; font-weight: bold; color: #fff; }
        .get { background: #10b981; }
        .post { background: #2563eb; }
        .btn-test { background: #0f172a; color: #fff; border: none; padding: 6px 12px; border-radius: 4px; font-size: 11px; cursor: pointer; width: 100%; font-weight: 600; margin-top: 8px; }
        .btn-test:hover { background: #334155; }

        .info-card { background: #eff6ff; border: 1px solid #bfdbfe; padding: 12px; border-radius: 6px; font-size: 12px; margin-bottom: 15px; color: #1e40af; }
        pre { background:#0f172a; color:#f8fafc; padding: 14px; border-radius: 6px; font-size: 11px; overflow-x: auto; white-space: pre-wrap; max-height: 400px; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header Navigasi -->
        <nav>
            <a href="../01-Setup-Backend-Print-and-Jilid/">Setup Backend</a>
            <a href="../02-Implementasi-Database-Layanan-Print-and-Jilid/">Database</a>
            <a href="../03-Implementasi-Upload-File/">Upload File</a>
            <a href="../04-Implementasi-Validasi-File/">Validasi File</a>
            <a href="../05-Implementasi-Pilihan-Jenis-Print/">Jenis Print</a>
            <a href="../06-Implementasi-Pilihan-Ukuran-dan-Jenis-Kertas/">Kertas</a>
            <a href="../07-Implementasi-Pilihan-Warna-Cetak/">Warna Cetak</a>
            <a href="../08-Implementasi-Pilihan-Jumlah-Cetakan/">umlah Cetakan</a>
            <a href="../09-Implementasi-Pilihan-Jenis-Jilid/">Jenis Jilid</a>
            <a href="../10-Implementasi-Perhitungan-Harga/">Hitung Harga</a>
            <a href="../11-Implementasi-Pemesanan-Print-and-Jilid/">Pemesanan</a>
            <a href="../12-Implementasi-Manajemen-Pesanan-Print-and-Jilid/">Manajemen Pesanan</a>
            <a href="../13-Implementasi-Status-Pesanan/">1Status Pesanan</a>
            <a href="../14-Implementasi-API-Print-and-Jilid/" class="active">API Print & Jilid</a>
        </nav>

        <div class="info-card">
            ⚡ <strong>Dokumentasi & Pengujian Restful API Print & Jilid:</strong><br>
            Modul ini menghubungkan antarmuka Frontend dengan Backend Layanan Cetak UINMA. Klik tombol di bawah untuk menguji respons endpoint API secara live[cite: 16].
        </div>

        <!-- Panel Kartu Pengujian Endpoint API -->
        <div class="box">
            <h2>Daftar Endpoint API</h2>
            <div class="api-grid">
                <div class="api-card">
                    <h3>Layanan Print <span class="method get">GET</span></h3>
                    <p style="font-size:11px; color:#666; margin:0;">Mengambil katalog jenis print.</p>
                    <button class="btn-test" onclick="testApi('api.php?action=layanan_print')">Uji Endpoint</button>
                </div>
                <div class="api-card">
                    <h3>Upload File <span class="method post">POST</span></h3>
                    <p style="font-size:11px; color:#666; margin:0;">Mengunggah dokumen ke server.</p>
                    <button class="btn-test" onclick="testApi('api.php?action=upload_file', 'POST')">Uji Endpoint</button>
                </div>
                <div class="api-card">
                    <h3>Pilihan Kertas <span class="method get">GET</span></h3>
                    <p style="font-size:11px; color:#666; margin:0;">Mengambil opsi & tarif kertas.</p>
                    <button class="btn-test" onclick="testApi('api.php?action=pilihan_kertas')">Uji Endpoint</button>
                </div>
                <div class="api-card">
                    <h3>Pilihan Jilid <span class="method get">GET</span></h3>
                    <p style="font-size:11px; color:#666; margin:0;">Mengambil opsi jilid & harga.</p>
                    <button class="btn-test" onclick="testApi('api.php?action=pilihan_jilid')">Uji Endpoint</button>
                </div>
                <div class="api-card">
                    <h3>Perhitungan Harga <span class="method get">GET/POST</span></h3>
                    <p style="font-size:11px; color:#666; margin:0;">Kalkulasi otomatis total biaya.</p>
                    <button class="btn-test" onclick="testApi('api.php?action=perhitungan_harga&jumlah_halaman=25&jumlah_copy=2&kode_kertas=A4_80&kode_jilid=jilid_hardcover')">Uji Endpoint</button>
                </div>
                <div class="api-card">
                    <h3>Pemesanan <span class="method post">POST</span></h3>
                    <p style="font-size:11px; color:#666; margin:0;">Checkout/Membuat order baru.</p>
                    <button class="btn-test" onclick="testApi('api.php?action=pemesanan', 'POST', {nama_pemesan:'Ahmad UINMA', total_biaya:'Rp 45.000'})">Uji Endpoint</button>
                </div>
                <div class="api-card">
                    <h3>7Daftar Pesanan <span class="method get">GET</span></h3>
                    <p style="font-size:11px; color:#666; margin:0;">Mengambil seluruh daftar order.</p>
                    <button class="btn-test" onclick="testApi('api.php?action=daftar_pesanan')">Uji Endpoint</button>
                </div>
                <div class="api-card">
                    <h3>Detail Pesanan <span class="method get">GET</span></h3>
                    <p style="font-size:11px; color:#666; margin:0;">Mengambil rincian 1 pesanan.</p>
                    <button class="btn-test" onclick="testApi('api.php?action=detail_pesanan&id_pesanan=ORD-20260929-101')">Uji Endpoint</button>
                </div>
                <div class="api-card">
                    <h3>9Update Status <span class="method post">POST</span></h3>
                    <p style="font-size:11px; color:#666; margin:0;">Mengubah status pengerjaan.</p>
                    <button class="btn-test" onclick="testApi('api.php?action=update_status', 'POST', {id_pesanan:'ORD-20260929-101', status_pesanan:'Selesai'})">Uji Endpoint</button>
                </div>
            </div>
        </div>

        <!-- Terminal Output Response JSON -->
        <div class="box">
            <h2>JSON Response Console Terminal</h2>
            <pre id="jsonTerminal">// Klik tombol "Uji Endpoint" di atas untuk melihat respons API di sini...</pre>
        </div>
    </div>

    <script>
        async function testApi(url, method = 'GET', bodyData = null) {
            const terminal = document.getElementById('jsonTerminal');
            terminal.textContent = `// Sending ${method} Request to: ${url}...`;

            try {
                const options = { method: method, headers: { 'Content-Type': 'application/json' } };
                if (bodyData && method === 'POST') {
                    options.body = JSON.stringify(bodyData);
                }

                const res = await fetch(url, options);
                const result = await res.json();
                terminal.textContent = JSON.stringify(result, null, 2);
            } catch (err) {
                terminal.textContent = `// Error Fetching API: ${err.message}`;
            }
        }
    </script>
</body>
</html>