<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>09. Implementasi Pilihan Jenis Jilid</title>
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; background:#fafafa; color: #333; margin: 0; padding: 20px; line-height: 1.5; }
        .container { max-width: 1100px; margin: 0 auto; }
        nav { background:#fff; padding: 10px 15px; border: 1px solid #e5e5e5; border-radius: 6px; margin-bottom: 20px; font-size: 12px; display: flex; gap: 8px; flex-wrap: wrap; }
        nav a { color:#666; text-decoration: none; padding: 4px 8px; border-radius: 4px; }
        nav a:hover, nav a.active { background:#e5e7eb; color:#000; font-weight: 600; }
        .box { background:#fff; border: 1px solid #e5e5e5; border-radius: 6px; padding: 16px; margin-bottom: 20px; }
        h2 { font-size: 15px; margin: 0 0 12px 0; font-weight: 600; border-bottom: 1px solid #eee; padding-bottom: 6px; }
        .form-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
        label { font-size: 11px; color:#555; display: block; margin-bottom: 4px; font-weight: 500; }
        input, select { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; box-sizing: border-box; }
        .info-card { background:#f9fafb; border: 1px dashed #d1d5db; padding: 12px; border-radius: 6px; margin-top: 15px; display: flex; justify-content: space-between; align-items: center; }
        button { background:#4b5563; color:#fff; border: none; padding: 10px 12px; border-radius: 4px; font-size: 13px; cursor: pointer; width: 100%; margin-top: 15px; font-weight: 600; }
        button:hover { background:#374151; }
        pre { background:#f4f4f5; padding: 12px; border-radius: 4px; font-size: 11px; overflow-x: auto; white-space: pre-wrap; margin-top: 12px; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border-bottom: 1px solid #eee; padding: 8px; text-align: left; }
        th { background:#f9f9f9; color:#555; }
        .badge-spiral { background:#e0f2fe; color:#0369a1; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: 600; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Navigasi Modul -->
        <nav>
            <a href="../01-Setup-Backend-Print-and-Jilid/">Setup Backend</a>
            <a href="../02-Implementasi-Database-Layanan-Print-and-Jilid/">Database</a>
            <a href="../03-Implementasi-Upload-File/">Upload File</a>
            <a href="../04-Implementasi-Validasi-File/">Validasi File</a>
            <a href="../05-Implementasi-Pilihan-Jenis-Print/">Jenis Print</a>
            <a href="../06-Implementasi-Pilihan-Ukuran-dan-Jenis-Kertas/">Kertas</a>
            <a href="../07-Implementasi-Pilihan-Warna-Cetak/">Warna Cetak</a>
            <a href="../08-Implementasi-Pilihan-Jumlah-Cetakan/">Jumlah Cetakan</a>
            <a href="../09-Implementasi-Pilihan-Jenis-Jilid/" class="active">Jenis Jilid</a>
            <a href="../10-Implementasi-Perhitungan-Harga/">Hitung Harga</a>
            <a href="../11-Implementasi-Pemesanan-Print-and-Jilid/">Pemesanan</a>
            <a href="../12-Implementasi-Manajemen-Pesanan-Print-and-Jilid/">Manajemen Pesanan</a>
            <a href="../13-Implementasi-Status-Pesanan/">Status Pesanan</a>
            <a href="../14-Implementasi-API-Print-and-Jilid/">API Print & Jilid</a>
        </nav>

        <!-- Form Pengujian Jenis Jilid -->
        <div class="box">
            <h2>Form Pengujian Pilihan Jenis Jilid</h2>
            <form id="jilidForm">
                <div class="form-grid">
                    <div>
                        <label>ID Pesanan (Order ID)</label>
                        <input type="text" name="id_pesanan" id="idPesanan" value="ORD-8821" required>
                    </div>
                    <div>
                        <label>Pilih Jenis Jilid (Master Data)</label>
                        <select name="jenis_jilid" id="selectJilid" required>
                            <option value="tanpa_jilid">Tanpa Jilid (Rp 0)</option>
                            <option value="jilid_lakban">Jilid Lakban Biasa (Rp 5.000)</option>
                            <option value="jilid_spiral_kawat" selected>Jilid Spiral Kawat (Rp 12.000)</option>
                            <option value="jilid_spiral_plastik">Jilid Spiral Plastik (Rp 10.000)</option>
                            <option value="jilid_softcover">Jilid Softcover / Lem Panas (Rp 15.000)</option>
                            <option value="jilid_hardcover">Jilid Hardcover / Skripsi (Rp 30.000)</option>
                        </select>
                    </div>
                    <div>
                        <label>Jumlah Copy Cetakan</label>
                        <input type="number" name="jumlah_copy" id="numCopy" value="2" min="1" required>
                    </div>
                </div>

                <div class="info-card">
                    <div>
                        <strong>Harga per Jilid:</strong> <span id="hargaSatuanDisplay" style="color:#2563eb; font-weight:bold;">Rp 12.000</span>
                    </div>
                    <div>
                        <strong>Total Biaya Jilid:</strong> <span id="totalBiayaDisplay" style="color:#059669; font-weight:bold; font-size:16px;">Rp 24.000</span>
                    </div>
                </div>

                <button type="submit">Uji Pilihan Jenis Jilid</button>
            </form>

            <pre id="apiResponse">// Response JSON API Pengujian Jenis Jilid</pre>
        </div>

        <!-- Tabel Riwayat Pengujian -->
        <div class="box">
            <h2>Daftar Pengujian Pilihan Jilid Pesanan</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Jenis Jilid</th>
                        <th>Harga / Jilid</th>
                        <th>Jumlah Salinan</th>
                        <th>Total Biaya Jilid</th>
                        <th>Status Validasi</th>
                    </tr>
                </thead>
                <tbody id="tableHistory">
                    <tr id="emptyRow"><td colspan="6" style="text-align:center; color:#888;">Belum ada pengujian pilihan jilid. Klik tombol di atas untuk menguji!</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const priceMap = {
            'tanpa_jilid': 0,
            'jilid_lakban': 5000,
            'jilid_spiral_kawat': 12000,
            'jilid_spiral_plastik': 10000,
            'jilid_softcover': 15000,
            'jilid_hardcover': 30000
        };

        function calcBiaya() {
            const jilid = document.getElementById('selectJilid').value;
            const copy = parseInt(document.getElementById('numCopy').value) || 1;
            const harga = priceMap[jilid] || 0;
            const total = harga * copy;

            document.getElementById('hargaSatuanDisplay').textContent = 'Rp ' + harga.toLocaleString('id-ID');
            document.getElementById('totalBiayaDisplay').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        document.getElementById('selectJilid').addEventListener('change', calcBiaya);
        document.getElementById('numCopy').addEventListener('input', calcBiaya);
        calcBiaya();

       document.getElementById('jilidForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const responseContainer = document.getElementById('apiResponse');

        try {
            const res = await fetch('process_jilid.php', { method: 'POST', body: formData });
            const text = await res.text(); // Ambil teks asli terlebih dahulu
            
            try {
                const result = JSON.parse(text); // Parse ke JSON
                responseContainer.textContent = JSON.stringify(result, null, 2);

                if (result.status === 'success') {
                    const emptyRow = document.getElementById('emptyRow');
                    if (emptyRow) emptyRow.remove();

                    const data = result.data_jilid;
                    const isSpiral = data.kode_jilid.includes('spiral');
                    const badgeHtml = isSpiral ? ' <span class="badge-spiral">Spiral</span>' : '';

                    const newRow = document.createElement('tr');
                    newRow.innerHTML = `
                        <td><strong>${data.id_pesanan}</strong></td>
                        <td>${data.nama_jilid}${badgeHtml}</td>
                        <td>Rp ${data.biaya_per_jilid.toLocaleString('id-ID')}</td>
                        <td>${data.jumlah_copy} Copy</td>
                        <td><strong>${data.formatted_biaya}</strong></td>
                        <td><span style="color:#10b981; font-weight:600;">✓ Valid</span></td>
                    `;
                    document.getElementById('tableHistory').prepend(newRow);
                }
            } catch (jsonErr) {
                // Jika backend merespon selain JSON (seperti error HTML)
                responseContainer.textContent = "Error Output Server (Bukan JSON):\n" + text;
            }
        } catch (err) {
            responseContainer.textContent = 'Error: ' + err.message;
        }
    });
    </script>
</body>
</html>