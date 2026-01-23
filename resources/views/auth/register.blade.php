<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Money Tracking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>

<body>
    <!-- Floating elements -->
    <div id="floating-elements"></div>

    <div class="container">
        <div class="register-card card">
            <div class="card-body">
                <div class="brand-section">
                    <div class="brand-icon">
                        <i class="bi bi-person-plus-fill"></i>
                    </div>
                    <h1 class="brand-title">Buat Akun Baru</h1>
                    <p class="brand-subtitle">Mulai perjalanan finansial Anda dengan Money Tracking</p>
                </div>

                <!-- Progress Steps -->
                <div class="progress-steps">
                    <div class="progress-bar" id="progressBar" style="width: 0%"></div>
                    <div class="step active" data-step="1">
                        <div class="step-number">1</div>
                        <div class="step-label">Data Diri</div>
                    </div>
                    <div class="step" data-step="2">
                        <div class="step-number">2</div>
                        <div class="step-label">Akun</div>
                    </div>
                    <div class="step" data-step="3">
                        <div class="step-number">3</div>
                        <div class="step-label">Selesai</div>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div class="d-inline-block">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" id="registerForm">
                    @csrf

                    <div class="form-group">
                        <label for="name" class="form-label">
                            <i class="bi bi-person"></i>Nama Lengkap
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ old('name') }}"
                                placeholder="Masukkan nama lengkap" required autofocus>
                        </div>
                        @error('name')
                            <div class="error-message">
                                <i class="bi bi-exclamation-circle"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="bi bi-envelope"></i>Email
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com"
                                required>
                        </div>
                        <div class="hint-text">
                            <i class="bi bi-info-circle"></i>Gunakan email aktif untuk verifikasi
                        </div>
                        @error('email')
                            <div class="error-message">
                                <i class="bi bi-exclamation-circle"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="bi bi-lock"></i>Password
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="Buat password yang kuat" required>
                            <button type="button" class="password-toggle" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div class="password-strength">
                            <div class="strength-bar">
                                <div class="strength-fill" id="strengthFill"></div>
                            </div>
                            <div class="strength-text" id="strengthText">Lemah</div>
                        </div>
                        <div class="hint-text">
                            <i class="bi bi-lightbulb"></i>Minimal 8 karakter dengan kombinasi huruf dan angka
                        </div>
                        @error('password')
                            <div class="error-message">
                                <i class="bi bi-exclamation-circle"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">
                            <i class="bi bi-lock-fill"></i>Konfirmasi Password
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" placeholder="Ulangi password" required>
                            <button type="button" class="password-toggle" id="toggleConfirmPassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div id="passwordMatch" class="hint-text" style="display: none;">
                            <i class="bi bi-check-circle-fill text-success"></i>Password cocok
                        </div>
                    </div>

                    <div class="terms-check">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="terms" required>
                            <label class="form-check-label" for="terms">
                                Saya setuju dengan <a href="#">Syarat dan Ketentuan</a> serta
                                <a href="#">Kebijakan Privasi</a> Money Tracking. Saya memahami bahwa
                                data saya akan diproses sesuai dengan peraturan yang berlaku.
                            </label>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-gradient" id="submitBtn">
                            <i class="bi bi-person-check"></i>Buat Akun Sekarang
                        </button>
                    </div>
                </form>

                <div class="login-link">
                    <p class="mb-0">
                        Sudah punya akun?
                        <a href="{{ route('login') }}">
                            Login di sini <i class="bi bi-arrow-right-short"></i>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize floating elements
        function createFloatingElements() {
            const container = document.getElementById('floating-elements');
            const elementCount = 12;

            for (let i = 0; i < elementCount; i++) {
                const element = document.createElement('div');
                element.classList.add('floating-element');

                // Random properties
                const size = Math.random() * 100 + 30;
                const x = Math.random() * 100;
                const y = Math.random() * 100;
                const delay = Math.random() * 25;
                const duration = Math.random() * 40 + 25;

                element.style.width = `${size}px`;
                element.style.height = `${size}px`;
                element.style.left = `${x}%`;
                element.style.top = `${y}%`;
                element.style.opacity = Math.random() * 0.15 + 0.05;
                element.style.animationDelay = `${delay}s`;
                element.style.animationDuration = `${duration}s`;
                element.style.borderRadius = Math.random() > 0.5 ? '50%' : '30%';

                container.appendChild(element);
            }
        }

        // Password strength checker
        function checkPasswordStrength(password) {
            let strength = 0;
            const strengthFill = document.getElementById('strengthFill');
            const strengthText = document.getElementById('strengthText');

            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;

            // Update strength bar
            const width = strength * 25;
            strengthFill.style.width = `${width}%`;

            // Update text and color
            switch (strength) {
                case 0:
                case 1:
                    strengthFill.style.background = '#f56565';
                    strengthText.textContent = 'Lemah';
                    strengthText.style.color = '#f56565';
                    break;
                case 2:
                    strengthFill.style.background = '#ed8936';
                    strengthText.textContent = 'Cukup';
                    strengthText.style.color = '#ed8936';
                    break;
                case 3:
                    strengthFill.style.background = '#4299e1';
                    strengthText.textContent = 'Baik';
                    strengthText.style.color = '#4299e1';
                    break;
                case 4:
                    strengthFill.style.background = '#48bb78';
                    strengthText.textContent = 'Sangat Baik';
                    strengthText.style.color = '#48bb78';
                    break;
            }

            return strength;
        }

        // Password visibility toggle
        function setupPasswordToggle(inputId, buttonId) {
            const toggleBtn = document.getElementById(buttonId);
            const passwordInput = document.getElementById(inputId);

            if (toggleBtn && passwordInput) {
                toggleBtn.addEventListener('click', function() {
                    const icon = this.querySelector('i');

                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        icon.classList.remove('bi-eye');
                        icon.classList.add('bi-eye-slash');
                    } else {
                        passwordInput.type = 'password';
                        icon.classList.remove('bi-eye-slash');
                        icon.classList.add('bi-eye');
                    }
                });
            }
        }

        // Check password match
        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const matchText = document.getElementById('passwordMatch');

            if (confirmPassword.length === 0) {
                matchText.style.display = 'none';
                return;
            }

            if (password === confirmPassword) {
                matchText.innerHTML = '<i class="bi bi-check-circle-fill text-success"></i>Password cocok';
                matchText.style.color = '#48bb78';
                matchText.style.display = 'flex';
            } else {
                matchText.innerHTML = '<i class="bi bi-x-circle-fill text-danger"></i>Password tidak cocok';
                matchText.style.color = '#f56565';
                matchText.style.display = 'flex';
            }
        }

        // Update progress bar
        function updateProgressBar() {
            const inputs = document.querySelectorAll('#registerForm input[required]');
            let filledCount = 0;

            inputs.forEach(input => {
                if (input.value.trim() !== '') {
                    filledCount++;
                }
            });

            const progress = (filledCount / inputs.length) * 100;
            document.getElementById('progressBar').style.width = `${progress}%`;

            // Update steps
            const steps = document.querySelectorAll('.step');
            if (progress >= 33) {
                steps[0].classList.add('active');
            }
            if (progress >= 66) {
                steps[1].classList.add('active');
            }
            if (progress >= 100) {
                steps[2].classList.add('active');
            }
        }

        // Form submission
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            const originalText = submitBtn.innerHTML;

            if (!document.getElementById('terms').checked) {
                e.preventDefault();
                alert('Harap setujui Syarat dan Ketentuan terlebih dahulu.');
                return;
            }

            submitBtn.innerHTML = '<i class="bi bi-arrow-repeat spin"></i>Membuat Akun...';
            submitBtn.disabled = true;

            // Add spin animation
            const spinStyle = document.createElement('style');
            spinStyle.innerHTML = `
                @keyframes spin {
                    from { transform: rotate(0deg); }
                    to { transform: rotate(360deg); }
                }
                .spin {
                    animation: spin 1s linear infinite;
                }
            `;
            document.head.appendChild(spinStyle);
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            createFloatingElements();
            setupPasswordToggle('password', 'togglePassword');
            setupPasswordToggle('password_confirmation', 'toggleConfirmPassword');

            // Real-time validation
            document.getElementById('password').addEventListener('input', function() {
                checkPasswordStrength(this.value);
                checkPasswordMatch();
                updateProgressBar();
            });

            document.getElementById('password_confirmation').addEventListener('input', function() {
                checkPasswordMatch();
                updateProgressBar();
            });

            const otherInputs = ['name', 'email'];
            otherInputs.forEach(id => {
                document.getElementById(id).addEventListener('input', updateProgressBar);
            });

            document.getElementById('terms').addEventListener('change', updateProgressBar);

            // Initial progress check
            updateProgressBar();
        });
    </script>
</body>

</html>
