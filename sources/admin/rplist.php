<?php
include '../classes/product.php';
?>

<div class="report-container">
    <!-- Form tìm kiếm -->
    <div class="report-search-section">
        <form id="topSellingForm" class="report-form" action="javascript:void(0);">
            <div class="report-form-group">
                <label for="report-month">Chọn tháng:</label>
                <select name="month" id="report-month" class="report-select">
                    <?php for ($m = 1; $m <= 12; $m++): ?>
                        <option value="<?= $m ?>"><?= $m ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            
            <div class="report-form-group">
                <label for="report-year">Chọn năm:</label>
                <select name="year" id="report-year" class="report-select">
                    <?php for ($y = date('Y'); $y >= 2000; $y--): ?>
                        <option value="<?= $y ?>"><?= $y ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            
            <button type="submit" class="report-btn" id="findTopSellingBtn">Tìm kiếm</button>
        </form>
    </div>

    <!-- Kết quả tìm kiếm -->
    <div id="topSellingResults" class="report-results">
        <!-- Kết quả sẽ được hiển thị ở đây qua AJAX -->
    </div>
</div>

<!-- Thêm CSS inline hoặc trong file CSS riêng -->
<style>
.report-container {
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    margin-bottom: 20px;
}

.report-search-section {
    margin-bottom: 20px;
}

.report-form {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    align-items: flex-end;
}

.report-form-group {
    display: flex;
    flex-direction: column;
    min-width: 200px;
}

.report-form-group label {
    margin-bottom: 5px;
    font-weight: 500;
    color: #555;
}

.report-select {
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

.report-btn {
    padding: 9px 15px;
    background-color: #3498db;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
}

.report-btn:hover {
    background-color: #2980b9;
}

.report-results {
    margin-top: 20px;
}

.report-table {
    width: 100%;
    border-collapse: collapse;
}

.report-table th, 
.report-table td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #f1f1f1;
}

.report-table th {
    background-color: #f8f9fa;
    font-weight: 500;
}

.report-table tr:hover {
    background-color: #f9f9f9;
}

.report-title {
    font-size: 18px;
    margin-bottom: 15px;
    color: #333;
    font-weight: 500;
}

.report-no-data {
    padding: 20px;
    text-align: center;
    color: #777;
    font-style: italic;
}
</style>


<script>
(function() {
    // Biến cục bộ để tránh xung đột với các biến toàn cục
    const topSellingForm = document.getElementById('topSellingForm');
    const resultsContainer = document.getElementById('topSellingResults');
    
    if (topSellingForm) {
        topSellingForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Hiển thị trạng thái đang tải
            if (resultsContainer) {
                resultsContainer.innerHTML = '<div class="report-loading">Đang tải dữ liệu...</div>';
            }
            
            const formData = new FormData(this);
            formData.append('findTopSelling', 'true');
            
            // Gửi request AJAX
            fetch('process_top_selling.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (resultsContainer) {
                    resultsContainer.innerHTML = data;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (resultsContainer) {
                    resultsContainer.innerHTML = '<div class="report-error">Đã xảy ra lỗi khi tải dữ liệu. Vui lòng thử lại.</div>';
                }
            });
        });
    }
})(); // Sử dụng IIFE để tạo scope riêng
</script>