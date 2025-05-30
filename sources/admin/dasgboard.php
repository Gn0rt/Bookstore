<?php 
    include_once '../classes/order.php';

?>
<?php 
    $od = new order();

?>
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Doanh thu năm <?= date('Y') ?></h5>
                <p class="card-text h4">
                    <?= number_format($od->getAnnualRevenue(), 0, ',', '.') ?>đ
                </p>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <form method="get" class="row g-3">
            <input type="hidden" name="tab" value="dashboard">
            <div class="col-md-4">
                <select name="year" class="form-select" onchange="this.form.submit()">
                    <?php 
                    $currentYear = date('Y');
                    $selectedYear = isset($_GET['year']) ? $_GET['year'] : $currentYear;
                    for ($y = $currentYear; $y >= $currentYear - 5; $y--) {
                        $selected = $y == $selectedYear ? 'selected' : '';
                        echo "<option value='$y' $selected>$y</option>";
                    }
                    ?>
                </select>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <canvas id="revenueChart" height="100"></canvas>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Lấy dữ liệu từ PHP qua biến JSON
    const revenueData = <?= json_encode($od->getMonthlyRevenue($selectedYear)) ?>;
    
    // Chuyển đổi dữ liệu thành mảng 12 tháng
    const months = ['Th1', 'Th2', 'Th3', 'Th4', 'Th5', 'Th6', 'Th7', 'Th8', 'Th9', 'Th10', 'Th11', 'Th12'];
    const revenueValues = Object.values(revenueData);
    
    // Vẽ biểu đồ
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Doanh thu theo tháng (VNĐ)',
                data: revenueValues,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString() + 'đ';
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y.toLocaleString() + 'đ';
                        }
                    }
                }
            }
        }
    });
});
</script>
