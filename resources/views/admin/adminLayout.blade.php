<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AdminPage {{config('app.name')}}</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('customStyle/app.css')}}">
    <link rel="stylesheet" href="{{asset('bootstrap-icons/font/bootstrap-icons.css')}}">
    
    <style>
        .nav-logo{
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
        <div class="container-fluid">
          <a class="navbar-brand" href="{{route('admin_home')}}"><img class="nav-logo" src="{{asset('image/logo.png')}}" alt="logo" width="auto" height="42"></a>
          <a class="navbar-brand" href="{{route('admin_home')}}">{{config('app.name')}}</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle active NotoSanFont" href="#" id="dataManagement" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    ຈັດການຂໍ້ມູນ
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="dataManagement">
                    <li><a class="dropdown-item NotoSanFont" href="{{route('questionIndex')}}">ຄຳຖາມສອບເສັງ</a></li>
                    <li><a class="dropdown-item NotoSanFont" href="#">ກຳນົດເວລາສອບເສັງ</a></li>
                    {{-- <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li> --}}
                  </ul>
              </li>
              {{-- <li class="nav-item">
                <a class="nav-link" href="#">Features</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Pricing</a>
              </li> --}}
            </ul>
            <span class="navbar-text">
              <a href="{{route('admin_Logout')}}" class="btn btn-light NotoSanFont text-dark"><i class="bi bi-power"></i> ອອກຈາກລະບົບ</a>
            </span>
          </div>
        </div>
      </nav>
      
     <div class="container-fluid pt-3">
        @yield('content')
     </div>

     <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

</body>
</html>