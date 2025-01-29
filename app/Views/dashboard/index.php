<?= $this->extend('layouts/main'); ?>

<?= $this->section('content') ?>
<!-- chart  -->
<?php

?>

<section class="section">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-stats">
                    <div class="card-stats-title d-flex justify-content-between align-items-center">
                        <span>Data Kelas</span>
                        <div class="dropdown">
                            <a class="font-weight-600 dropdown-toggle" data-toggle="dropdown" href="#" id="selected-class">
                                <?= session()->get('selected_grade') === 'all' ? 'Semua Kelas' : (isset($grades[session()->get('selected_grade') - 1]) ?
                                    $grades[session()->get(key: 'selected_grade') - 1]['name'] : 'Pilih Kelas') ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" style="max-height: 300px; overflow-y: auto; position: absolute !important;">
                                <div class="dropdown-title">Pilih Kelas</div>
                                <a href="javascript:void(0)"
                                    class="dropdown-item dropdown-grade <?= session()->get('selected_grade') == 'all' ? 'active' : '' ?>"
                                    data-grade="all">Semua Kelas</a>
                                <?php foreach ($grades as $grade): ?>
                                    <a href="javascript:void(0)"
                                        class="dropdown-item dropdown-grade <?= session()->get('selected_grade') == $grade['id'] ? 'active' : '' ?>"
                                        data-grade="<?= $grade['id'] ?>">
                                        <?= $grade['name'] ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-stats-items  d-flex justify-content-around">
                        <div class="card-stats-item text-center">
                            <div class="card-stats-item-count" id="not-voted-count">
                                <?= $statisticByGrade['not_voted'] ?>
                            </div>
                            <div class="card-stats-item-label">Belum Vote</div>
                        </div>
                        <div class="card-stats-item text-center">
                            <div class="card-stats-item-count" id="voted-count">
                                <?= $statisticByGrade['voted'] ?>
                            </div>
                            <div class="card-stats-item-label">Sudah Vote</div>
                        </div>
                    </div>
                </div>
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-user"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total yang Terdaftar</h4>
                    </div>
                    <div class="card-body" id="total-users">
                        <?= $statisticByGrade['total_users'] ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-stats">
                    <div class="card-stats-title">Statistik Kandidat</div>
                    <div class="card-stats-items d-flex justify-content-around">
                        <div class="card-stats-item text-center">
                            <div class="card-stats-item-count"><?= count($candidates) ?></div>
                            <div class="card-stats-item-label">Total Kandidat</div>
                        </div>
                        <div class="card-stats-item text-center">
                            <div class="card-stats-item-count">
                                <?php
                                $highest_vote = 0;
                                foreach ($candidates as $candidate) {
                                    $vote_count = $candidate['vote_count'] ?? 0;
                                    if ($vote_count > $highest_vote) {
                                        $highest_vote = $vote_count;
                                    }
                                }
                                echo $highest_vote;
                                ?>
                            </div>
                            <div class="card-stats-item-label">Vote Tertinggi</div>
                        </div>
                    </div>
                </div>
                <div class="card-icon shadow bg-primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header bg-transparent border-0">
                        <h4 class="mb-0">Total Suara Masuk</h4>
                    </div>
                    <div class="card-body pt-0">
                        <?php
                        $total_votes = 0;
                        foreach ($candidates as $candidate) {
                            $total_votes += $candidate['vote_count'] ?? 0;
                        }
                        echo $total_votes;
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Ketiga (Persentase Partisipasi) -->
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-stats">
                    <div class="card-stats-title">Persentase Partisipasi</div>
                    <div class="card-stats-items d-flex justify-content-around">
                        <div class="card-stats-item text-center">
                            <div class="card-stats-item-count text-success"><?= $statistics['voted_percentage'] ?>%</div>
                            <div class="card-stats-item-label">Tingkat Partisipasi</div>
                        </div>
                        <div class="card-stats-item text-center">
                            <div class="card-stats-item-count text-danger"><?= $statistics['not_voted_percentage'] ?>%</div>
                            <div class="card-stats-item-label">Belum Berpartisipasi</div>
                        </div>
                    </div>
                </div>
                <div class="card-icon shadow bg-primary">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header bg-transparent border-0">
                        <h4 class="mb-0">Target Partisipasi</h4>
                    </div>
                    <div class="card-body pt-0">
                        100%
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section">
    <div class="section-body">
        <!-- <h2 class="section-title">Chart.js</h2>
        <p class="section-lead">
            We use 'Chart.JS' made by @chartjs. You can check the full documentation <a
                href="http://www.chartjs.org/">here</a>.
        </p> -->

        <div class="row">
            <div class="col-12 col-md-6 col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Statistik kandidat</h4>
                        <div class="dropdown">
                            <a class="font-weight-600 dropdown-toggle" data-toggle="dropdown" href="#" id="selected-class2">
                                <?= session()->get('selected_grade') === 'all' ? 'Semua Kelas' : (isset($grades[session()->get('selected_grade') - 1]) ?
                                    $grades[session()->get(key: 'selected_grade') - 1]['name'] : 'Pilih Kelas') ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" style="max-height: 300px; overflow-y: auto; position: absolute !important;">
                                <div class="dropdown-title">Pilih Kelas</div>
                                <a href="javascript:void(0)"
                                    class="dropdown-candidate dropdown-item <?= session()->get('selected_grade') == 'all' ? 'active' : '' ?>"
                                    data-grade="all">Semua Kelas</a>
                                <?php foreach ($grades as $grade): ?>
                                    <a href="javascript:void(0)"
                                        class="dropdown-candidate dropdown-item <?= session()->get('selected_grade') == $grade['id'] ? 'active' : '' ?>"
                                        data-grade="<?= $grade['id'] ?>">
                                        <?= $grade['name'] ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="kandidatBarChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card gradient-bottom">
                    <div class="card-header">
                        <h4>Top 5 Kandidat</h4>
                        <div class="card-header-action dropdown">
                            <a href="#" data-toggle="dropdown" class="btn btn-danger dropdown-toggle" id="selected-grade-label">Semua Kelas</a>
                            <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                <li class="dropdown-title">Pilih Kelas</li>
                                <li><a href="#" class="dropdown-item active grade-selector" data-grade="all">Semua Kelas</a></li>
                                <?php foreach ($grades as $grade): ?>
                                    <li>
                                        <a href="#" class="dropdown-item grade-selector" data-grade="<?= $grade['id'] ?>">
                                            <?= $grade['name'] ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body card-top">
                        <ul class="list-unstyled list-unstyled-border" id="kandidat-list">
                            <?php foreach ($candidates as $candidate): ?>
                                <li class="media">
                                    <img class="mr-3 rounded" width="55"
                                        src="<?= base_url('img/') . $candidate['image'] ?>"
                                        alt="<?= $candidate['fullname'] ?>">
                                    <div class="media-body">
                                        <div class="float-right">
                                            <div class="font-weight-600 text-muted text-small">
                                                <?= $candidate['vote_count'] ?? 0 ?> Suara
                                            </div>
                                        </div>
                                        <div class="media-title"><?= $candidate['fullname'] ?></div>
                                        <div class="mt-1">
                                            <div class="budget-price">
                                                <div class="budget-price-square bg-primary"
                                                    data-width="<?= $candidate['vote_count'] > 0 ?
                                                                    min(100, ($candidate['vote_count'] / max(array_column($candidates, 'vote_count')) * 100)) : 0 ?>%"></div>
                                                <div class="budget-price-label">
                                                    <?= $candidate['vote_count'] > 0 ?
                                                        round(($candidate['vote_count'] / array_sum(array_column($candidates, 'vote_count'))) * 100, 2) : 0 ?>%
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="card-footer pt-3 d-flex justify-content-center">
                        <div class="budget-price justify-content-center">
                            <div class="budget-price-square bg-primary" data-width="20"></div>
                            <div class="budget-price-label">Persentase</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Doughnut Chart</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="bulat"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Pie Chart</h4>
                        <div class="dropdown">
                            <a class="font-weight-600 dropdown-toggle" data-toggle="dropdown" href="#" id="selected-doughnut-class">
                                <?= session()->get('selected_grade') === 'all' ? 'Semua Kelas' : (isset($grades[session()->get('selected_grade') - 1]) ?
                                    $grades[session()->get(key: 'selected_grade') - 1]['name'] : 'Pilih Kelas') ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" style="max-height: 300px; overflow-y: auto; position: absolute !important;">
                                <div class="dropdown-title">Pilih Kelas</div>
                                <a href="javascript:void(0)"
                                    class="dropdown-doughnut dropdown-item <?= session()->get('selected_grade') == 'all' ? 'active' : '' ?>"
                                    data-grade="all">Semua Kelas</a>
                                <?php foreach ($grades as $grade): ?>
                                    <a href="javascript:void(0)"
                                        class="dropdown-doughnut dropdown-item <?= session()->get('selected_grade') == $grade['id'] ? 'active' : '' ?>"
                                        data-grade="<?= $grade['id'] ?>">
                                        <?= $grade['name'] ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="donat"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
