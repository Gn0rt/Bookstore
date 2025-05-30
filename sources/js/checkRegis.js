const regEmail = document.querySelector("#reg_email");
const password = document.querySelector("#reg_password");
const fullname = document.querySelector("#fullname");
const confirmPassword = document.getElementById('confirm_password');
const phone = document.querySelector("#phone");
const email = document.querySelector("#email");
const registerButton = document.querySelector('button[type="submit"][name="register"]');
console.log(registerButton)

function validateForm() {
    const emailValid = regEmail.classList.contains("is-valid");
    const passwordValid = password.value !== "";
    const confirmPasswordValid = password.value === confirmPassword.value;
    const fullnameValid = fullname.value !== "";
    const phoneValid = phone.classList.contains("is-valid");

    // Kích hoạt nút nếu tất cả các trường hợp hợp lệ
    registerButton.disabled = !(emailValid && passwordValid && confirmPasswordValid && fullnameValid && phoneValid);
}
// Kiểm tra mật khẩu trực tiếp khi người dùng nhập
document.getElementById('confirm_password').addEventListener('input', function () {
    const password = document.getElementById('reg_password').value;
    const confirmPassword = this.value;
    const feedbackElement = document.getElementById('password-feedback');

    if (password !== confirmPassword) {
        this.classList.add('is-invalid');
        feedbackElement.textContent = 'Mật khẩu nhập lại không khớp!';
        feedbackElement.style.display = 'block';
    } else {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
        feedbackElement.style.display = 'none';
    }
});
regEmail.addEventListener('input', function () {
    const emailValue = regEmail.value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (emailValue === "") {
        this.classList.add("is-invalid");
    }
    else if (!emailRegex.test(emailValue)) {
        this.classList.add("is-invalid");
        this.classList.remove("is-valid");
    }
    else {
        this.classList.remove("is-invalid");
        this.classList.add("is-valid");
    }
    validateForm(); // Kiểm tra lại tính hợp lệ
})
email.addEventListener('input', function () {
    const emailValue = email.value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (emailValue === "") {
        this.classList.add("is-invalid");
    }
    else if (!emailRegex.test(emailValue)) {
        this.classList.add("is-invalid");
        this.classList.remove("is-valid");
    }
    else {
        this.classList.remove("is-invalid");
        this.classList.add("is-valid");
    }
})

password.addEventListener('input', function () {
    const passwordlValue = password.value;
    if (passwordlValue === "") {
        this.classList.add("is-invalid");
    }
    else {
        this.classList.remove("is-invalid");
        this.classList.add("is-valid");
    }
    validateForm(); // Kiểm tra lại tính hợp lệ
})


fullname.addEventListener('input', function () {
    const fullnameValue = fullname.value;
    if (fullnameValue === "") {
        this.classList.add("is-invalid");
    }
    else {
        this.classList.remove("is-invalid");
        this.classList.add("is-valid");
    }
    validateForm(); // Kiểm tra lại tính hợp lệ
})


phone.addEventListener('input', function () {
    const phoneValue = phone.value;
    const phoneRegex = /^\d{10}$/;
    if (phoneValue === "") {
        this.classList.add("is-invalid");
    }
    else if (!phoneRegex.test(phoneValue)) {
        this.classList.add("is-invalid");
        this.classList.remove("is-valid");
    }
    else {
        this.classList.remove("is-invalid");
        this.classList.add("is-valid");
    }
    validateForm(); // Kiểm tra lại tính hợp lệ
})