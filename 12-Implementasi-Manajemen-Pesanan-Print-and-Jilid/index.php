<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>12. Manajemen & Riwayat Pesanan - Pusat Mercis UINMA</title>
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; background:#fafafa; color: #333; margin: 0; padding: 20px; line-height: 1.5; }
        .container { max-width: 1200px; margin: 0 auto; }
        nav { background:#fff; padding: 10px 15px; border: 1px solid #e5e5e5; border-radius: 6px; margin-bottom: 20px; font-size: 12px; display: flex; gap: 8px; flex-wrap: wrap; }
        nav a { color:#666; text-decoration: none; padding: 4px 8px; border-radius: 4px; }
        nav a:hover, nav a.active { background:#e5e7eb; color:#000; font-weight: 600; }
        .box { background:#fff; border: 1px solid #e5e5e5; border-radius: 6px; padding: 16px; margin-bottom: 20px; }
        h2 { font-size: 15px; margin: 0 0 12px 0; font-weight: 600; border-bottom: 1px solid #eee; padding-bottom: 6px; }
        
        .filter-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr auto; gap: 10px; margin-bottom: 15px; }
        label { font-size: 11px; color:#555; display: block; margin-bottom: 4px; font-weight: 500; }
        input, select { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; box-sizing: border-box; }
        button { background:#1e293b; color:#fff; border: none; padding: 8px 16px; border-radius: 4px; font-size: 13px; cursor: pointer; font-weight: 600; height: 36px; align-self: end; }
        button:hover { background:#0f172a; }
        
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border-bottom: 1px solid #eee; padding: 10px 8px; text-align: left; vertical-align: top; }
        th { background:#f9f9f9; color:#555; font-weight: 600; }
        .badge { display: inline-block; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: 600; }
        .badge-pending { background:#fef3c7; color:#92400e; }
        .badge-process { background:#dbeafe; color:#1e40af; }
        .badge-success { background:#d1fae5; color:#065f46; }
        
        .info-card { background: #eff6ff; border: 1px solid #bfdbfe; padding: 10px; border-radius: 6px; font-size: 12px; margin-bottom: 15px; color: #1e40af; }
        pre { background:#f4f4f5; padding: 12px; border-radius: 4px; font-size: 11px; overflow-x: auto; white-space: pre-wrap; margin-top: 15px; }
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
            <a href="../08-Implementasi-Pilihan-Jumlah-Cetakan/">Jumlah Cetakan</a>
            <a href="../09-Implementasi-Pilihan-Jenis-Jilid/">Jenis Jilid</a>
            <a href="../10-Implementasi-Perhitungan-Harga/">Hitung Harga</a>
            <a href="../11-Implementasi-Pemesanan-Print-and-Jilid/">Pemesanan</a>
            <a href="../12-Implementasi-Manajemen-Pesanan-Print-and-Jilid/" class="active">Manajemen Pesanan</a>
            <a href="../13-Implementasi-Status-Pesanan/">Status Pesanan</a>
            <a href="../14-Implementasi-API-Print-and-Jilid/">API Print & Jilid</a>
        </nav>

        <div class="info-card">
             <strong>Panduan Sistem:</strong><br>
             Masukkan **ID User Saya** (contoh: isi <code>1</code>) di kolom bawah untuk memfilter **Riwayat Pesanan Pelanggan**[cite: 14].<br>
             Klik nama file untuk mengunduh/membuka dokumen pesanan secara langsung[cite: 14].
        </div>

        <!-- Filter Controls -->
        <div class="box">
            <h2>Dashboard Manajemen Pesanan Admin & Riwayat Pelanggan</h2>
            <div class="filter-grid">
                <div>
                    <label>Pencarian Pesanan</label>
                    <input type="text" id="searchInput" placeholder="Cari ID Pesanan, Nama, File...">
                </div>
                <div>
                    <label>Filter Status</label>
                    <select id="statusFilter">
                        <option value="">Semua Status</option>
                        <option value="Menunggu Konfirmasi">Menunggu Konfirmasi</option>
                        <option value="Diproses">Diproses</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>
                <div>
                    <label>Filter Jenis Jilid</label>
                    <select id="jilidFilter">
                        <option value="">Semua Jilid</option>
                        <option value="tanpa_jilid">Tanpa Jilid</option>
                        <option value="jilid_lakban">Jilid Lakban</option>
                        <option value="jilid_spiral_kawat">Jilid Spiral Kawat</option>
                        <option value="jilid_softcover">Jilid Softcover</option>
                        <option value="jilid_hardcover">Jilid Hardcover</option>
                    </select>
                </div>
                <div>
                    <label>ID User (Riwayat Saya)</label>
                    <input type="number" id="userInput" placeholder="Contoh: 1">
                </div>
                <button onclick="loadPesanan()">Cari / Filter</button>
            </div>
        </div>

        <!-- Tabel Pesanan -->
        <div class="box">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <h2 style="border:none; margin:0;" id="tableTitle">Daftar Pesanan</h2>
                <span id="dataInfo" style="font-size: 12px; color: #666;">Memuat data...</span>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID Pesanan & Tanggal</th>
                        <th>Data Pelanggan</th>
                        <th>File Pesanan</th>
                        <th>Detail Layanan</th>
                        <th>Jumlah</th>
                        <th>Total Biaya</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="pesananTableBody">
                    <tr><td colspan="7" style="text-align:center;">Memuat data pesanan...</td></tr>
                </tbody>
            </table>

            <pre id="jsonPreview">// JSON Response (GET get_daftar_pesanan.php)</pre>
        </div>
    </div>

    <script>
        async function loadPesanan() {
            const search = document.getElementById('searchInput').value;
            const status = document.getElementById('statusFilter').value;
            const jilid  = document.getElementById('jilidFilter').value;
            const userId = document.getElementById('userInput').value;

            const params = new URLSearchParams();
            if (search) params.append('search', search);
            if (status) params.append('status', status);
            if (jilid)  params.append('jilid', jilid);
            if (userId) params.append('id_user', userId);

            const tbody = document.getElementById('pesananTableBody');
            const preview = document.getElementById('jsonPreview');
            const dataInfo = document.getElementById('dataInfo');
            const tableTitle = document.getElementById('tableTitle');

            if (userId) {
                tableTitle.textContent = `Riwayat Pesanan Saya (ID User: ${userId})`;
            } else {
                tableTitle.textContent = "Daftar Seluruh Pesanan (Admin)";
            }

            try {
                const res = await fetch('get_daftar_pesanan.php?' + params.toString());
                const textRaw = await res.text();

                try {
                    const result = JSON.parse(textRaw);
                    preview.textContent = JSON.stringify(result, null, 2);

                    if (result.status === 'success') {
                        dataInfo.textContent = `Total: ${result.total_data} Pesanan | ${result.database_status}`;
                        tbody.innerHTML = '';

                        if (result.data.length === 0) {
                            tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; color:#888; padding: 20px;">Tidak ada pesanan yang ditemukan.</td></tr>';
                            return;
                        }

                        result.data.forEach(item => {
                            let badgeClass = 'badge-pending';
                            if (item.status_pesanan === 'Diproses') badgeClass = 'badge-process';
                            if (item.status_pesanan === 'Selesai') badgeClass = 'badge-success';

                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td>
                                    <strong style="color:#1e293b;">${item.id_pesanan}</strong><br>
                                    <span style="font-size:10px; color:#666;">${item.tanggal_pesan}</span>
                                </td>
                                <td>
                                    <strong>${item.pelanggan.nama_pemesan}</strong><br>
                                    <span style="font-size:10px; color:#888;">ID User: ${item.pelanggan.id_user}</span>
                                </td>
                                <td>
                                    <a href="${item.file_pesanan.url_file}" 
                                       target="_blank" 
                                       download="${item.file_pesanan.nama_file}"
                                       style="color:#2563eb; font-weight:500; text-decoration:none;">
                                        📄 ${item.file_pesanan.nama_file}
                                    </a>
                                </td>
                                <td>
                                    <div style="font-size:11px;">
                                        • ${item.detail_layanan.jenis_print}<br>
                                        • ${item.detail_layanan.ukuran_kertas} (${item.detail_layanan.jenis_warna})<br>
                                        • <strong>${item.detail_layanan.jenis_jilid}</strong>
                                    </div>
                                </td>
                                <td>
                                    ${item.detail_jumlah.jumlah_halaman} Hal x ${item.detail_jumlah.jumlah_copy} Copy<br>
                                    <small style="color:#666;">(${item.detail_jumlah.total_lembar} Lembar)</small>
                                </td>
                                <td>
                                    <strong style="color:#059669;">${item.rincian_harga.grand_total}</strong><br>
                                    <small style="font-size:10px; color:#888;">Cetak: ${item.rincian_harga.subtotal_cetak} | Jilid: ${item.rincian_harga.subtotal_jilid}</small>
                                </td>
                                <td>
                                    <span class="badge ${badgeClass}">${item.status_pesanan}</span>
                                </td>
                            `;
                            tbody.appendChild(tr);
                        });
                    }
                } catch (jsonErr) {
                    preview.textContent = "Error Parsing JSON!\n\nOutput PHP Mentah:\n" + textRaw;
                    tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; color:red; padding: 15px;">Terjadi Error saat membaca response API. Silakan periksa output mentah di bawah.</td></tr>';
                }
            } catch (err) {
                preview.textContent = 'Error Fetch: ' + err.message;
            }
        }

        window.addEventListener('DOMContentLoaded', loadPesanan);
    </script>
</body>
</html>