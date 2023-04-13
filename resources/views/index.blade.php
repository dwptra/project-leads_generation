<!doctype html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link href="https://www.pngitem.com/pimgs/m/23-233352_project-lead-icon-clipart-png-download-project-lead.png" rel="icon">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">
                    <div class="wrap">
                        <div class="img" style="background-image: url(https://global-uploads.webflow.com/6100d0111a4ed76bc1b9fd54/634540d36aabaae1a3248446_perbedaan%20leader%20dan%20manager%201.jpg);"></div>
                        <div class="login-wrap p-4 p-md-5">
                            <div class="d-flex">
                                <div class="w-100">
                                    <h3 class="mb-4">Sign In </h3>
                                </div>
                            </div>
                            
                            {{-- Form Login --}}

                            <form action="{{ route('login.auth') }}" method="post" class="signin-form">
                                @csrf

                                {{-- Alert --}}

                                @if (Session::get('fail'))
                                <div class="alert alert-danger">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ Session::get('fail')}}
                                </div>
                                @endif
                                @if (Session::get('notAllowed'))
                                <div class="alert alert-danger">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ Session::get('notAllowed')}}
                                </div>
                                @endif
                                @if (Session::get('successLogout'))
                                <div class="alert alert-success">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ Session::get('successLogout')}}
                                </div>
                                @endif
                                
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                <div class="form-group mt-3">
                                    <input name="name" type="text" class="form-control" required>
                                    <label class="form-control-placeholder" for="username">Name</label>
                                </div>
                                <div class="form-group">
                                    <input name="password" id="password-field" type="password" class="form-control"
                                        required>
                                    <label class="form-control-placeholder" for="password">Password</label>
                                    <span toggle="#password-field"
                                        class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="form-control btn btn-dark rounded submit px-3">Sign In</button>
                                </div>                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>

</body>

</html>
