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
    <div class="container">
        <div class="row">
            <div class="col-md-8 mt-5">
                <img src="{{ asset('public/images/auth.png')}}" alt="auth" width="100%">
            </div>
            <div class=" col-md-4">
                @yield('content')
            </div>
        </div>
    </div>
</body>

</html>