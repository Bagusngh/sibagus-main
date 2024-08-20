<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php
function hitungQty($koneksi, $nama_tabel){
    $select = "SELECT COUNT(*) qty FROM $nama_tabel";
    $result = mysqli_query($koneksi, $select);
    $row = mysqli_fetch_assoc($result);
    return $row['qty'];
}


$ruang_qty = hitungQty($koneksi, "ruang");
$karyawan_qty = hitungQty($koneksi, "karyawan");
$pemasok_qty = hitungQty($koneksi, "pemasok");
$barang_qty = hitungQty($koneksi, "barang");

$query = "SELECT nama_barang, b.satuan as type, SUM(jumlah) as Jumlah FROM barang_keluar_detail bk
          JOIN barang b ON bk.barang_id=b.kode_barang GROUP BY nama_barang ORDER BY jumlah DESC";
$result = mysqli_query($koneksi, $query);

$item_names = [];
$counts = [];
$tipe = [];

while($row = mysqli_fetch_assoc($result)){
    $item_names[] = $row['nama_barang'];
    $counts[] = $row['Jumlah'];
    $tipe[] = $row['type'];
}

?>
<div id="badges" class="row g-3 my-2">
    <div class="col-md-6 col-lg-3">
        <div class="p-3 hijo-bg shadow-sm d-flex justify-content-around align-items-center rounded">
            <div>
                <h3 class="fs-2"><?= $ruang_qty ?></h3>
                <p class="fs-5 text-white">Ruang</p>
            </div>
            <i class="fas fa-building fs-1 text-white hijo-bg p-3"></i>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="p-3 secondary-bg shadow-sm d-flex justify-content-around align-items-center rounded">
            <div>
                <h3 class="fs-2"><?= $karyawan_qty ?></h3>
                <p class="fs-5 text-white">Karyawan</p>
            </div>
            <i class="fas fa-users fs-1 text-white secondary-bg p-3"></i>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="p-3 bg-primary shadow-sm d-flex justify-content-around align-items-center rounded">
            <div>
                <h3 class="fs-2"><?= $pemasok_qty ?></h3>
                <p class="fs-5 text-white">Pemasok</p>
            </div>
            <i class="fas fa-money-bill fs-1 text-white bg-primary p-3"></i>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="p-3 bg-danger shadow-sm d-flex justify-content-around align-items-center rounded">
            <div>
                <h3 class="fs-2"><?= $barang_qty ?></h3>
                <p class="fs-5 text-white">Barang</p>
            </div>
            <i class="fas fa-chart-line fs-1 text-white bg-danger p-3"></i>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="p-3 bg-info shadow-sm d-flex justify-content-around align-items-center rounded" style="padding-bottom: 5px;">
            <div class="col-md-12" >
            <center><button class="btn btn-info" id="downloadBtn" style="padding: 8px 16px; margin-top: 5px;  font-size: 14px;">&nbsp;<i class="fas fa-print"></i> Cetak</button></center>
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    console.log(<?php echo json_encode($item_names); ?>);
    console.log(<?php echo json_encode($counts); ?>);
    console.log(<?php echo json_encode($tipe); ?>);

    const counts = <?php echo json_encode($counts); ?>;
    const tipe = <?php echo json_encode($tipe); ?>;
    const itemNames = <?php echo json_encode($item_names); ?>;
    const maxCount = Math.max(...counts);
    const suggestedMax = maxCount + 10;

    // Combine item names with their corresponding units
    const labels = itemNames.map((name, index) => `${name} (${tipe[index]})`);

    // Generate a random color for each bar
    const colors = counts.map(() => {
        return 'rgba(' + Math.floor(Math.random() * 255) + ',' + 
                        Math.floor(Math.random() * 255) + ',' + 
                        Math.floor(Math.random() * 255) + ', 0.5)';
    });

    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels, // Use the labels with units here
            datasets: [{
                data: counts,
                backgroundColor: colors,
                borderColor: colors.map(color => color.replace('0.5', '1')),
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: suggestedMax,
                    ticks: {
                        stepSize: 1,
                        autoSkip: true,
                    },
                    title: {
                        display: true,
                        text: 'Jumlah Barang Keluar',
                        font: {
                            family: 'sans-serif',
                            size: 18
                        }
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Grafik Barang Keluar',
                    font: {
                        family: 'sans-serif',
                        size: 20
                    }
                },
                legend: {
                    display: false, // Hide the legend entirely
                }
            },
            layout: {
                padding: {
                    left: 10,
                    right: 10,
                    top: 10,
                    bottom: 10
                }
            },
            backgroundColor: '#ffffff' // Set the chart background to white
        }
    });

    // Change the chart container's background color to white
    document.getElementById('myChart').parentNode.style.backgroundColor = '#fff';

    // Add download functionality
    document.getElementById('downloadBtn').addEventListener('click', function() {
        const link = document.createElement('a');
        link.href = myChart.toBase64Image();
        link.download = 'grafik-barang-keluar.png';
        link.click();
    });
</script>