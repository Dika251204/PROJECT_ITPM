<?php
// 05-Implementasi-Pilihan-Jenis-Print/index.php

require_once __DIR__ . '/config/db.php';
header("Content-Type: text/html; charset=UTF-8");

$layanan = [
    ['jenis_print' => 'hitam_putih', 'harga_per_halaman' => 500],
    ['jenis_print' => 'warna', 'harga_per_halaman' => 1000]
];

$kertas = [
    ['nama_kertas' => 'A4 70gr', 'harga_per_lembar' => 500],
    ['nama_kertas' => 'A4 80gr', 'harga_per_lembar' => 600],
    ['nama_kertas' => 'F4 70gr', 'harga_per_lembar' => 600],
    ['nama_kertas' => 'A3 80gr', 'harga_per_lembar' => 1200]
];

$jilid = [
    ['nama_jilid' => 'Tanpa Jilid', 'harga_jilid' => 0],
    ['nama_jilid' => 'Softcover', 'harga_jilid' => 15000],
    ['nama_jilid' => 'Hardcover', 'harga_jilid' => 30000],
    ['nama_jilid' => 'Mika / Lakban', 'harga_jilid' => 5000],
    ['nama_jilid' => 'Spiral Plastik', 'harga_jilid' => 10000]
];

$db = isset($conn) ? $conn : (isset($pdo) ? $pdo : null);$printHistory = [];

