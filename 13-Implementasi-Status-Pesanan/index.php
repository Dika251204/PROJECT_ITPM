<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>13. Implementasi Status Pesanan - Pusat Mercis UINMA</title>
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; background:#fafafa; color: #333; margin: 0; padding: 20px; line-height: 1.5; }
        .container { max-width: 1200px; margin: 0 auto; }
        nav { background:#fff; padding: 10px 15px; border: 1px solid #e5e5e5; border-radius: 6px; margin-bottom: 20px; font-size: 12px; display: flex; gap: 8px; flex-wrap: wrap; }
        nav a { color:#666; text-decoration: none; padding: 4px 8px; border-radius: 4px; }
        nav a:hover, nav a.active { background:#e5e7eb; color:#000; font-weight: 600; }
        
        .box { background:#fff; border: 1px solid #e5e5e5; border-radius: 6px; padding: 16px; margin-bottom: 20px; }
        h2 { font-size: 15px; margin: 0 0 12px 0; font-weight: 600; border-bottom: 1px solid #eee; padding-bottom: 6px; }

        /* Step Progress Tracking Bar */
        .step-container { display: flex; justify-content: space-between; position: relative; margin: 20px 0; padding: 0 10px; }
        .step-container::before { content: ''; position: absolute; top: 14px; left: 30px; right: 30px; height: 3px; background: #e5e7eb; z-index: 1; }
        .step-item { position: relative; z-index: 2; background: #fff; padding: 0 5px; text-align: center; }
        .step-circle { width: 30px; height: 30px; border-radius: 50%; background: #e5e7eb; color: #666; display: flex; align-items: center; justify-content: center; margin: 0 auto 5px; font-weight: bold; font-size: 12px; }
        .step-title { font-size: 11px; color: #666; font-weight: 500; }
        
        .step-item.active .step-circle { background: #2563eb; color: #fff; }
        .step-item.active .step-title { color: #2563eb; font-weight: bold; }
        .step-item.completed .step-circle { background: #10b981; color: #fff; }

        /* Table Styling */
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border-bottom: 1px solid #eee; padding: 10px 8px; text-align: left; vertical-align: middle; }
        th { background:#f9f9f9; color:#555; font-weight: 600; }

        /* Status Badges */
        .badge { display: inline-block; padding: 3px 8px; border-radius: 4px; font-size: 10px; font-weight: 600; }
        .badge-menunggu  { background:#fef3c7; color:#92400e; }
        .badge-diproses  { background:#dbeafe; color:#1e40af; }
        .badge-dicetak   { background:#e0e7ff; color:#3730a3; }
        .badge-dijilid   { background:#fae8ff; color:#86198f; }
        .badge-selesai   { background:#d1fae5; color:#065f46; }
        .badge-dibatalkan{ background:#fee2e2; color:#991b1b; }

        select.select-status { padding: 4px 6px; font-size: 11px; border-radius: 4px; border: 1px solid #ccc; }
        button.btn-save { background:#1e293b; color:#fff; border:none; padding: 5px 12px; border-radius: 4px; font-size: 11px; cursor: pointer; font-weight:600; }
        button.btn-save:hover { background:#0f172a; }

        .info-card { background: #eff6ff; border: 1px solid #bfdbfe; padding: 12px; border-radius: 6px; font-size: 12px; margin-bottom: 15px; color: #1e40af; }
        pre { background:#f4f4f5; padding: 12px; border-radius: 4px; font-size: 11px; overflow-x: auto; white-space: pre-wrap; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Navigasi Modul Proyek -->
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
            <a href="../12-Implementasi-Manajemen-Pesanan-Print-and-Jilid/">Manajemen Pesanan</a>
            <a href="../13-Implementasi-Status-Pesanan/" class="active">Status Pesanan</a>
            <a href="../14-Implementasi-API-Print-and-Jilid/">API Print & Jilid</a>
        </nav>

        <div class="info-card">
             <strong>Fitur Manajemen Status Pesanan:</strong><br>
            Merupakan sistem pemantauan alur pengerjaan dari pesanan diterima hingga selesai[cite: 16].
        </div>

        <!-- Alur Tahapan Status Pesanan (Checklist Visualization) -->
        <div class="box">
            <h2>Alur Pengerjaan Pesanan (Status Workflow)</h2>
            <div class="step-container">
                <div class="step-item completed">
                    <div class="step-circle">1</div>
                    <div class="step-title">Menunggu</div>
                </div>
                <div class="step-item active">
                    <div class="step-circle">2</div>
                    <div class="step-title">Diproses</div>
                </div>
                <div class="step-item">
                    <div class="step-circle">3</div>
                    <div class="step-title">Dicetak</div>
                </div>
                <div class="step-item">
                    <div class="step-circle">4</div>
                    <div class="step-title">Dijilid</div>
                </div>
                <div class="step-item">
                    <div class="step-circle">5</div>
                    <div class="step-title">Selesai</div>
                </div>
            </div>
        </div>

        <!-- Tabel Monitoring dan Update Status -->
        <div class="box">
            <h2>Daftar Monitoring & Fitur Update Status Pesanan</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Pelanggan</th>
                        <th>File / Dokumen</th>
                        <th>Status Saat Ini</th>
                        <th>Aksi Update Status</th>
                    </tr>
                </thead>
                <tbody id="tableStatusBody">
                    <tr><td colspan="5" style="text-align:center;">Memuat data pesanan...</td></tr>
                </tbody>
            </table>

            <pre id="jsonPreview">// Output Log Perubahan Status (POST update_status.php)</pre>
        </div>
    </div>

    <script>
        // Memuat data pesanan langsung dari API Modul 12
        async function fetchPesananData() {
            const tbody = document.getElementById('tableStatusBody');
            try {
                const res = await fetch('../12-Implementasi-Manajemen-Pesanan-Print-and-Jilid/get_daftar_pesanan.php');
                const result = await res.json();

                if (result.status === 'success') {
                    tbody.innerHTML = '';
                    result.data.forEach(item => {
                        const tr = document.createElement('tr');
                        const currentStatus = item.status_pesanan || 'Menunggu Konfirmasi';
                        
                        tr.innerHTML = `
                            <td>
                                <strong>${item.id_pesanan}</strong><br>
                                <small style="color:#666;">${item.tanggal_pesan}</small>
                            </td>
                            <td>
                                <strong>${item.pelanggan.nama_pemesan}</strong><br>
                                <small style="color:#888;">ID User: ${item.pelanggan.id_user}</small>
                            </td>
                            <td>
                                 <a href="../12-Implementasi-Manajemen-Pesanan-Print-and-Jilid/${item.file_pesanan.url_file}" target="_blank" style="color:#2563eb; text-decoration:none; font-weight:500;">
                                    ${item.file_pesanan.nama_file}
                                </a>
                            </td>
                            <td>
                                <span class="badge ${getBadgeClass(currentStatus)}">${currentStatus}</span>
                            </td>
                            <td>
                                <div style="display:flex; gap:6px;">
                                    <select class="select-status" id="select-${item.id_pesanan}">
                                        <option value="Menunggu Konfirmasi" ${currentStatus === 'Menunggu Konfirmasi' ? 'selected' : ''}>Menunggu</option>
                                        <option value="Diproses" ${currentStatus === 'Diproses' ? 'selected' : ''}>Diproses</option>
                                        <option value="Dicetak" ${currentStatus === 'Dicetak' ? 'selected' : ''}>Dicetak</option>
                                        <option value="Dijilid" ${currentStatus === 'Dijilid' ? 'selected' : ''}>Dijilid</option>
                                        <option value="Selesai" ${currentStatus === 'Selesai' ? 'selected' : ''}>Selesai</option>
                                        <option value="Dibatalkan" ${currentStatus === 'Dibatalkan' ? 'selected' : ''}>Dibatalkan</option>
                                    </select>
                                    <button class="btn-save" onclick="simpanStatus('${item.id_pesanan}')">Update</button>
                                </div>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                }
            } catch (err) {
                tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; color:red;">Gagal terhubung dengan backend pesanan.</td></tr>';
            }
        }

        // Fungsi AJAX/Fetch untuk menyimpan perubahan status
        async function simpanStatus(idPesanan) {
            const selectEl = document.getElementById(`select-${idPesanan}`);
            const statusBaru = selectEl.value;
            const preview = document.getElementById('jsonPreview');

            try {
                const res = await fetch('update_status.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        id_pesanan: idPesanan,
                        status_pesanan: statusBaru,
                        catatan_admin: 'Perubahan status dilakukan dari Dashboard Status Pesanan'
                    })
                });

                const result = await res.json();
                preview.textContent = JSON.stringify(result, null, 2);

                if (result.status === 'success') {
                    alert(`✅ Status pesanan ${idPesanan} berhasil diperbarui menjadi: ${statusBaru}`);
                    fetchPesananData(); // Refresh tampilan
                } else {
                    alert('❌ Gagal memperbarui status: ' + result.message);
                }
            } catch (err) {
                preview.textContent = 'Error Request: ' + err.message;
            }
        }

        function getBadgeClass(status) {
            switch(status) {
                case 'Menunggu Konfirmasi': return 'badge-menunggu';
                case 'Diproses': return 'badge-diproses';
                case 'Dicetak': return 'badge-dicetak';
                case 'Dijilid': return 'badge-dijilid';
                case 'Selesai': return 'badge-selesai';
                case 'Dibatalkan': return 'badge-dibatalkan';
                default: return 'badge-menunggu';
            }
        }

        window.addEventListener('DOMContentLoaded', fetchPesananData);
    </script>
</body>
</html>