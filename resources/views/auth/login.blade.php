<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log In</title>
    <!-- core:css -->
    <link rel="stylesheet" href="{{asset('backend')}}/assets/vendors/core/core.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- end plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{asset('backend')}}/assets/fonts/feather-font/css/iconfont.css">
    <link rel="stylesheet" href="{{asset('backend')}}/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <!-- endinject -->
    <!-- Layout styles -->  
    <link rel="stylesheet" href="{{asset('backend')}}/assets/css/demo_1/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{asset('backend')}}/assets/images/favicon.png" />
</head>
<body>
	<div class="main-wrapper">
		<div class="page-wrapper full-page">
			<div class="page-content d-flex align-items-center justify-content-center">
                <div class="col-md-5 pl-md-0">
                  <div class="card">
                    <div class="card-body">
                        <div class="auth-form-wrapper px-4 py-5">
                            <div class="mb-3 text-center">
                                <a href="#" class="noble-ui-logo d-block mb-2">Web<span>Artist</span></a>
                                <h5 class="text-muted font-weight-normal mb-4">Welcome back! Log in to your account.</h5>
                            </div>
                            <form class="forms-sample" action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" name="email">
                                    @error('email')
                                        <strong class="text-danger">{{$message}}</strong>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1" autocomplete="current-password" placeholder="Password" name="password">
                                    @error('password')
                                        <strong class="text-danger">{{$message}}</strong>
                                    @enderror
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn w-100 btn-primary mr-2 mb-2 mb-md-0 text-white">Login</button>
                                </div>
                            </form>
                          </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>

    <!-- core:js -->
    <script src="{{asset('backend')}}/assets/vendors/core/core.js"></script>
    <!-- endinject -->
    <!-- plugin js for this page -->
    <!-- end plugin js for this page -->
    <!-- inject:js -->
    <script src="{{asset('backend')}}/assets/vendors/feather-icons/feather.min.js"></script>
    <script src="{{asset('backend')}}/assets/js/template.js"></script>
    <!-- endinject -->
    <!-- custom js for this page -->
    <!-- end custom js for this page -->
</body>
</html>