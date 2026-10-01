<?php

require_once __DIR__ . '/config/db.php';
header("Content-Type: text/html; charset=UTF-8");

$layanan = [
    ['jenis_print' => 'hitam_putih', 'label' => 'Hitam Putih (B/W)', 'harga_per_halaman' => 500],
    ['jenis_print' => 'warna', 'label' => 'Warna Full / Partial', 'harga_per_halaman' => 1000]
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
    ['nama_jilid' => 'Hardcover', 'harga_jilid' => 30000]
];

$db = isset($conn) ? $conn : (isset($pdo) ? $pdo : null);$warnaHistory = [];

if ($db) {
    try {
        $stmt =$db->query("SELECT pj.*, u.nama FROM print_jilid pj JOIN users u ON pj.id_user = u.id_user ORDER BY pj.id_print DESC LIMIT 5");
        $warnaHistory =$stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {}
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>08. Implementasi Pilihan Jumlah Cetakan</title>
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; background:#fafafa; color: #333; margin: 0; padding: 20px; line-height: 1.5; }
        .container { max-width: 1100px; margin: 0 auto; }
        nav { background:#fff; padding: 10px 15px; border: 1px solid #e5e5e5; border-radius: 6px; margin-bottom: 20px; font-size: 12px; display: flex; gap: 8px; flex-wrap: wrap; }
        nav a { color:#666; text-decoration: none; padding: 4px 8px; border-radius: 4px; }
        nav a:hover, nav a.active { background:#e5e7eb; color:#000; font-weight: 600; }
        .box { background:#fff; border: 1px solid #e5e5e5; border-radius: 6px; padding: 16px; margin-bottom: 20px; }
        h2 { font-size: 15px; margin: 0 0 12px 0; font-weight: 600; border-bottom: 1px solid #eee; padding-bottom: 6px; }
        .form-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
        label { font-size: 11px; color:#555; display: block; margin-bottom: 4px; font-weight: 500; }
        input, select { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; box-sizing: border-box; }
        .info-card { background:#f9fafb; border: 1px dashed #d1d5db; padding: 12px; border-radius: 6px; margin-top: 15px; display: flex; justify-content: space-between; align-items: center; }
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
            <a href="../08-Implementasi-Pilihan-Jumlah-Cetakan/" class="active">Jumlah Cetakan</a>
            <a href="../09-Implementasi-Pilihan-Jenis-Jilid/">Jenis Jilid</a>
            <a href="../10-Implementasi-Perhitungan-Harga/">Hitung Harga</a>
            <a href="../11-Implementasi-Pemesanan-Print-and-Jilid/">Pemesanan</a>
            <a href="../12-Implementasi-Manajemen-Pesanan-Print-and-Jilid/">Manajemen Pesanan</a>
            <a href="../13-Implementasi-Status-Pesanan/">Status Pesanan</a>
            <a href="../14-Implementasi-API-Print-and-Jilid/">API Print & Jilid</a>
        </nav>

        <!-- Form Pengujian Jumlah Cetakan -->
        <div class="box">
            <h2>Form Pengujian Pilihan Jumlah Cetakan</h2>
            <form id="jumlahForm">
                <div class="form-grid">
                    <div>
                        <label>Jumlah Halaman (Min: 1, Max: 1000)</label>
                        <input type="number" name="jumlah_halaman" id="numHal" value="15" required>
                    </div>
                    <div>
                        <label>Jumlah Salinan / Copy (Min: 1, Max: 500)</label>
                        <input type="number" name="jumlah_copy" id="numCopy" value="2" required>
                    </div>
                    <div>
                        <label>Jenis Warna Cetak</label>
                        <select name="jenis_print" id="selectWarna">
                            <option value="warna" selected>Warna Full (Rp 1.000/hal)</option>
                            <option value="hitam_putih">Hitam Putih (Rp 500/hal)</option>
                        </select>
                    </div>
                    <div>
                        <label>ID User Pemesan</label>
                        <input type="number" name="id_user" value="2" required>
                    </div>
                </div>

                <div class="info-card">
                    <div>
                        <strong>Total Lembar Dicetak:</strong> <span id="totalLembarDisplay" style="color:#2563eb; font-weight:bold;">30 Lembar</span>
                        <div style="font-size:11px; color:#6b7280;">(15 Halaman × 2 Copy)</div>
                    </div>
                    <div>
                        <strong>Kalkulasi Total Biaya Cetak:</strong> <span id="totalBiayaDisplay" style="color:#059669; font-weight:bold; font-size:16px;">Rp 45.000</span>
                    </div>
                </div>

                <button type="submit">Uji Pengolahan Jumlah Cetakan (POST ke process_jumlah.php)</button>
            </form>

            <pre id="apiResponse">// Response JSON API Pengujian Jumlah Cetakan</pre>
        </div>

        <!-- Tabel Riwayat Pengujian -->
        <div class="box">
            <h2>Daftar Pengujian Jumlah Cetakan</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Jumlah Halaman</th>
                        <th>Jumlah Salinan</th>
                        <th>Total Lembar</th>
                        <th>Perhitungan Harga</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="tableHistory">
                    <tr id="emptyRow"><td colspan="7" style="text-align:center; color:#888;">Belum ada pengujian jumlah cetakan. Klik tombol di atas untuk menguji!</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        let idCounter = 1;

        function calc() {
            const hal = parseInt(document.getElementById('numHal').value) || 0;
            const copy = parseInt(document.getElementById('numCopy').value) || 0;
            const warna = document.getElementById('selectWarna').value;
            const hargaWarna = (warna === 'warna') ? 1000 : 500;
            const hargaKertas = 500;

            const totalLembar = hal * copy;
            const totalBiaya = totalLembar * (hargaWarna + hargaKertas);

            document.getElementById('totalLembarDisplay').textContent = totalLembar + ' Lembar';
            document.getElementById('totalBiayaDisplay').textContent = 'Rp ' + totalBiaya.toLocaleString('id-ID');
        }

        document.getElementById('numHal').addEventListener('input', calc);
        document.getElementById('numCopy').addEventListener('input', calc);
        document.getElementById('selectWarna').addEventListener('change', calc);
        calc();

        document.getElementById('jumlahForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const responseContainer = document.getElementById('apiResponse');

            try {
                const res = await fetch('process_jumlah.php', { method: 'POST', body: formData });
                const result = await res.json();
                responseContainer.textContent = JSON.stringify(result, null, 2);

                if (result.status === 'success') {
                    const emptyRow = document.getElementById('emptyRow');
                    if (emptyRow) emptyRow.remove();

                    const data = result.data_cetakan;
                    const newRow = document.createElement('tr');
                    newRow.innerHTML = `
                        <td>#${idCounter++}</td>
                        <td>User #${data.id_user}</td>
                        <td>${data.jumlah_halaman} Halaman</td>
                        <td>${data.jumlah_copy} Copy</td>
                        <td><strong>${data.total_lembar_cetak} Lembar</strong></td>
                        <td>${data.rincian_biaya.total_keseluruhan}</td>
                        <td><span style="color:#10b981; font-weight:600;">✓ Valid</span></td>
                    `;
                    document.getElementById('tableHistory').prepend(newRow);
                }
            } catch (err) {
                responseContainer.textContent = 'Error: ' + err.message;
            }
        });
    </script>
</body>
</html>