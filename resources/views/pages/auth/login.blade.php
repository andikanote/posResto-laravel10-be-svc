<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login &mdash; Boetjah POS</title>
    <link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{{ asset('library/bootstrap-social/bootstrap-social.css') }}">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">

    <style>
        /* Optional: Add custom styles here for fine-tuning layout or design */
        /* Example: Adjusting spacing for form elements on small screens */
        @media (max-width: 767.98px) {
            .m-3.p-4 {
                margin: 1.5rem !important; /* Adjust overall margin */
                padding: 1.5rem !important; /* Adjust overall padding */
            }
        }

        /* Ensure the background image covers the area properly */
        .background-walk-y {
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="d-flex align-items-stretch flex-wrap">
                <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
                    <div class="m-3 p-4">
                        <img src="{{ asset('img/logo.png') }}" alt="logo" width="80"
                            class="shadow-light rounded-circle mb-5 mt-2">
                        <h4 class="text-dark font-weight-normal">Welcome to <span class="font-weight-bold">Boetjah CMS</span>
                        </h4>
                        <p class="text-muted">Before you get started, you must login or register if you don't already
                            have an account.</p>
                        <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
                            @csrf
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    tabindex="1" required autofocus value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @else
                                    <div class="invalid-feedback">
                                        Please fill in your email
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="d-block">
                                    <label for="password" class="control-label">Password</label>
                                    <div class="float-right">
                                        <a href="#" class="text-small" id="forgotPasswordLink">
                                            Forgot Password?
                                        </a>
                                    </div>
                                </div>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    tabindex="2" required>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @else
                                    <div class="invalid-feedback">
                                        please fill in your password
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="remember" class="custom-control-input" tabindex="3"
                                        id="remember-me" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="remember-me">Remember Me</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                    Login
                                </button>
                            </div>
                        </form>

                        <div class="mt-5 text-center">
                            Don't have an account? <a href="{{ route('register') }}">Create new account</a>
                        </div>

                        <div class="text-small mt-5 text-center">
                            Copyright &copy; PT Boetjah Kampoeng Indonesia 💙
                            <div class="mt-2">
                                <a href="#">Privacy Policy</a>
                                <div class="bullet"></div>
                                <a href="#">Terms of Service</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-12 order-lg-2 min-vh-100 background-walk-y position-relative overlay-gradient-bottom order-1"
                    data-background="{{ asset('img/unsplash/login-bg4.jpg') }}">
                    <div class="absolute-bottom-left index-2">
                        <div class="text-light p-5 pb-2">
                            <div class="mb-5 pb-3">
                                <h1 class="display-4 font-weight-bold mb-2" id="greeting">Good Morning</h1>
                                <h5 class="font-weight-normal text-muted-transparent">PT Boetjah Kampoeng Indonesia, POSIn</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" role="dialog" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="forgotPasswordModalLabel">Forgot Password</h5>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> --}}
                </div>
                <div class="modal-body">
                    Halaman Forgot Password Under Maintenance
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to update greeting based on current time (GMT+7, WIB)
        function updateGreeting() {
            const now = new Date();
            // Get current hour in GMT (UTC)
            const utcHours = now.getUTCHours();
            // Add 7 hours for WIB (GMT+7)
            let wibHours = utcHours + 7;

            // Adjust if hours go beyond 24 (next day)
            if (wibHours >= 24) {
                wibHours -= 24;
            } else if (wibHours < 0) { // Should not happen with +7, but for completeness
                wibHours += 24;
            }

            const greetingElement = document.getElementById('greeting');
            let greeting;

            if (wibHours >= 0 && wibHours < 12) {
                greeting = 'Good Morning';
            } else if (wibHours >= 12 && wibHours < 16) {
                greeting = 'Good Afternoon';
            } else if (wibHours >= 16 && wibHours < 19) {
                greeting = 'Good Evening';
            } else {
                greeting = 'Good Night';
            }

            greetingElement.textContent = greeting;
        }

        // Update greeting on page load
        updateGreeting();

        // Update greeting every minute to handle changes
        setInterval(updateGreeting, 60000);

        // Forgot Password link click handler
        document.getElementById('forgotPasswordLink').addEventListener('click', function(e) {
            e.preventDefault();
            // Using jQuery for Bootstrap modal
            $('#forgotPasswordModal').modal('show');
        });
    </script>

    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('library/popper.js/dist/umd/popper.js') }}"></script>
    <script src="{{ asset('library/tooltip.js/dist/umd/tooltip.js') }}"></script>
    <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('library/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('js/stisla.js') }}"></script>

    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>

</html>
