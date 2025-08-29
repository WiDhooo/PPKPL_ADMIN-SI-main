document.addEventListener("alpine:init", () => {
    Alpine.data("authPage", () => ({
        isLogin: true,
        showPassword: false,
        showConfirmPassword: false,
        email: "",
        password: "",
        confirmPassword: "",
        name: "",
        loading: false,

        validateEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        },

        validatePassword(password) {
            return this.password.length >= 8;
        },

        validateConfirmPassword() {
            return this.password === this.confirmPassword;
        },

        handleSubmit() {
            this.loading = true;
            setTimeout(() => {
                this.loading = false;
                alert(
                    this.isLogin
                        ? "Logged in successfully!"
                        : "Registered successfully!"
                );

                // Arahkan pengguna ke halaman beranda setelah login atau registrasi
                window.location.href = "/dashboard";
            }, 1500);
        },
    }));
});
