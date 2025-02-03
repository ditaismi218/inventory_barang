<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Purple Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('asset') }}/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{ asset('asset') }}/assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="{{ asset('asset') }}/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="{{ asset('asset') }}/assets/vendors/font-awesome/css/font-awesome.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('asset') }}/assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('asset') }}/assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                  <img src="{{ asset('asset') }}/assets/images/logo.svg">
                </div>
                <h4>Hello! let's get started</h4>
                {{-- <h6 class="font-weight-light">Sign in to continue.</h6> --}}

                 <!-- Form Login -->
                 <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <!-- Username -->
                    <div class="mb-3">
                        <input type="text" name="user_nama" class="form-control" placeholder="Enter Username"
                            value="{{ old('user_nama') }}" required>
                        @error('user_nama')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <input type="password" name="user_pass" class="form-control"
                            placeholder="Enter Password" required>
                        @error('user_pass')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="customCheck">
                        <label class="form-check-label" for="customCheck">Remember Me</label>
                    </div>

                    <!-- Tombol Login -->
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset('asset') }}/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('asset') }}/assets/js/off-canvas.js"></script>
    <script src="{{ asset('asset') }}/assets/js/misc.js"></script>
    <script src="{{ asset('asset') }}/assets/js/settings.js"></script>
    <script src="{{ asset('asset') }}/assets/js/todolist.js"></script>
    <script src="{{ asset('asset') }}/assets/js/jquery.cookie.js"></script>
    <!-- endinject -->
  </body>
</html>