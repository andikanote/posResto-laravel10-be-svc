<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login &mdash; Boetjah POS</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-social/bootstrap-social.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="d-flex align-items-stretch flex-wrap">
                <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
                    <div class="m-3 p-4">
                        <img src="{{ asset('img/stisla-fill.svg') }}" alt="logo" width="80"
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

    <!-- Modal for Forgot Password -->
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
        // Function to update greeting based on current time (GMT+7)
        function updateGreeting() {
            const now = new Date();
            // Get current hour in GMT+7 (WIB)
            const hours = now.getUTCHours() + 7;
            const adjustedHours = hours >= 24 ? hours - 24 : hours;

            const greetingElement = document.getElementById('greeting');
            let greeting;

            if (adjustedHours >= 0 && adjustedHours < 12) {
                greeting = 'Good Morning';
            } else if (adjustedHours >= 12 && adjustedHours < 16) {
                greeting = 'Good Afternoon';
            } else if (adjustedHours >= 16 && adjustedHours < 19) {
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
            $('#forgotPasswordModal').modal('show');
        });
    </script>

    <!-- General JS Scripts -->
    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('library/popper.js/dist/umd/popper.js') }}"></script>
    <script src="{{ asset('library/tooltip.js/dist/umd/tooltip.js') }}"></script>
    <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('library/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('js/stisla.js') }}"></script>

    <!-- JS Libraies -->

    <!-- Page Specific JS File -->

    <!-- Template JS File -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>

</html>