if ($db) {
    try {
        $stmt =$db->query("SELECT pj.*, u.nama FROM print_jilid pj JOIN users u ON pj.id_user = u.id_user ORDER BY pj.id_print DESC LIMIT 5");
        $printHistory =$stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {}
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>05. Implementasi Pilihan Jenis Print</title>
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; background:#fafafa; color: #333; margin: 0; padding: 20px; line-height: 1.5; }
        .container { max-width: 1100px; margin: 0 auto; }
        nav { background:#fff; padding: 10px 15px; border: 1px solid #e5e5e5; border-radius: 6px; margin-bottom: 20px; font-size: 12px; display: flex; gap: 8px; flex-wrap: wrap; }
        nav a { color:#666; text-decoration: none; padding: 4px 8px; border-radius: 4px; }
        nav a:hover, nav a.active { background:#e5e7eb; color:#000; font-weight: 600; }
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px; }
        .box { background:#fff; border: 1px solid #e5e5e5; border-radius: 6px; padding: 14px; margin-bottom: 20px; }
        h2 { font-size: 15px; margin: 0 0 10px 0; font-weight: 600; border-bottom: 1px solid #eee; padding-bottom: 6px; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border-bottom: 1px solid #eee; padding: 6px 8px; text-align: left; }
        th { background:#f9f9f9; color:#555; }
        tr.clickable { cursor: pointer; user-select: none; }
        tr.clickable:hover { background:#f5f5f5; }
        tr.selected { background:#e5e7eb !important; font-weight: 600; color:#1f2937; }
        .form-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-top: 10px; }
        label { font-size: 11px; color:#555; display: block; margin-bottom: 2px; }
        input, select { width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; font-size: 12px; box-sizing: border-box; }
        button { background:#4b5563; color:#fff; border: none; padding: 8px 12px; border-radius: 4px; font-size: 13px; cursor: pointer; width: 100%; margin-top: 12px; font-weight: 500; }
        button:hover { background:#374151; }
        pre { background:#f4f4f5; padding: 10px; border-radius: 4px; font-size: 11px; overflow-x: auto; white-space: pre-wrap; margin-top: 10px; }
        a { color: #374151; text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <!-- System Navigasi 15 Modul Resmi -->
        <nav>
            <a href="../01-Setup-Backend-Print-and-Jilid/">Setup Backend</a>
            <a href="../02-Implementasi-Database-Layanan-Print-and-Jilid/">Database</a>
            <a href="../03-Implementasi-Upload-File/">Upload File</a>
            <a href="../04-Implementasi-Validasi-File/">Validasi File</a>
            <a href="../05-Implementasi-Pilihan-Jenis-Print/" class="active">Jenis Print</a>
            <a href="../06-Implementasi-Pilihan-Ukuran-dan-Jenis-Kertas/">Kertas</a>
            <a href="../07-Implementasi-Pilihan-Warna-Cetak/">Warna Cetak</a>
            <a href="../08-Implementasi-Pilihan-Jumlah-Cetakan/">Jumlah Cetakan</a>
            <a href="../09-Implementasi-Pilihan-Jenis-Jilid/">Jenis Jilid</a>
            <a href="../10-Implementasi-Perhitungan-Harga/">Hitung Harga</a>
            <a href="../11-Implementasi-Pemesanan-Print-and-Jilid/">Pemesanan</a>
            <a href="../12-Implementasi-Manajemen-Pesanan-Print-and-Jilid/">Manajemen Pesanan</a>
            <a href="../13-Implementasi-Status-Pesanan/">Status Pesanan</a>
            <a href="../14-Implementasi-API-Print-and-Jilid/">API Print & Jilid</a>
        </nav>

        <!-- 3 Tabel Pilihan Interaktif -->
        <div class="grid-3">
            <div class="box">
                <h2>Pilih Jenis Print</h2>
                <table>
                    <thead><tr><th>Jenis</th><th>Harga/Hal</th></tr></thead>
                    <tbody>
                        <?php foreach ($layanan as $i =>$l): ?>
                            <tr class="clickable <?= $i === 0 ? 'selected' : '' ?>" data-type="print" data-val="<?= $l['jenis_print'] ?>" data-price="<?= $l['harga_per_halaman'] ?>">
                                <td><?= ucfirst(str_replace('_', ' ', $l['jenis_print'])) ?></td>
                                <td>Rp <?= number_format($l['harga_per_halaman'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="box">
                <h2>Pilih Jenis Kertas</h2>
                <table>
                    <thead><tr><th>Kertas</th><th>Harga/Lbr</th></tr></thead>
                    <tbody>
                        <?php foreach ($kertas as $i =>$k): ?>
                            <tr class="clickable <?= $i === 0 ? 'selected' : '' ?>" data-type="kertas" data-val="<?= $k['nama_kertas'] ?>" data-price="<?= $k['harga_per_lembar'] ?>">
                                <td><?= htmlspecialchars($k['nama_kertas']) ?></td>
                                <td>Rp <?= number_format($k['harga_per_lembar'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="box">
                <h2>Pilih Jenis Jilid</h2>
                <table>
                    <thead><tr><th>Jilid</th><th>Harga</th></tr></thead>
                    <tbody>
                        <?php foreach ($jilid as $i =>$j): ?>
                            <tr class="clickable <?= $i === 1 ? 'selected' : '' ?>" data-type="jilid" data-val="<?= $j['nama_jilid'] ?>" data-price="<?= $j['harga_jilid'] ?>">
                                <td><?= htmlspecialchars($j['nama_jilid']) ?></td>
                                <td>Rp <?= number_format($j['harga_jilid'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Form Pengujian Pilihan Jenis Print -->
        <div class="box">
            <h2>Form Simulator Pilihan Jenis Print</h2>
            <form id="printTypeForm">
                <input type="hidden" name="jenis_print" id="inputJenisPrint" value="hitam_putih">
                <input type="hidden" name="ukuran_kertas" id="inputUkuranKertas" value="A4 70gr">
                <input type="hidden" name="jenis_jilid" id="inputJenisJilid" value="Softcover">
                <input type="hidden" name="total_harga" id="inputTotalHarga" value="0">

                <div class="form-grid">
                    <div>
                        <label>Pilihan Jenis Print (Dropdown/Table)</label>
                        <select id="selectJenisPrint">
                            <option value="hitam_putih">Print Hitam Putih (Rp 500/hal)</option>
                            <option value="warna">Print Warna (Rp 1.000/hal)</option>
                            <option value="invalid_test">-- Opsi Tidak Valid (Test Error) --</option>
                        </select>
                    </div>
                    <div><label>ID User Pemesan</label><input type="number" name="id_user" value="2" required></div>
                    <div><label>Jumlah Halaman</label><input type="number" name="jumlah_halaman" id="numHal" value="10" min="1" required></div>
                    <div><label>Jumlah Copy</label><input type="number" name="jumlah_copy" id="numCopy" value="1" min="1" required></div>
                </div>

                <div style="margin-top: 10px; display: flex; justify-content: space-between; align-items: center;">
                    <div style="flex:1; margin-right: 10px;"><label>Catatan Cetak</label><input type="text" name="catatan" value="Pengujian Pilihan Jenis Print"></div>
                    <div><strong>Kalkulasi Biaya: <span id="totalDisplay" style="color:#1f2937;">Rp 0</span></strong></div>
                </div>

                <button type="submit">Simpan Pilihan Jenis Print</button>
            </form>

            <pre id="apiResponse">// Response JSON API Pilihan Print</pre>
        </div>

        <!-- Tabel Daftar Pilihan Tersimpan -->
        <div class="box">
            <h2>Daftar Pilihan Jenis Print Tersimpan (Database `print_jilid`)</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pemesan</th>
                        <th>Jenis Print</th>
                        <th>Kertas</th>
                        <th>Rincian Halaman</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($printHistory)): ?>
                        <tr><td colspan="7" style="text-align:center; color:#888;">Belum ada pilihan print tersimpan.</td></tr>
                    <?php else: ?>
                        <?php foreach ($printHistory as$row): ?>
                            <tr>
                                <td>#<?= $row['id_print'] ?></td>
                                <td><?= htmlspecialchars($row['nama']) ?></td>
                                <td><strong><?= $row['jenis_print'] === 'hitam_putih' ? 'Print Hitam Putih' : 'Print Warna' ?></strong></td>
                                <td><?= htmlspecialchars($row['ukuran_kertas']) ?></td>
                                <td><?= $row['jumlah_halaman'] ?> hal x <?=$row['jumlah_copy'] ?> copy</td>
                                <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                                <td><span style="color:#10b981; font-weight:600;">✓ Tersimpan</span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        let pPrice = 500, kPrice = 500, jPrice = 15000;

        // Sinkronisasi Klik Tabel dengan Input
        document.querySelectorAll('.clickable').forEach(r => {
            r.addEventListener('click', function() {
                const type = this.dataset.type;
                document.querySelectorAll(`.clickable[data-type="${type}"]`).forEach(el => el.classList.remove('selected'));
                this.classList.add('selected');

                if(type === 'print') { 
                    document.getElementById('inputJenisPrint').value = this.dataset.val; 
                    document.getElementById('selectJenisPrint').value = this.dataset.val;
                    pPrice = parseFloat(this.dataset.price); 
                }
                if(type === 'kertas') { document.getElementById('inputUkuranKertas').value = this.dataset.val; kPrice = parseFloat(this.dataset.price); }
                if(type === 'jilid') { document.getElementById('inputJenisJilid').value = this.dataset.val; jPrice = parseFloat(this.dataset.price); }
                calc();
            });
        });

        // Sinkronisasi Dropdown
        document.getElementById('selectJenisPrint').addEventListener('change', function() {
            const val = this.value;
            document.getElementById('inputJenisPrint').value = val;
            if (val === 'hitam_putih') pPrice = 500;
            else if (val === 'warna') pPrice = 1000;
            else pPrice = 0;

            document.querySelectorAll('.clickable[data-type="print"]').forEach(el => {
                if (el.dataset.val === val) el.classList.add('selected');
                else el.classList.remove('selected');
            });
            calc();
        });

        function calc() {
            const h = parseInt(document.getElementById('numHal').value) || 0;
            const c = parseInt(document.getElementById('numCopy').value) || 0;
            const total = ((pPrice + kPrice) * h * c) + jPrice;
            document.getElementById('inputTotalHarga').value = total;
            document.getElementById('totalDisplay').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        document.getElementById('numHal').addEventListener('input', calc);
        document.getElementById('numCopy').addEventListener('input', calc);
        calc();

        document.getElementById('printTypeForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const responseContainer = document.getElementById('apiResponse');

            try {
                const res = await fetch('process_print.php', { method: 'POST', body: formData });
                const text = await res.text();
                try {
                    const result = JSON.parse(text);
                    responseContainer.textContent = JSON.stringify(result, null, 2);
                    if (res.ok && result.status === 'success') {
                        alert(result.message);
                        location.reload();
                    }
                } catch (pErr) {
                    responseContainer.textContent = 'Output Non-JSON:\n' + text;
                }
            } catch (err) {
                responseContainer.textContent = 'Error: ' + err.message;
            }
        });
    </script>
</body>
</html>