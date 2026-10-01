<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>10. Implementasi Perhitungan Harga</title>
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
        .info-card { background:#f9fafb; border: 1px dashed #d1d5db; padding: 12px; border-radius: 6px; margin-top: 15px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }
        button { background:#4b5563; color:#fff; border: none; padding: 10px 12px; border-radius: 4px; font-size: 13px; cursor: pointer; width: 100%; margin-top: 15px; font-weight: 600; }
        button:hover { background:#374151; }
        pre { background:#f4f4f5; padding: 12px; border-radius: 4px; font-size: 11px; overflow-x: auto; white-space: pre-wrap; margin-top: 12px; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border-bottom: 1px solid #eee; padding: 8px; text-align: left; }
        th { background:#f9f9f9; color:#555; }
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
            <a href="../09-Implementasi-Pilihan-Jenis-Jilid/">Jenis Jilid</a>
            <a href="../10-Implementasi-Perhitungan-Harga/" class="active">Hitung Harga</a>
            <a href="../11-Implementasi-Pemesanan-Print-and-Jilid/">Pemesanan</a>
            <a href="../12-Implementasi-Manajemen-Pesanan-Print-and-Jilid/">Manajemen Pesanan</a>
            <a href="../13-Implementasi-Status-Pesanan/">Status Pesanan</a>
            <a href="../14-Implementasi-API-Print-and-Jilid/">API Print & Jilid</a>
        </nav>

        <!-- Form Pengujian Kalkulasi Perhitungan Harga -->
        <div class="box">
            <h2>Form Pengujian Sistem Perhitungan Harga Otomatis</h2>
            <form id="hitungForm">
                <div class="form-grid">
                    <div>
                        <label>ID Pesanan</label>
                        <input type="text" name="id_pesanan" value="ORD-9912" required>
                    </div>
                    <div>
                        <label>Jenis Print</label>
                        <select name="jenis_print" id="jPrint">
                            <option value="dokumen">Print Dokumen Standard (+Rp 300)</option>
                            <option value="foto">Print Foto HQ (+Rp 2.000)</option>
                            <option value="brosur">Print Brosur / Flier (+Rp 1.000)</option>
                        </select>
                    </div>
                    <div>
                        <label>Ukuran & Jenis Kertas</label>
                        <select name="ukuran_kertas" id="jKertas">
                            <option value="A4_70">A4 70gr (+Rp 200)</option>
                            <option value="A4_80">A4 80gr (+Rp 300)</option>
                            <option value="F4_70">F4/Folio 70gr (+Rp 250)</option>
                            <option value="A3_80">A3 80gr (+Rp 600)</option>
                            <option value="Glossy">Photo Glossy 210gr (+Rp 2.500)</option>
                        </select>
                    </div>
                    <div>
                        <label>Warna Cetak</label>
                        <select name="jenis_warna" id="jWarna">
                            <option value="hitam_putih">Hitam Putih (+Rp 300)</option>
                            <option value="warna_sedikit">Warna Teks/Diagram (+Rp 600)</option>
                            <option value="warna_full" selected>Full Color (+Rp 1.200)</option>
                        </select>
                    </div>
                    <div>
                        <label>Jumlah Halaman</label>
                        <input type="number" name="jumlah_halaman" id="numHal" value="20" min="1" required>
                    </div>
                    <div>
                        <label>Jumlah Salinan (Copy)</label>
                        <input type="number" name="jumlah_copy" id="numCopy" value="3" min="1" required>
                    </div>
                    <div style="grid-column: span 3;">
                        <label>Jenis Jilid</label>
                        <select name="jenis_jilid" id="jJilid">
                            <option value="tanpa_jilid">Tanpa Jilid (Rp 0)</option>
                            <option value="jilid_lakban">Jilid Lakban Biasa (Rp 5.000)</option>
                            <option value="jilid_spiral_kawat">Jilid Spiral Kawat (Rp 12.000)</option>
                            <option value="jilid_spiral_plastik">Jilid Spiral Plastik (Rp 10.000)</option>
                            <option value="jilid_softcover" selected>Jilid Softcover (Rp 15.000)</option>
                            <option value="jilid_hardcover">Jilid Hardcover / Skripsi (Rp 30.000)</option>
                        </select>
                    </div>
                </div>

                <div class="info-card">
                    <div>
                        <strong>Biaya Cetak per Halaman:</strong> <span id="perHalDisplay" style="color:#2563eb;">Rp 1.700</span>
                    </div>
                    <div>
                        <strong>Subtotal Cetak (60 Hal):</strong> <span id="subCetakDisplay" style="color:#2563eb;">Rp 102.000</span>
                    </div>
                    <div>
                        <strong>Subtotal Jilid (3 Copy):</strong> <span id="subJilidDisplay" style="color:#2563eb;">Rp 45.000</span>
                    </div>
                    <div>
                        <strong>TOTAL BIAYA:</strong> <span id="grandTotalDisplay" style="color:#059669; font-weight:bold; font-size:18px;">Rp 147.000</span>
                    </div>
                </div>

                <button type="submit">Uji Kalkulasi Perhitungan Harga</button>
            </form>

            <pre id="apiResponse">// Response JSON API Perhitungan Harga</pre>
        </div>

        <!-- Tabel Riwayat Pengujian Kombinasi -->
        <div class="box">
            <h2>Daftar Pengujian Kombinasi Layanan & Perhitungan Harga</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Kombinasi Layanan</th>
                        <th>Total Lembar</th>
                        <th>Subtotal Cetak</th>
                        <th>Subtotal Jilid</th>
                        <th>Total Biaya</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="tableHistory">
                    <tr id="emptyRow"><td colspan="7" style="text-align:center; color:#888;">Belum ada pengujian kalkulasi. Klik tombol di atas untuk menguji!</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const pPrint  = { 'dokumen': 300, 'foto': 2000, 'brosur': 1000 };
        const pKertas = { 'A4_70': 200, 'A4_80': 300, 'F4_70': 250, 'A3_80': 600, 'Glossy': 2500 };
        const pWarna  = { 'hitam_putih': 300, 'warna_sedikit': 600, 'warna_full': 1200 };
        const pJilid  = { 'tanpa_jilid': 0, 'jilid_lakban': 5000, 'jilid_spiral_kawat': 12000, 'jilid_spiral_plastik': 10000, 'jilid_softcover': 15000, 'jilid_hardcover': 30000 };

        function calcLive() {
            const printVal  = pPrint[document.getElementById('jPrint').value] || 0;
            const kertasVal = pKertas[document.getElementById('jKertas').value] || 0;
            const warnaVal  = pWarna[document.getElementById('jWarna').value] || 0;
            const jilidVal  = pJilid[document.getElementById('jJilid').value] || 0;
            
            const hal  = parseInt(document.getElementById('numHal').value) || 1;
            const copy = parseInt(document.getElementById('numCopy').value) || 1;

            const costPerHal = printVal + kertasVal + warnaVal;
            const totalLembar = hal * copy;
            const subCetak = costPerHal * totalLembar;
            const subJilid = jilidVal * copy;
            const total = subCetak + subJilid;

            document.getElementById('perHalDisplay').textContent = 'Rp ' + costPerHal.toLocaleString('id-ID');
            document.getElementById('subCetakDisplay').textContent = 'Rp ' + subCetak.toLocaleString('id-ID');
            document.getElementById('subJilidDisplay').textContent = 'Rp ' + subJilid.toLocaleString('id-ID');
            document.getElementById('grandTotalDisplay').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        ['jPrint', 'jKertas', 'jWarna', 'jJilid', 'numHal', 'numCopy'].forEach(id => {
            document.getElementById(id).addEventListener('change', calcLive);
            document.getElementById(id).addEventListener('input', calcLive);
        });
        calcLive();

        document.getElementById('hitungForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const responseContainer = document.getElementById('apiResponse');

            try {
                const res = await fetch('process_hitung.php', { method: 'POST', body: formData });
                const text = await res.text();
                
                try {
                    const result = JSON.parse(text);
                    responseContainer.textContent = JSON.stringify(result, null, 2);

                    if (result.status === 'success') {
                        const emptyRow = document.getElementById('emptyRow');
                        if (emptyRow) emptyRow.remove();

                        const r = result.rincian_pesanan;
                        const k = r.kombinasi_layanan;
                        const b = r.kalkulasi_biaya;

                        const newRow = document.createElement('tr');
                        newRow.innerHTML = `
                            <td><strong>${r.id_pesanan}</strong></td>
                            <td style="font-size:11px;">${k.jenis_print} | ${k.ukuran_kertas} | ${k.jenis_warna} | ${k.jenis_jilid}</td>
                            <td>${b.total_lembar_cetak}</td>
                            <td>${b.subtotal_cetak}</td>
                            <td>${b.subtotal_jilid}</td>
                            <td><strong style="color:#059669;">${b.grand_total_biaya}</strong></td>
                            <td><span style="color:#10b981; font-weight:600;">✓ Valid</span></td>
                        `;
                        document.getElementById('tableHistory').prepend(newRow);
                    }
                } catch (jsonErr) {
                    responseContainer.textContent = "Error Output Server (Bukan JSON):\n" + text;
                }
            } catch (err) {
                responseContainer.textContent = 'Error: ' + err.message;
            }
        });
    </script>
</body>
</html>