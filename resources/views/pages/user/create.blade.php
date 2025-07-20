@extends('layouts.app')

@section('title', 'Add User')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Form Add User</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Forms</a></div>
                    <div class="breadcrumb-item">List Users</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">List Users</h2>

                <div class="card">
                    <form action="{{ route('user.store') }}" method="POST">
                        @csrf
                        <div class="card-header">
                            <h4>Add User Form</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" placeholder="Enter user's full name">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            name="email" placeholder="example@domain.com">
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-phone"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                                name="phone" id="phone-input" placeholder="Maksimum phone number 13 digits"
                                                oninput="validatePhoneNumber(this)" maxlength="13">
                                        </div>
                                        <small id="phone-error" class="text-danger d-none">Field Phone Number can only be filled
                                            with numbers 0 to 9 and maximum 13 digits.</small>
                                        @error('phone')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <small class="text-muted d-block mb-2">
                                            <i class="fas fa-info-circle"></i> Password must contain:
                                        </small>
                                        <ul class="text-muted small pl-4 mb-2">
                                            <li id="length-requirement" class="text-danger"></i> Minimum 8 characters</li>
                                            <li id="number-requirement" class="text-danger"></i> At least 1 number</li>
                                            <li id="special-requirement" class="text-danger"></i> At least 1 special character</li>
                                            <li id="case-requirement" class="text-danger"></i> Both uppercase and lowercase letters</li>
                                        </ul>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-lock"></i>
                                                </div>
                                            </div>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                                name="password" id="password-input" placeholder="Create a strong password"
                                                onkeyup="checkPasswordStrength()">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button" id="generate-password">
                                                    <i class="fas fa-sync-alt"></i>
                                                </button>
                                                <span class="input-group-text">
                                                    <i class="fas fa-eye" id="toggle-password" style="cursor:pointer"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="progress mt-2" style="height: 5px;">
                                            <div id="password-strength-bar" class="progress-bar bg-danger" role="progressbar"
                                                style="width: 0%"></div>
                                        </div>
                                        <small id="password-strength-text" class="text-muted"></small>
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">User Role</label>
                                        <div class="selectgroup w-100">
                                            <label class="selectgroup-item">
                                                <input type="radio" name="roles" value="ADMIN" class="selectgroup-input"
                                                    checked>
                                                <span class="selectgroup-button">Admin</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="roles" value="STAFF" class="selectgroup-input">
                                                <span class="selectgroup-button">Staff</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="roles" value="USER" class="selectgroup-input">
                                                <span class="selectgroup-button">User</span>
                                            </label>
                                        </div>
                                        @error('roles')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{ url()->previous() }}" class="btn btn-danger mr-2">Back</a>
                            <button class="btn btn-primary">Create User</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        function checkPasswordStrength() {
            const password = document.getElementById('password-input').value;
            const strengthBar = document.getElementById('password-strength-bar');
            const strengthText = document.getElementById('password-strength-text');
            const requirements = {
                length: password.length >= 8,
                number: /\d/.test(password),
                special: /[!@#$%^&*(),.?":{}|<>]/.test(password),
                case: /[a-z]/.test(password) && /[A-Z]/.test(password)
            };

            // Update requirement indicators
            document.getElementById('length-requirement').className = requirements.length ? 'text-success' : 'text-danger';
            document.getElementById('number-requirement').className = requirements.number ? 'text-success' : 'text-danger';
            document.getElementById('special-requirement').className = requirements.special ? 'text-success' : 'text-danger';
            document.getElementById('case-requirement').className = requirements.case ? 'text-success' : 'text-danger';

            // Calculate strength score (0-100)
            const strength = Object.values(requirements).filter(Boolean).length * 25;

            // Update progress bar
            strengthBar.style.width = strength + '%';

            // Update colors and text based on strength
            if (strength < 25) {
                strengthBar.className = 'progress-bar bg-danger';
                strengthText.textContent = 'Very Weak';
            } else if (strength < 50) {
                strengthBar.className = 'progress-bar bg-warning';
                strengthText.textContent = 'Weak';
            } else if (strength < 75) {
                strengthBar.className = 'progress-bar bg-info';
                strengthText.textContent = 'Moderate';
            } else if (strength < 100) {
                strengthBar.className = 'progress-bar bg-primary';
                strengthText.textContent = 'Strong';
            } else {
                strengthBar.className = 'progress-bar bg-success';
                strengthText.textContent = 'Very Strong';
            }
        }

        // Toggle password visibility
        document.getElementById('toggle-password').addEventListener('click', function() {
            const passwordInput = document.getElementById('password-input');
            const icon = this;
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                passwordInput.type = 'password';
                icon.className = 'fas fa-eye';
            }
        });

        // Generate random password
        document.getElementById('generate-password').addEventListener('click', function() {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            const numbers = '0123456789';
            const specials = '!@#$%^&*()_+~`|}{[]\:;?><,./-=';

            // Ensure we have at least one of each required character type
            let password = [
                chars.charAt(Math.floor(Math.random() * chars.length)), // random uppercase
                chars.charAt(Math.floor(Math.random() * chars.length)).toLowerCase(), // random lowercase
                numbers.charAt(Math.floor(Math.random() * numbers.length)),
                specials.charAt(Math.floor(Math.random() * specials.length))
            ];

            // Fill the rest with random characters
            const remainingLength = 12 - password.length; // Generate 12-character password
            const allChars = chars + numbers + specials;
            for (let i = 0; i < remainingLength; i++) {
                password.push(allChars.charAt(Math.floor(Math.random() * allChars.length)));
            }

            // Shuffle the array to mix the characters
            password = password.sort(() => Math.random() - 0.5).join('');

            // Set the password and trigger strength check
            const passwordInput = document.getElementById('password-input');
            passwordInput.value = password;
            passwordInput.type = 'text'; // Show the generated password
            document.getElementById('toggle-password').className = 'fas fa-eye-slash';
            checkPasswordStrength();
        });

        function validatePhoneNumber(input) {
            const errorElement = document.getElementById('phone-error');
            const originalValue = input.value;
            const numericValue = originalValue.replace(/[^0-9]/g, '');

            // Check if any non-numeric characters were removed or if length exceeds 13
            if (originalValue !== numericValue || numericValue.length > 13) {
                // Show error message
                errorElement.classList.remove('d-none');
                // Set timeout to hide error after 3 seconds
                setTimeout(() => {
                    errorElement.classList.add('d-none');
                }, 3000);
            } else {
                errorElement.classList.add('d-none');
            }

            // Update the input value with only numbers (max 13 digits)
            input.value = numericValue.slice(0, 13);
        }
    </script>
@endpush
