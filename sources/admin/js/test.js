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

});

// Thêm đoạn này vào cuối file JavaScript của bạn để debug
console.log('Tab elements:', document.querySelectorAll('.sidebar-item'));
console.log('Active tab elements:', document.querySelectorAll('.sidebar-item.active'));

