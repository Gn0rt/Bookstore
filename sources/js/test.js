document.addEventListener('DOMContentLoaded', function () {
    // Lưu trạng thái tab hiện tại vào localStorage
    function saveActiveTab(tabId) {
        localStorage.setItem('activeAdminTab', tabId);
    }

    // Lấy trạng thái tab từ localStorage
    function getActiveTab() {
        return localStorage.getItem('activeAdminTab') || 'dashboard'; // Mặc định là dashboard
    }

    // Khởi tạo tab dựa trên trạng thái đã lưu
    function initTabs() {
        const activeTabId = getActiveTab();

        // Kích hoạt tab và nội dung tương ứng
        document.querySelectorAll('.sidebar-item').forEach(item => {
            item.classList.remove('active');
            if (item.getAttribute('data-tab') === activeTabId) {
                item.classList.add('active');
            }
        });

        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.remove('active');
            if (content.id === activeTabId) {
                content.classList.add('active');
            }
        });
    }

    // Xử lý sự kiện click vào tab
    document.querySelectorAll('.sidebar-item').forEach(item => {
        item.addEventListener('click', function () {
            const tabId = this.getAttribute('data-tab');

            // Xóa trạng thái active của tất cả các tab và nội dung
            document.querySelectorAll('.sidebar-item').forEach(item => {
                item.classList.remove('active');
            });
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });

            // Thêm trạng thái active cho tab được chọn và nội dung tương ứng
            this.classList.add('active');
            document.getElementById(tabId).classList.add('active');

            // Lưu trạng thái tab hiện tại
            saveActiveTab(tabId);
        });
    });

    // Khởi tạo tab khi trang được tải
    initTabs();

    // Xử lý nút tìm kiếm
    const searchButton = document.querySelector('.search-box button');
    if (searchButton) {
        searchButton.addEventListener('click', function () {
            const searchValue = document.querySelector('.search-box input').value;
            alert('Đang tìm kiếm: ' + searchValue);
            // Thực hiện tìm kiếm ở đây
        });
    }

    // Xử lý nút thêm mới
    const addButtons = document.querySelectorAll('.btn-primary');
    addButtons.forEach(button => {
        button.addEventListener('click', function () {
            const tabId = document.querySelector('.tab-content.active').id;
            alert('Đang mở form thêm mới cho: ' + tabId);
            // Hiển thị form thêm mới ở đây
        });
    });

    // Xử lý nút chỉnh sửa
    const editButtons = document.querySelectorAll('.btn-edit');
    editButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.stopPropagation();
            const row = this.closest('tr');
            const id = row.querySelector('td:first-child').textContent;
            alert('Đang mở form chỉnh sửa cho ID: ' + id);
            // Hiển thị form chỉnh sửa ở đây
        });
    });

    // Xử lý nút xóa
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.stopPropagation();
            const row = this.closest('tr');
            const id = row.querySelector('td:first-child').textContent;
            if (confirm('Bạn có chắc chắn muốn xóa mục có ID: ' + id + '?')) {
                alert('Đã xóa mục có ID: ' + id);
                // Xóa dữ liệu ở đây
            }
        });
    });
});
