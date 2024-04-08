<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>Task Tracking MIS</title>
    <link rel="stylesheet" href="{{asset('public/css/app.css')}}">

</head>

<body>
    <div class="auth-main">
        <div class="auth-container">
            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <div class="col-md-6 d-md-block d-none">
                        <img src="{{ asset('public/images/auth.png')}}" alt="auth" width="100%">
                    </div>
                    <div class=" col-md-6" id="app">
                        @if(Session::has('success-message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{Session::get('success-message')}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('public/js/app.js')}}"></script>

</body>

</html>