function selectPayment(method) {
    document.getElementById("paymentMethod").value = method;
    document.getElementById("selectedPayment").textContent = method;
}

// Xóa dữ liệu form khi đóng Modal
document.getElementById("buyProductModal").addEventListener("hidden.bs.modal", function () {
    document.getElementById("buyForm").reset();
    document.getElementById("selectedPayment").textContent = "Chưa chọn";
});

document.getElementById("paymentMethod").addEventListener("change", function () {
    var qrCodeContainer = document.getElementById("qrCodeContainer");

    if (this.value === "online") {
        qrCodeContainer.style.display = "block";  // Hiển thị mã QR
    } else {
        qrCodeContainer.style.display = "none";   // Ẩn mã QR
    }
});
