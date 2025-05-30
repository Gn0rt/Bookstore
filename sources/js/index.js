document.addEventListener("DOMContentLoaded", () => {
    // Lấy tất cả các phần "care"
    const careSections = document.querySelectorAll(".care");

    careSections.forEach(section => {
        // Tìm các thành phần trong mỗi phần care
        const wrappers = section.querySelectorAll(".book__care-box");
        const prevButton = section.querySelector(".prev-button");
        const nextButton = section.querySelector(".next-button");

        // Nếu không có wrapper hoặc nút điều hướng, bỏ qua phần này
        if (!wrappers.length || !prevButton || !nextButton) return;

        // Khởi tạo chức năng điều hướng cho phần này
        initNavigation(section, wrappers, prevButton, nextButton);
    });

    function initNavigation(section, wrappers, prevButton, nextButton) {
        // Tìm wrapper đang active
        let activeWrapper = section.querySelector(".book__care-box.active") || wrappers[0];
        if (!activeWrapper) return;

        // Lưu trạng thái cho mỗi wrapper
        const wrapperStates = {};
        wrappers.forEach(wrapper => {
            const id = wrapper.id;
            wrapperStates[id] = {
                currentIndex: 0,
                container: wrapper.querySelector(".book__care-container"),
                items: wrapper.querySelectorAll(".book__care-content-item")
            };
        });

        // Xử lý nút prev
        prevButton.addEventListener("click", () => {
            const id = activeWrapper.id;
            const state = wrapperStates[id];

            if (!state || !state.items.length) return;

            state.currentIndex = state.currentIndex > 0 ?
                state.currentIndex - 1 : state.items.length - 1;

            updateSlide(state);
        });

        // Xử lý nút next
        nextButton.addEventListener("click", () => {
            const id = activeWrapper.id;
            const state = wrapperStates[id];

            if (!state || !state.items.length) return;

            state.currentIndex = state.currentIndex < state.items.length - 1 ?
                state.currentIndex + 1 : 0;

            updateSlide(state);
        });

        // Cập nhật vị trí slide
        function updateSlide(state) {
            if (!state.container || !state.items.length) return;

            const itemWidth = state.items[0].offsetWidth;
            const offset = -state.currentIndex * itemWidth;
            state.container.style.transform = `translateX(${offset}px)`;
        }

        // Xử lý tab navigation (nếu có)
        const menuItems = section.querySelectorAll(".book__care-item");
        if (menuItems.length) {
            menuItems.forEach(item => {
                item.addEventListener("click", () => {
                    // Xóa class active khỏi tất cả menu items
                    section.querySelector(".book__care-item.active")?.classList.remove("active");
                    item.classList.add("active");

                    // Lấy target của phần được chọn
                    let target = item.getAttribute("data-target");
                    let targetWrapper = document.getElementById(target);

                    // Ẩn tất cả wrapper, chỉ hiển thị wrapper được chọn
                    wrappers.forEach(w => w.classList.remove("active"));

                    if (targetWrapper) {
                        targetWrapper.classList.add("active");
                        activeWrapper = targetWrapper;
                    }
                });
            });
        }

        // Khởi tạo trạng thái ban đầu
        const initialState = wrapperStates[activeWrapper.id];
        if (initialState) {
            updateSlide(initialState);
        }
    }
});
