<!doctype html>
<html lang="en">

<head>
    <title>Task Tracking MIS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


    <link rel="stylesheet" href="{{ asset('public/css/app.css')}}">
    <link rel="stylesheet" href="{{ asset('public/sidebar/css/style.css')}}">
</head>

<body>

    <div class="wrapper d-flex align-items-stretch" id="app">
        <nav id="sidebar">
            <div class="p-4 pt-5">
                <a href="#">
                    <img class="img logo mb-5" src="{{asset('public/images/task_logo.png')}}" alt="logo">
                </a>
                <ul class=" list-unstyled components mb-5">
                    <li class="active">
                        <a href="#homeSubmenu" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="homeSubmenu">Management
                            <i class="fa fa-angle-down float-end mt-2"></i></a>
                        <ul class="collapse list-unstyled" id="homeSubmenu">
                            <li>
                                <a href="{{route('departmentsIndex')}}">Departments</a>
                            </li>
                            <li>
                                <a href="{{route('usersIndex')}}">Users</a>
                            </li>
                            <li>
                                <a href="#">Rôles</a>
                            </li>
                            <li>
                                <a href="#">Permissions</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Tasks Inbox</a>
                    </li>

                </ul>

                <div class="footer">
                    <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy; 2023<script>
                        </script> All rights reserved <i class="icon-heart" aria-hidden="true"></i> by <a href="#" target="_blank">Task Tracking MIS</a>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                </div>

            </div>
        </nav>

        <!-- Page Content  -->
        <div id="content" class="p-4 p-md-5">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-primary">
                        <i class="fa fa-bars"></i>
                        <span class="sr-only">Toggle Menu</span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="#">Settings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Logout</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </nav>

            @if($errors->any())
            @foreach($errors->all() as $error)
            <p class="text-danger">
                {{$error}}

            </p>
            @endforeach
            @endif

            @if(Session::has('success-message'))
            <p class="text-success">
                {{Session::get('success-message')}}
            </p>
            @endif
            @yield('content')
        </div>
    </div>
    <script src="{{asset('public/js/app.js')}}"></script>

    <script src="{{ asset('public/sidebar/js/main.js')}}"></script>
</body>

</html>