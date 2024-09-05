<?php 
  require 'connection.php';
  checkLogin();
  $bulan_pembayaran = mysqli_query($conn, "SELECT * FROM bulan_pembayaran ORDER BY id_bulan_pembayaran DESC");
  $pengeluaran_data = [];
  if (isset($_POST['btnLaporanPemasukkan'])) {
    $id_bulan_pembayaran = htmlspecialchars($_POST['id_bulan_pembayaran']);
    $sql = mysqli_query($conn, "SELECT * FROM bulan_pembayaran INNER JOIN uang_kas ON bulan_pembayaran.id_bulan_pembayaran = uang_kas.id_bulan_pembayaran INNER JOIN siswa ON uang_kas.id_siswa = siswa.id_siswa WHERE bulan_pembayaran.id_bulan_pembayaran = '$id_bulan_pembayaran'");
    $fetch_sql = mysqli_fetch_assoc($sql);
  }
  if (isset($_POST['btnLaporanPengeluaran'])) {
    $dari_tanggal_date = htmlspecialchars($_POST['dari_tanggal']);
    $sampai_tanggal_date = htmlspecialchars($_POST['sampai_tanggal']);
    $dari_tanggal = strtotime(htmlspecialchars($_POST['dari_tanggal'] . " 00:00:00"));
    $sampai_tanggal = strtotime(htmlspecialchars($_POST['sampai_tanggal'] . " 23:59:59"));
    $sql = mysqli_query($conn, "SELECT * FROM pengeluaran INNER JOIN user ON pengeluaran.id_user = user.id_user WHERE tanggal_pengeluaran BETWEEN '$dari_tanggal' AND '$sampai_tanggal'");
    while ($row = mysqli_fetch_assoc($sql)) {
      $pengeluaran_data[] = $row;
    }
    $total_pengeluaran = array_sum(array_column($pengeluaran_data, 'jumlah_pengeluaran'));
  }
?>