</div>


<?= $this->endSection() ?>

<?= $this->section('script') ?>
<!-- JS Libraies -->
<script src="<?= base_url() ?>assets/modules/jquery.sparkline.min.js"></script>
<script src="<?= base_url() ?>assets/modules/owlcarousel2/dist/owl.carousel.min.js"></script>
<script src="<?= base_url() ?>assets/modules/summernote/summernote-bs4.js"></script>
<script src="<?= base_url() ?>assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script>

<!-- Page Specific JS File -->
<script src="<?= base_url() ?>assets/modules/chart.min.js"></script>
<script src="<?= base_url() ?>assets/js/page/modules-chartjs.js"></script>
<script src="<?= base_url() ?>assets/js/page/index.js"></script>


<!-- Page Specific JS File -->
<script>
    $(document).ready(function() {
        console.log('Document ready - script initialized.');

        // Inisialisasi chart
        let kandidatBarChart = null;

        function initializeKandidatBarChart() {
            console.log('Initializing chart...');
            const ctx = document.getElementById('kandidatBarChart').getContext('2d');
            kandidatBarChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Statistics',
                        data: [],
                        borderWidth: 2,
                        backgroundColor: '#6777ef',
                        borderColor: '#6777ef',
                        borderWidth: 2.5,
                        pointBackgroundColor: '#ffffff',
                        pointRadius: 4
                    }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                drawBorder: false,
                                color: '#f2f2f2',
                            },
                            ticks: {
                                beginAtZero: true,
                                stepSize: 1
                            }
                        }],
                        xAxes: [{
                            ticks: {
                                display: false
                            },
                            gridLines: {
                                display: false
                            }
                        }]
                    },
                }
            });
            console.log('Chart initialized.');
        }

        // Fungsi untuk update statistik kandidat
        function updateCandidateStats(candidates) {
            console.log('Updating candidate stats with data:', candidates);

            // Update chart
            if (kandidatBarChart) {
                console.log('Updating chart with candidates:', candidates);
                kandidatBarChart.data.labels = candidates.map(c => c.name);
                kandidatBarChart.data.datasets[0].data = candidates.map(c => c.vote_count);
                kandidatBarChart.update();
            }
        }

        // Handle dropdown kelas
        $('.dropdown-grade').click(function(e) {
            e.preventDefault();
            console.log('Dropdown grade clicked.');

            $('#selected-class').text($(this).text());
            $('.dropdown-grade').removeClass('active');
            $(this).addClass('active');

            let gradeId = $(this).data('grade');

            // Tambahkan loading state
            $('#not-voted-count, #voted-count, #total-users').html('<i class="fas fa-spinner fa-spin"></i>');
            $('#candidate-stats').html('<i class="fas fa-spinner fa-spin"></i>');

            // Ajax request
            $.ajax({
                url: '<?= base_url('dashboard/getStatisticsByGrade') ?>/' + gradeId,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log('Response received:', response);

                    // Update statistik umum
                    $('#not-voted-count').text(response.statistics.not_voted || 0);
                    $('#voted-count').text(response.statistics.voted || 0);
                    $('#total-users').text(response.statistics.total_users || 0);

                    // Update statistik kandidat

                },
                error: function(xhr, status, error) {
                    console.error('Ajax Error:', {
                        status: status,
                        error: error,
                        response: xhr.responseText
                    });

                    // Reset nilai
                    $('#not-voted-count, #voted-count, #total-users').text('0');
                    $('#candidate-stats').html('');
                    if (kandidatBarChart) {
                        kandidatBarChart.data.labels = [];
                        kandidatBarChart.data.datasets[0].data = [];
                        kandidatBarChart.update();
                    }

                    alert('Terjadi kesalahan saat mengambil data');
                }
            });
        });

        // Inisialisasi chart saat halaman dimuat
        initializeKandidatBarChart();
        updateCandidateStats(<?= json_encode($allCount) ?>);


        var ctx = document.getElementById("bulat").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [
                        <?= $statistics['voted_percentage'] ?>,
                        <?= $statistics['not_voted_percentage'] ?>,

                    ],
                    backgroundColor: [
                        '#ffa426',
                        '#fc544b',

                    ],
                    label: 'Dataset 1'
                }],
                labels: [
                    'Sudah vote',
                    'Belum vote',
                ],
            },
            options: {
                responsive: true,
                legend: {
                    position: 'bottom',
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var label = data.labels[tooltipItem.index];
                            var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                            return label + ': ' + value + '%';
                        }
                    }
                }
            }
        });


        $('.dropdown-candidate').click(function(e) {
            e.preventDefault();

            $('#selected-class2').text($(this).text());
            $('.dropdown-candidate').removeClass('active');
            $(this).addClass('active');

            let gradeId = $(this).data('grade');

            // Ajax request
            $.ajax({
                url: '<?= base_url('dashboard/getStatisticsByGrade') ?>/' + gradeId,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    updateCandidateStats(response.candidates);
                },
                error: function(xhr, status, error) {
                    console.error('Ajax Error:', {
                        status: status,
                        error: error,
                        response: xhr.responseText
                    });

                    // Reset nilai
                    $('#not-voted-count, #voted-count, #total-users').text('0');
                    $('#candidate-stats').html('');
                    if (kandidatBarChart) {
                        kandidatBarChart.data.labels = [];
                        kandidatBarChart.data.datasets[0].data = [];
                        kandidatBarChart.update();
                    }

                    alert('Terjadi kesalahan saat mengambil data');
                }
            });
        });

        let kandidatDoughnutChart = null;

        function initializeKandidatDoughnutChart() {
            const ctx = document.getElementById("donat").getContext('2d');
            kandidatDoughnutChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    datasets: [{
                        data: [],
                        backgroundColor: [
                            '#ffa426',
                            '#fc544b',
                            '#6777ef',
                            '#191d21',
                            '#a3a3a3', // Gray
                            '#ffc107', // Yellow
                            '#e83e8c', // Pink
                            '#20c997', // Teal
                            '#17a2b8', // Cyan
                            '#dc3545',
                            '#3abaf4',
                        ],
                        label: 'Dataset 1'
                    }],
                    labels: [],
                },
                options: {
                    responsive: true,
                    legend: {
                        position: 'bottom',
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                const label = data.labels[tooltipItem.index];
                                const value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                return label + ': ' + value + ' suara';
                            }
                        }
                    }
                }
            });
            return kandidatDoughnutChart;
        }

        function updateCandidateDoughnutStats(candidates) {
            if (kandidatDoughnutChart) {
                kandidatDoughnutChart.data.labels = candidates.map(c => c.name);
                kandidatDoughnutChart.data.datasets[0].data = candidates.map(c => c.vote_count);
                kandidatDoughnutChart.update();
            }
        }

        $('.dropdown-doughnut').click(function(e) {
            e.preventDefault();
            console.log('Dropdown grade clicked.');

            $('#selected-class').text($(this).text());
            $('.dropdown-doughnut').removeClass('active');
            $(this).addClass('active');

            let gradeId = $(this).data('grade');

            // Tambahkan loading state
            $('#not-voted-count, #voted-count, #total-users').html('<i class="fas fa-spinner fa-spin"></i>');
            $('#candidate-stats').html('<i class="fas fa-spinner fa-spin"></i>');

            // Ajax request
            $.ajax({
                url: '<?= base_url('dashboard/getStatisticsByGrade') ?>/' + gradeId,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log('Response received:', response);

                    // Update statistik umum
                    $('#not-voted-count').text(response.statistics.not_voted || 0);
                    $('#voted-count').text(response.statistics.voted || 0);
                    $('#total-users').text(response.statistics.total_users || 0);

                    // Update statistik kandidat
                    updateCandidateDoughnutStats(response.candidates);


                },
                error: function(xhr, status, error) {
                    console.error('Ajax Error:', {
                        status: status,
                        error: error,
                        response: xhr.responseText
                    });

                    // Reset nilai
                    $('#not-voted-count, #voted-count, #total-users').text('0');
                    $('#candidate-stats').html('');
                    if (kandidatDoughnutChart) {
                        kandidatDoughnutChart.data.labels = [];
                        kandidatDoughnutChart.data.datasets[0].data = [];
                        kandidatDoughnutChart.update();
                    }

                    alert('Terjadi kesalahan saat mengambil data');
                }
            });
        });

        initializeKandidatDoughnutChart();
        updateCandidateDoughnutStats(<?= json_encode($allCount) ?>);

    });
