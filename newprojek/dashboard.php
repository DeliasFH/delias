<?php
// File ini adalah halaman dashboard, dipindahkan dari index.php
include 'config/koneksi.php';

$keyword = isset($_GET['cari']) ? $_GET['cari'] : '';
$query = $keyword != ''
    ? "SELECT * FROM siswa WHERE nama LIKE '%$keyword%' OR nis LIKE '%$keyword%' ORDER BY nama ASC"
    : "SELECT * FROM siswa ORDER BY nama ASC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>DATA SISWA XII TKJ 2</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">
    <!-- Import Montserrat font for modern title -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background: linear-gradient(135deg, #4b1d1d 0%, #6d2932 100%);
            color: #fff;
            min-height: 100vh;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #6d2932;
            padding: 20px 40px;
            border-bottom: 3px solid #561c24;
            position: relative;
        }

        .navbar-title {
            text-align: center;
            flex-grow: 1;
        }

        .navbar-action {
            display: flex;
            align-items: center;
        }

        .navbar h2 {
            margin: 0;
            font-weight: 700;
            font-size: 1.6em;
        }

        .menu-icon {
            font-size: 1.8em;
            cursor: pointer;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 70px;
            left: 20px;
            background: #561c24;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 999;
        }

        .dropdown-menu a {
            display: block;
            padding: 12px 20px;
            color: #fff;
            text-decoration: none;
            transition: background 0.3s;
        }

        .dropdown-menu a:hover {
            background: #4b1d1d;
        }

        .add-button {
            background: #fff;
            color: #6d2932;
            border: none;
            padding: 10px 20px;
            border-radius: 24px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .add-button:hover {
            background: #ccc;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            background: #fff;
            color: #222;
            border-radius: 14px;
            padding: 30px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.1);
        }

        .datasiswa-title {
            font-family: times-new-roman;
            font-size: 2.5em;
            color: #561c24;
            text-align: center;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-shadow: 0 2px 8px rgba(109, 41, 50, 0.08);
            margin: 0;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1.2s cubic-bezier(0.23, 1, 0.32, 1) 0.2s forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Updated table styles for DataTables */
        .siswa-table {
            width: 100% !important;
            border-collapse: separate !important;
            border-spacing: 0;
            margin-top: 20px;
            border: 1px solid #6d2932 !important;
        }

        .siswa-table th,
        .siswa-table td {
            padding: 12px;
            border: 1px solid #6d2932 !important;
            text-align: center;
        }

        .siswa-table th {
            background: #6d2932 !important;
            color: #fff !important;
            border-bottom: 2.5px solid #561c24 !important;
            font-weight: 700;
            font-size: 1.08em;
        }

        .siswa-table tr:nth-child(even) {
            background: #f9f9f9 !important;
        }

        .siswa-table tr:hover {
            background: #eee !important;
        }

        .siswa-table td.nama-cell {
            text-align: left !important;
            padding-left: 15px;
        }

        /* DataTables pagination styling */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.5em 1em !important;
            margin: 0 2px !important;
            border-radius: 4px !important;
            border: 1px solid transparent !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: #6d2932 !important;
            color: white !important;
            border: 1px solid #561c24 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #561c24 !important;
            color: white !important;
            border: 1px solid #4b1d1d !important;
        }

        /* Search input styling */
        .dataTables_filter input {
            padding: 5px !important;
            border-radius: 4px !important;
            border: 1px solid #ccc !important;
        }

        /* Info text styling */
        .dataTables_info {
            color: #333 !important;
        }

        .detail-button {
            background: #6d2932;
            color: #fff;
            padding: 4px 18px;
            min-width: 80px;
            font-size: 1em;
            border: none;
            border-radius: 18px;
            cursor: pointer;
            text-decoration: none;
            transition: 0.3s;
        }

        .detail-button:hover {
            background: #4b1d1d;
        }

        .search-form {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .search-form input {
            padding: 8px 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .search-form button {
            background: #6d2932;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .search-form button:hover {
            background: #4b1d1d;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 99;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 30px;
            border-radius: 10px;
            max-width: 400px;
            text-align: center;
            color: #333;
        }

        .modal-button {
            margin: 10px;
            padding: 10px 22px;
            border: none;
            border-radius: 24px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .modal-button.yes {
            background-color: #6d2932;
            color: white;
        }

        .modal-button.no {
            background-color: #ccc;
            color: #333;
        }

        .modal-button.yes:hover {
            background: #4b1d1d;
        }

        .modal-button.no:hover {
            background: #999;
        }

        .back-button {
            margin-top: 20px;
            background: #6d2932;
            color: #fff;
            border: none;
            padding: 8px 24px;
            font-size: 1em;
            border-radius: 18px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            transition: 0.3s;
        }

        .back-button:hover {
            background: #4b1d1d;
        }

        /* Nilai detail styles */
        .nilai-detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .nilai-detail-table th,
        .nilai-detail-table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .nilai-detail-table th {
            background-color: #6d2932;
            color: white;
        }

        .nilai-detail-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .detail-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            padding: 6px 12px;
            min-width: 80px;
        }

        .button-group {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: center;
        }
    </style>
</head>

<body>

    <div class="navbar">
        <div class="menu-icon" onclick="toggleMenu()">☰</div>
        <h2 class="navbar-title" style="margin:0; font-size: 3em;">SMK NEGERI 1 PUNGGING</h2>
        <div class="navbar-action">
            <a href="tambah.php"><button class="add-button">+ Tambah Data</button></a>
            <a href="tambah_nilai.php" style="margin-left:12px;"><button class="add-button" style="background:#4b7732; color:#fff;">+ Tambah Nilai</button></a>
        </div>
    </div>

    <div id="dropdownMenu" class="dropdown-menu">
        <a href="#" onclick="showSection('datasiswa')"><i class="bi bi-table"></i> Data Siswa</a>
        <a href="#" onclick="showSection('visimisi')"><i class="bi bi-bullseye"></i> Visi & Misi</a>
        <a href="#" onclick="showSection('jurnal')"><i class="bi bi-journal-text"></i> Jurnal Pribadi</a>
        <a href="#" onclick="showSection('nilai')"><i class="bi bi-clipboard-data"></i> Nilai Ujian/Mapel</a>
        <a href="#" onclick="showSection('lainlain')"><i class="bi bi-three-dots"></i> Lain-lain</a>
        <a href="#" onclick="showSection('kontak')"><i class="bi bi-telephone"></i> Kontak</a>
    </div>

    <!-- VISI MISI -->
    <div id="visimisi" style="display:none;" class="container">
        <div class="datasiswa-header" style="display: flex; align-items: center; justify-content: center; gap: 20px; margin-bottom: 20px;">
            <img src="logo/smk.png" alt="Logo SMK" style="width: 70px; border-radius: 10px;">
            <h3 class="datasiswa-title" style="margin:0; font-size: 2.5em; color: #6d2932;">VISI & MISI</h3>
        </div>
        <h3 style="color:#6d2932; margin-bottom:8px;">Visi</h3>
        <p style="margin-top:0; font-size:1.1em; color:#333;">Mewujudkan lulusan yang berkarakter, berdaya saing global, dan berjiwa wirausaha.</p>
        <h3 style="color:#6d2932; margin-bottom:8px;">Misi</h3>
        <ol style="color:#333; font-size:1.05em;">
            <li>Mengembangkan pendidikan berbasis teknologi dan kebutuhan industri.</li>
            <li>Menanamkan nilai-nilai kejujuran, disiplin, dan tanggung jawab.</li>
            <li>Mendorong kreativitas, inovasi, dan jiwa kewirausahaan siswa.</li>
            <li>Meningkatkan kemampuan bahasa asing dan literasi digital.</li>
            <li>Menjalin kemitraan dengan dunia usaha dan dunia industri (DUDI).</li>
            <li>Mengoptimalkan layanan bimbingan konseling dan pengembangan karakter.</li>
        </ol>
        <div style="margin-top:18px; color:#6d2932; font-weight:600;">Moto: "Berilmu, Berakhlak, Siap Kerja!"</div>
        <button class="back-button" onclick="showSection('datasiswa')">Kembali</button>
    </div>

    <!-- JURNAL PRIBADI -->
    <div id="jurnal" style="display:none;" class="container">
        <div class="datasiswa-header" style="display: flex; align-items: center; justify-content: center; gap: 20px; margin-bottom: 20px;">
            <img src="logo/smk.png" alt="Logo SMK" style="width: 70px; border-radius: 10px;">
            <h3 class="datasiswa-title" style="margin:0; font-size: 2.5em; color: #6d2932;">JURNAL HARIAN SISWA</h3>
        </div>
        <table id="jurnalTable" class="siswa-table" style="width:100%">
            <thead>
                <tr>
                    <th>Hari</th>
                    <th>Aktivitas</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Senin</td>
                    <td>Mengikuti pelajaran Matematika dan Bahasa Inggris, mengerjakan tugas rumah.</td>
                </tr>
                <tr>
                    <td>Selasa</td>
                    <td>Praktik jaringan komputer di laboratorium, diskusi kelompok.</td>
                </tr>
                <tr>
                    <td>Rabu</td>
                    <td>Ekstrakurikuler futsal, belajar mandiri di perpustakaan.</td>
                </tr>
                <tr>
                    <td>Kamis</td>
                    <td>Presentasi tugas kelompok, konsultasi dengan guru BK.</td>
                </tr>
                <tr>
                    <td>Jumat</td>
                    <td>Kegiatan keagamaan, refleksi mingguan, persiapan ujian.</td>
                </tr>
            </tbody>
        </table>
        <button class="back-button" onclick="showSection('datasiswa')">Kembali</button>
    </div>

    <!-- NILAI UJIAN PER SISWA -->
    <div id="nilai" style="display:none;" class="container">
        <div class="datasiswa-header" style="display: flex; align-items: center; justify-content: center; gap: 20px; margin-bottom: 20px;">
            <img src="logo/smk.png" alt="Logo SMK" style="width: 70px; border-radius: 10px;">
            <h3 class="datasiswa-title" style="margin:0; font-size: 2.5em; color: #6d2932;">DATA NILAI UJIAN SISWA XII TKJ 2</h3>
        </div>
        <table id="nilaiTable" class="siswa-table" style="width:100%">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>NAMA</th>
                    <th>NIS</th>
                    <th>KELAS</th>
                    <th>JURUSAN</th>
                    <th>LIHAT NILAI</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query khusus untuk section nilai
                $query_nilai = $keyword != ''
                    ? "SELECT * FROM siswa WHERE nama LIKE '%$keyword%' OR nis LIKE '%$keyword%' ORDER BY nama ASC"
                    : "SELECT * FROM siswa ORDER BY nama ASC";

                $no_nilai = 1;
                $result_nilai = mysqli_query($conn, $query_nilai);
                while ($row_nilai = mysqli_fetch_assoc($result_nilai)) {
                    echo "<tr data-id='{$row_nilai['id']}'>";
                    echo "<td>{$no_nilai}</td>";
                    echo "<td class='nama-cell'>" . htmlspecialchars($row_nilai['nama']) . "</td>";
                    echo "<td>" . htmlspecialchars($row_nilai['nis']) . "</td>";
                    echo "<td>" . htmlspecialchars($row_nilai['kelas'] ?? '-') . "</td>";
                    echo "<td>" . htmlspecialchars($row_nilai['jurusan']) . "</td>";
                    echo "<td><button class='detail-button btn-lihat-nilai' data-id='{$row_nilai['id']}' onclick='showNilaiDetail({$row_nilai['id']})'>Lihat Nilai</button></td>";
                    echo "</tr>";
                    $no_nilai++;
                }
                ?>
            </tbody>
        </table>
        <div style="color:#6d2932; font-size:1.05em; margin-bottom:10px;">Keterangan: Nilai minimal tuntas = 75</div>
        <button class="back-button" onclick="showSection('datasiswa')">Kembali</button>
    </div>

    <!-- Modal Detail Nilai -->
    <div id="nilaiDetailModal" class="modal">
        <div class="modal-content" style="max-width: 600px;">
            <h3>Detail Nilai Siswa</h3>
            <div id="nilaiDetailContent"></div>
            <div style="margin-top:20px;">
            </div>
        </div>
    </div>

    <!-- LAIN-LAIN -->
    <div id="lainlain" style="display:none;" class="container">
        <h2>Lain-lain</h2>
        <ul style="color:#333;">
            <li><b>Informasi Beasiswa:</b> Beasiswa Prestasi, Beasiswa KIP, Beasiswa Unggulan.</li>
            <li><b>Pengumuman Penting:</b> Ujian akhir semester dimulai tanggal 15 Juli 2025.</li>
            <li><b>Agenda Kegiatan:</b> Lomba Futsal antar kelas, Seminar Karir, Kunjungan Industri.</li>
            <li><b>Link E-Learning:</b> <a href="https://elearning.smkn1pungging.sch.id" target="_blank">elearning.smkn1pungging.sch.id</a></li>
            <li><b>Perpustakaan Digital:</b> <a href="https://perpus.smkn1pungging.sch.id" target="_blank">perpus.smkn1pungging.sch.id</a></li>
        </ul>
        <button class="back-button" onclick="showSection('datasiswa')">Kembali</button>
    </div>

    <!-- KONTAK SEKOLAH -->
    <div id="kontak" style="display:none;" class="container">
        <div class="datasiswa-header" style="display: flex; align-items: center; justify-content: center; gap: 20px; margin-bottom: 20px;">
            <img src="logo/smk.png" alt="Logo SMK" style="width: 70px; border-radius: 10px;">
            <h3 class="datasiswa-title" style="margin:0; font-size: 2.5em; color: #6d2932;">KONTAK SEKOLAH</h3>
        </div>
        <table id="kontakTable" class="siswa-table">
            <thead>
                <tr>
                    <th>Field</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Nama Sekolah</strong></td>
                    <td>SMK NEGERI 1 PUNGGING</td>
                </tr>
                <tr>
                    <td><strong>Alamat</strong></td>
                    <td>Jl. Raya Pungging No.45, Mojokerto</td>
                </tr>
                <tr>
                    <td><strong>Telepon</strong></td>
                    <td>(0321) 123456</td>
                </tr>
                <tr>
                    <td><strong>Email</strong></td>
                    <td>smkn1pungging@example.sch.id</td>
                </tr>
                <tr>
                    <td><strong>Website</strong></td>
                    <td>www.smkn1pungging.sch.id</td>
                </tr>
            </tbody>
        </table>
        <button class="back-button" onclick="showSection('datasiswa')">Kembali</button>
    </div>

    <!-- DATA SISWA -->
    <div id="datasiswa" class="container">
        <div class="datasiswa-header" style="display: flex; align-items: center; justify-content: center; gap: 20px; margin-bottom: 20px;">
            <img src="logo/smk.png" alt="Logo SMK" style="width: 70px; border-radius: 10px;">
            <h3 class="datasiswa-title" style="margin:0; font-size: 2.5em; color: #6d2932;">DATA SISWA XII TKJ 2</h3>
        </div>
      <table id="siswaTable" class="siswa-table" style="width:100%">
    <thead>
        <tr>
            <th>NO</th>
            <th>NAMA</th>
            <th>NIS</th>
            <th>KELAS</th>
            <th>JURUSAN</th>
            <th>DETAIL</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        mysqli_data_seek($result, 0); // Reset pointer result ke awal
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr data-id='{$row['id']}'>";
            echo "<td>{$no}</td>"; // NO
            echo "<td class='nama-cell'>" . htmlspecialchars($row['nama']) . "</td>"; // NAMA
            echo "<td>" . htmlspecialchars($row['nis']) . "</td>"; // NIS
            echo "<td>" . htmlspecialchars($row['kelas'] ?? '-') . "</td>"; // KELAS
            echo "<td>" . htmlspecialchars($row['jurusan']) . "</td>"; // JURUSAN
            echo "<td>
                    <div style='display: flex; gap: 5px; flex-wrap: wrap; justify-content: center;'>
                    <a class='detail-button' href='detail.php?id={$row['id']}' style='min-width: 70px;'>Detail</a> 
                    <a class='detail-button' style='background:#4b7732; min-width: 70px;' href='edit.php?id={$row['id']}'>Edit</a> 
                   <button type='button' class='detail-button' style='background:#b32b2b; min-width: 70px;' onclick='showDeleteModal({$row['id']})'>Hapus</button>
                    <button type='button' class='detail-button' style='background:#2b5bb3; min-width: 70px;' onclick='printSiswa({$row['id']})'>Print</button>
                    </div>
                </td>";
            echo "</tr>";
            $no++;
        }
        ?>
    </tbody>
</table>
    </div>

   <!-- Modal Hapus -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <h3>Apakah Anda yakin ingin menghapus data ini?</h3>
        <div style="margin-top: 20px;">
            <button type="button" class="modal-button yes" id="confirmDeleteBtn">Ya, Hapus</button>
            <button type="button" class="modal-button no" onclick="closeDeleteModal()">Tidak</button>
        </div>
    </div>
</div>

    <!-- jQuery and DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

    <script>
        function toggleMenu() {
            var menu = document.getElementById("dropdownMenu");
            menu.style.display = (menu.style.display === "block") ? "none" : "block";
        }
        
        // Initialize DataTables when document is ready
       $(document).ready(function() {
    // Inisialisasi DataTable hanya sekali
    if (!$.fn.DataTable.isDataTable('#siswaTable')) {
        $('#siswaTable').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                extend: 'print',
                text: '<i class="bi bi-printer"></i> Print',
                className: 'detail-button',
                title: 'DATA SISWA XII TKJ 2 - SMK NEGERI 1 PUNGGING',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4] // Exclude action column
                }
            }],

            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan MENU data per halaman",
                info: "Menampilkan START sampai END dari TOTAL data",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Berikutnya",
                    previous: "Sebelumnya"
                } // Ditambahkan koma di sini
            },

           createdRow: function(row, data, dataIndex) {
        var id = $(row).find('button[onclick^="printSiswa"]').attr('onclick').match(/\d+/)[0];
        $(row).attr('data-id', id);
            }
        });
    }
});
            // Initialize nilai table dengan pendekatan yang lebih sederhana
            if (!$.fn.DataTable.isDataTable('#nilaiTable')) {
                $('#nilaiTable').DataTable({
                    dom: 'Bfrtip',
                    buttons: [{
                        extend: 'print',
                        text: '<i class="bi bi-printer"></i> Print',
                        className: 'detail-button',
                        title: 'DATA NILAI SISWA XII TKJ 2 - SMK NEGERI 1 PUNGGING',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4] // Exclude action column
                        }
                    }],
                    language: {
                        search: "Cari:",
                        lengthMenu: "Tampilkan MENU data per halaman",
                        info: "Menampilkan START sampai END dari TOTAL data",
                        paginate: {
                            first: "Pertama",
                            last: "Terakhir",
                            next: "Berikutnya",
                            previous: "Sebelumnya"
                        }
                    }
                });
            }

            // Initialize other tables with basic configuration
            $('#jurnalTable, #kontakTable').DataTable({
                searching: false,
                paging: false,
                info: false,
                ordering: false
            });


        function showNilaiDetail(idSiswa) {
            // Kirim permintaan AJAX untuk mendapatkan data nilai dari server
            $.ajax({
                url: 'get_nilai.php',
                type: 'GET',
                data: { id_siswa: idSiswa },
                success: function(response) {
                    // Dapatkan data siswa dari tabel
                    var row = $(`#nilaiTable tr[data-id="${idSiswa}"]`);
                    var nama = row.find('td:nth-child(2)').text();
                    var nis = row.find('td:nth-child(3)').text();
                    
                    // Buat konten untuk modal
                    var content = `<h4 style="color:#6d2932; margin-bottom:15px;">${nama} - NIS: ${nis}</h4>`;
                    
                    if (response.success && response.data.length > 0) {
                        content += '<table class="nilai-detail-table">';
                        content += '<tr><th>Mata Pelajaran</th><th>Nilai</th><th>Keterangan</th></tr>';
                        
                        response.data.forEach(function(nilai) {
                            var keterangan = nilai.nilai >= 75 ? 'Tuntas' : 'Belum Tuntas';
                            content += `<tr>
                                <td>${nilai.mapel}</td>
                                <td>${nilai.nilai}</td>
                                <td>${keterangan}</td>
                            </tr>`;
                        });
                        
                        content += '</table>';
                    } else {
                        content += '<div style="color:#b32b2b; text-align:center;">Belum ada nilai yang dimasukkan.</div>';
                    }
                    
                    // Tambahkan tombol print
                    content += `<div style="margin-top:20px; display: flex; justify-content: center; gap: 10px;">
                        <button type="button" class="detail-button" style="background:#2b5bb3;" onclick="printNilaiDetail(${idSiswa})">
                            <i class="bi bi-printer"></i> Print
                        </button>
                        <button type="button" class="detail-button" style="background:#6d2932;" onclick="closeNilaiDetailModal()">
                            <i class="bi bi-x"></i> Tutup
                        </button>
                    </div>`;
                    
                    $('#nilaiDetailContent').html(content);
                    $('#nilaiDetailModal').show();
                },
                error: function() {
                    $('#nilaiDetailContent').html('<div style="color:#b32b2b; text-align:center;">Gagal memuat data nilai.</div>');
                    $('#nilaiDetailModal').show();
                }
            });
        }

        function closeNilaiDetailModal() {
            $('#nilaiDetailModal').hide();
        }

        function printNilaiDetail(idSiswa) {
            // Kirim permintaan AJAX untuk mendapatkan data nilai dari server
            $.ajax({
                url: 'get_nilai.php',
                type: 'GET',
                data: { id_siswa: idSiswa },
                success: function(response) {
                    // Dapatkan data siswa dari tabel
                    var row = $(`#nilaiTable tr[data-id="${idSiswa}"]`);
                    var nama = row.find('td:nth-child(2)').text();
                    var nis = row.find('td:nth-child(3)').text();
                    var kelas = row.find('td:nth-child(4)').text();
                    var jurusan = row.find('td:nth-child(5)').text();
                    
                    // Buat konten untuk print
                    var printContent = `
                        <style>
                            body { font-family: Arial, sans-serif; margin: 20px; }
                            .header { text-align: center; margin-bottom: 20px; }
                            .header img { width: 80px; }
                            .title { font-size: 18px; font-weight: bold; margin: 10px 0; }
                            .biodata { margin-bottom: 20px; }
                            table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                            th, td { border: 1px solid #000; padding: 8px; text-align: left; }
                            th { background-color: #f2f2f2; }
                            .footer { text-align: right; margin-top: 30px; font-style: italic; }
                        </style>
                        <div class="header">
                            <img src="logo/smk.png" alt="Logo SMK">
                            <div class="title">DATA NILAI SISWA</div>
                            <div>SMK NEGERI 1 PUNGGING</div>
                        </div>
                        
                        <div class="biodata">
                            <table>
                                <tr><th width="30%">Nama Siswa</th><td>${nama}</td></tr>
                                <tr><th>NIS</th><td>${nis}</td></tr>
                                <tr><th>Kelas</th><td>${kelas}</td></tr>
                                <tr><th>Jurusan</th><td>${jurusan}</td></tr>
                            </table>
                        </div>
                        
                        <div class="title">DATA NILAI</div>
                        <table>
                            <tr>
                                <th>Mata Pelajaran</th>
                                <th>Nilai</th>
                                <th>Keterangan</th>
                            </tr>
                    `;
                    
                    if (response.success && response.data.length > 0) {
                        response.data.forEach(function(nilai) {
                            var keterangan = nilai.nilai >= 75 ? 'Tuntas' : 'Belum Tuntas';
                            printContent += `
                                <tr>
                                    <td>${nilai.mapel}</td>
                                    <td>${nilai.nilai}</td>
                                    <td>${keterangan}</td>
                                </tr>
                            `;
                        });
                    } else {
                        printContent += `
                            <tr>
                                <td colspan="3" style="text-align: center;">Belum ada nilai yang dimasukkan</td>
                            </tr>
                        `;
                    }
                    
                    printContent += `
                        </table>
                        <div class="footer">
                            Mojokerto, ${new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}
                            <br><br><br>
                            (___________________)
                        </div>
                    `;
                    
                    // Buka window baru untuk print
                    var printWindow = window.open('', '_blank');
                    printWindow.document.write(printContent);
                    printWindow.document.close();
                    printWindow.focus();
                    
                    // Tunggu sebentar sebelum print untuk memastikan konten terload
                    setTimeout(function() {
                        printWindow.print();
                        printWindow.close();
                    }, 500);
                }
            });
        }

        function printSiswa(idSiswa) {
    // Cari baris dengan data-id yang sesuai
    var row = $('#siswaTable').find(`tr[data-id="${idSiswa}"]`);
    
    if (row.length === 0) {
        console.error('Data tidak ditemukan! ID:', idSiswa);
        alert('Data siswa tidak ditemukan! ID: ' + idSiswa);
        return;
    }

    // Ambil data dari kolom
    var nama = row.find('td:nth-child(2)').text().trim();
    var nis = row.find('td:nth-child(3)').text().trim();
    var kelas = row.find('td:nth-child(4)').text().trim();
    var jurusan = row.find('td:nth-child(5)').text().trim();

    console.log("Data ditemukan:", {nama, nis, kelas, jurusan});

    // Kirim permintaan AJAX untuk mendapatkan data nilai
    $.ajax({
        url: 'get_nilai.php',
        type: 'GET',
        data: { id_siswa: idSiswa },
        success: function(response) {
            // Buat konten untuk print
            var printContent = `
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    .header { text-align: center; margin-bottom: 20px; }
                    .header img { width: 80px; }
                    .title { font-size: 18px; font-weight: bold; margin: 10px 0; }
                    .biodata { margin-bottom: 20px; }
                    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                    th, td { border: 1px solid #000; padding: 8px; text-align: left; }
                    th { background-color: #f2f2f2; }
                    .footer { text-align: right; margin-top: 30px; font-style: italic; }
                </style>
                <div class="header">
                    <img src="logo/smk.png" alt="Logo SMK">
                    <div class="title">BIODATA DAN NILAI SISWA</div>
                    <div>SMK NEGERI 1 PUNGGING</div>
                </div>
                
                <div class="biodata">
                    <table>
                        <tr><th width="30%">Nama Siswa</th><td>${nama}</td></tr>
                        <tr><th>NIS</th><td>${nis}</td></tr>
                        <tr><th>Kelas</th><td>${kelas}</td></tr>
                        <tr><th>Jurusan</th><td>${jurusan}</td></tr>
                    </table>
                </div>
                
                <div class="title">DATA NILAI</div>
                <table>
                    <tr>
                        <th>Mata Pelajaran</th>
                        <th>Nilai</th>
                        <th>Keterangan</th>
                    </tr>
            `;

            if (response.success && response.data.length > 0) {
                response.data.forEach(function(nilai) {
                    var keterangan = nilai.nilai >= 75 ? 'Tuntas' : 'Belum Tuntas';
                    printContent += `
                        <tr>
                            <td>${nilai.mapel}</td>
                            <td>${nilai.nilai}</td>
                            <td>${keterangan}</td>
                        </tr>
                    `;
                });
            } else {
                printContent += `
                    <tr>
                        <td colspan="3" style="text-align: center;">Belum ada nilai yang dimasukkan</td>
                    </tr>
                `;
            }

            printContent += `
                </table>
                <div class="footer">
                    Mojokerto, ${new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}
                    <br><br><br>
                    (___________________)
                </div>
            `;
            
            // Buka window baru untuk print
            var printWindow = window.open('', '_blank');
            printWindow.document.write(printContent);
            printWindow.document.close();
            
            setTimeout(function() {
                printWindow.print();
                printWindow.close();
            }, 500);
        },
        error: function() {
            alert('Gagal memuat data nilai!');
        }
    });
}

        function showSection(section) {
            // Sembunyikan semua section utama
            var sections = [
                "kontak", "datasiswa", "visimisi", "jurnal", "nilai", "lainlain"
            ];
            sections.forEach(function(sec) {
                var el = document.getElementById(sec);
                if (el) el.style.display = "none";
            });

            // Tampilkan section yang dipilih
            var showEl = document.getElementById(section);
            if (showEl) showEl.style.display = "block";

            document.getElementById("dropdownMenu").style.display = "none";
        }

        document.addEventListener('click', function(event) {
            var dropdown = document.getElementById("dropdownMenu");
            var menuIcon = document.querySelector(".menu-icon");
            if (!menuIcon.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.style.display = "none";
            }
        });

        function confirmDelete(id) {
            var modal = document.getElementById('deleteModal');
            var confirmBtn = document.getElementById('confirmDeleteBtn');
            confirmBtn.href = 'hapus.php?id=' + id;
            modal.style.display = 'block';
        }

                // Variabel global untuk menyimpan ID yang akan dihapus
        let currentDeleteId = null;

        function showDeleteModal(id) {
            currentDeleteId = id;
            document.getElementById('deleteModal').style.display = 'block';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
            currentDeleteId = null;
        }

        // Fungsi untuk menghapus data via AJAX
        function deleteData(id) {
            $.ajax({
                url: 'hapus.php',
                type: 'POST',
                data: { 
                    id: id,
                    confirm_delete: 1
                },
                success: function(response) {
                    // Refresh halaman setelah penghapusan berhasil
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    alert('Gagal menghapus data: ' + error);
                    closeDeleteModal();
                }
            });
        }

        // Event listener untuk tombol konfirmasi hapus
        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (currentDeleteId) {
                deleteData(currentDeleteId);
            }
        });

       function closeDeleteModal() {
            var modal = document.getElementById('deleteModal');
            if (modal) {
            modal.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const section = urlParams.get('section');

            if (section) {
                showSection(section);
            }
        });
    </script>

    <footer style="background: linear-gradient(to top, #4b1d1d 0%, #6d2932 100%); color:white; text-align:center; padding:15px 10px 10px 10px; margin-top:30px; font-family:sans-serif; font-size:0.98em;">
        <div style="margin-bottom:2px;">
            &copy; Copyright 2025, Delias Fahriza Dinata
        </div>
        <div style="margin-top:6px;">
            <a href="https://www.instagram.com/tjkt48.arkasi?igsh=cTNneGY1NXh2bGM0" target="_blank" style="color:#fff; text-decoration:none;">
                <i class="bi bi-instagram"></i> tjkt48.arkasi
            </a>
        </div>
    </footer>

</body>

</html>