<!DOCTYPE html>
<html>
<head>
  <?php include 'include/css.php'; ?>
  <title>Laporan</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    @media print {
      .not-printed {
        display: none;
      }
      .total {
        color: black !important;
      }
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  
  <?php include 'include/navbar.php'; ?>

  <?php include 'include/sidebar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm">
            <h1 class="m-0 text-dark">Laporan</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="not-printed row justify-content-center">
          <div class="col-lg-5 mr-4">
            <h3>Pemasukkan</h3>
            <form method="post">
              <div class="form-group">
                <label for="id_bulan_pembayaran">Pilih Bulan Pembayaran</label>
                <select name="id_bulan_pembayaran" id="id_bulan_pembayaran" class="form-control">
                  <?php if (isset($_POST['btnLaporanPemasukkan'])): ?>
                    <option value="<?= $fetch_sql['id_bulan_pembayaran']; ?>"><?= ucwords($fetch_sql['nama_bulan']); ?> | <?= $fetch_sql['tahun']; ?> | Rp. <?= number_format($fetch_sql['pembayaran_perminggu']); ?></option>
                    <option disabled>----</option>
                  <?php endif ?>
                  <?php foreach ($bulan_pembayaran as $dbp): ?>
                    <option value="<?= $dbp['id_bulan_pembayaran']; ?>"><?= ucwords($dbp['nama_bulan']); ?> | <?= $dbp['tahun']; ?> | Rp. <?= number_format($dbp['pembayaran_perminggu']); ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group">
                <button type="submit" name="btnLaporanPemasukkan" class="btn btn-primary">Laporan Pemasukkan</button>
              </div>
            </form>
          </div>
          <div class="col-lg-5 ml-4">
            <h3>Pengeluaran</h3>
            <form method="post">
              <div class="row">
                <div class="col-lg">
                  <div class="form-group">
                    <label for="dari_tanggal">Dari Tanggal</label>
                    <?php if (isset($_POST['btnLaporanPengeluaran'])): ?>
                      <input type="date" name="dari_tanggal" class="form-control" id="dari_tanggal" value="<?= $_POST['dari_tanggal']; ?>">
                    <?php else: ?>
                      <input type="date" name="dari_tanggal" class="form-control" id="dari_tanggal" value="<?= date('Y-m-01'); ?>">
                    <?php endif ?>
                  </div>
                </div>
                <div class="col-lg">
                  <div class="form-group">
                    <label for="sampai_tanggal">Sampai Tanggal</label>
                    <?php if (isset($_POST['btnLaporanPengeluaran'])): ?>
                      <input type="date" name="sampai_tanggal" class="form-control" id="sampai_tanggal" value="<?= $_POST['sampai_tanggal']; ?>">
                    <?php else: ?>
                      <input type="date" name="sampai_tanggal" class="form-control" id="sampai_tanggal" value="<?= date('Y-m-d'); ?>">
                    <?php endif ?>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <button type="submit" name="btnLaporanPengeluaran" class="btn btn-primary">Laporan Pengeluaran</button>
              </div>
            </form>
          </div>
        </div>
       <?php if (isset($_POST['btnLaporanPemasukkan'])): ?>
  <hr class="not-printed">
  <button onclick="return print()" class="not-printed btn btn-success"><i class="fas fa-fw fa-print"></i> Print</button>
  <div class="row m-1">
    <div class="col-lg m-1">
      <h2 class="text-center mb-3 mt-2">Laporan Pemasukkan</h2>
      <h3 class="text-left mb-3">Laporan Pada Bulan: <?= ucwords($fetch_sql['nama_bulan']); ?>, Tahun: <?= $fetch_sql['tahun']; ?>, Pembayaran Perminggu: Rp. <?= number_format($fetch_sql['pembayaran_perminggu']); ?></h3>
      <canvas id="pemasukkanChart"></canvas>
    </div>
  </div>
  <div class="row mx-1 mb-1 mt-0">
    <div class="col-lg-4">
        <?php 
  $jml_uang_kas = mysqli_fetch_assoc(mysqli_query($conn, 
    "SELECT 
      SUM(uang_kas.minggu_ke_1) as total_minggu_1,
      SUM(uang_kas.minggu_ke_2) as total_minggu_2,
      SUM(uang_kas.minggu_ke_3) as total_minggu_3,
      SUM(uang_kas.minggu_ke_4) as total_minggu_4,
      SUM(uang_kas.minggu_ke_1 + uang_kas.minggu_ke_2 + uang_kas.minggu_ke_3 + uang_kas.minggu_ke_4) as jml_uang_kas 
    FROM uang_kas 
    INNER JOIN bulan_pembayaran 
    ON bulan_pembayaran.id_bulan_pembayaran = uang_kas.id_bulan_pembayaran 
    WHERE bulan_pembayaran.id_bulan_pembayaran = '$id_bulan_pembayaran'"
  ));
?>
      <div class="p-3 rounded bg-success total">Total Pemasukkan: Rp. <?= number_format($jml_uang_kas['jml_uang_kas']); ?></div>
    </div>
  </div>
<?php endif ?>
        <?php if (isset($_POST['btnLaporanPengeluaran'])): ?>
          <hr class="not-printed">
          <button onclick="return print()" class="not-printed btn btn-success"><i class="fas fa-fw fa-print"></i> Print</button>
          <div class="row m-1 mb-0">
            <div class="col-lg m-1">
              <h2 class="text-center mb-3 mt-2">Laporan Pengeluaran</h2>
              <h3 class="text-left mb-3">Laporan Dari Tanggal: <?= $dari_tanggal_date; ?> Sampai Tanggal: <?= $sampai_tanggal_date; ?></h3>
              <canvas id="pengeluaranChart"></canvas>
            </div>
          </div>
          <div class="row mx-1 mb-1 mt-0">
            <div class="col-lg-4">
              <div class="p-3 rounded bg-success total">Total Pengeluaran: Rp. <?= number_format($total_pengeluaran); ?></div>
            </div>
          </div>
        <?php endif ?>
      </div>
    </section>
    <!-- /.content -->
  </div>
<!-- ./wrapper -->

<script>
 document.addEventListener('DOMContentLoaded', function() {
  <?php if (isset($_POST['btnLaporanPemasukkan'])): ?>
    var ctx = document.getElementById('pemasukkanChart').getContext('2d');
    var pemasukkanChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Minggu Ke-1', 'Minggu Ke-2', 'Minggu Ke-3', 'Minggu Ke-4'],
        datasets: [{
          label: 'Pemasukkan',
          data: [
  <?= $jml_uang_kas['total_minggu_1']; ?>,
  <?= $jml_uang_kas['total_minggu_2']; ?>,
  <?= $jml_uang_kas['total_minggu_3']; ?>,
  <?= $jml_uang_kas['total_minggu_4']; ?>
],
          backgroundColor: 'rgba(54, 162, 235, 0.2)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  <?php endif ?>
    <?php if (isset($_POST['btnLaporanPengeluaran'])): ?>
      var ctx = document.getElementById('pengeluaranChart').getContext('2d');
      var pengeluaranChart = new Chart(ctx, {
        type: 'pie',
        data: {
          labels: <?= json_encode(array_column($pengeluaran_data, 'keterangan')); ?>,
          datasets: [{
            label: 'Pengeluaran',
            data: <?= json_encode(array_column($pengeluaran_data, 'jumlah_pengeluaran')); ?>,
            backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(54, 162, 235, 0.2)',
              'rgba(255, 206, 86, 0.2)',
              'rgba(75, 192, 192, 0.2)',
              'rgba(153, 102, 255, 0.2)',
              'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
              'rgba(255, 99, 132, 1)',
              'rgba(54, 162, 235, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(75, 192, 192, 1)',
              'rgba(153, 102, 255, 1)',
              'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
        }
      });
    <?php endif ?>
  });
</script>
</body>
</html>