</script>


<script>
    $(document).ready(function() {
        $('.grade-selector').on('click', function(e) {
            e.preventDefault();
            const gradeId = $(this).data('grade');
            const gradeName = $(this).text();

            $('#selected-grade-label').text(gradeName);
            $('.grade-selector').removeClass('active');
            $(this).addClass('active');

            $.ajax({
                url: '<?= base_url('dashboard/getStatisticsByGrade/') ?>' + gradeId,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        updateKandidatList(response.candidates);
                    }
                },
                error: function() {
                    alert('Gagal memuat data kandidat');
                }
            });
        });

        function updateKandidatList(candidates) {
            const $list = $('#kandidat-list');
            $list.empty();

            const totalVotes = candidates.reduce((sum, candidate) => sum + candidate.vote_count, 0);

            candidates.forEach(function(candidate) {
                const votePercentage = totalVotes > 0 ?
                    ((candidate.vote_count / totalVotes) * 100).toFixed(2) :
                    0;

                const voteWidth = totalVotes > 0 ?
                    Math.min(100, (candidate.vote_count / candidates[0].vote_count) * 100) :
                    0;

                const listItem = `
               <li class="media">
                   <img class="mr-3 rounded" width="55" 
                        src="<?= base_url('img/') ?>${candidate.image}" 
                        alt="${candidate.name}">
                   <div class="media-body">
                       <div class="float-right">
                           <div class="font-weight-600 text-muted text-small">
                               ${candidate.vote_count} Suara
                           </div>
                       </div>
                       <div class="media-title">${candidate.name}</div>
                       <div class="mt-1">
                           <div class="budget-price">
                               <div class="budget-price-square bg-primary" data-width="${voteWidth}%"></div>
                               <div class="budget-price-label">
                                   Persentase: ${votePercentage}%
                               </div>
                           </div>
                       </div>
                   </div>
               </li>
           `;
                $list.append(listItem);
            });
        }
    });
</script>

<?= $this->endSection() ?>

<?= $this->section('style') ?>
<style>
    .dropdown-menu {
        max-height: 250px;
        overflow-y: auto;
        min-width: 180px;
    }

    .dropdown-item {
        padding: 0.5rem 1.25rem;
        white-space: nowrap;
    }

    .dropdown-menu::-webkit-scrollbar {
        width: 4px;
    }

    .dropdown-menu::-webkit-scrollbar-thumb {
        background: #6777ef;
        border-radius: 4px;
    }

    .card-top {
        max-height: 400px;
        overflow-y: auto;
        position: relative;
    }

    .card-top::-webkit-scrollbar {
        width: 4px;
    }

    .card-top::-webkit-scrollbar-thumb {
        background: #6777ef;
        border-radius: 4px;
    }

    /* Memastikan konten tidak tertutup scrollbar */
    #kandidat-list {
        padding-right: 8px;
    }
</style>
<?= $this->endSection() ?>