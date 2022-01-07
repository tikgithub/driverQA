<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{config('app.name')}}</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('customStyle/app.css')}}">
    <style>
        #loginButton{
            padding-left: 40px;
            padding-right: 40px;
            padding-top: 20px;
            padding-bottom: 20px;
        }
        #titleText{
            font-size: 35pt;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row pt-5">
            <div class="col-md-12 text-center">
                <p class="text-danger NotoSanFont" id="titleText"><b>ສອບເສັງໃບຄັບຂີ່ພາກທິດສະດີ</b></p>
            </div>
        </div>
        {{-- Logo Here --}}
        <div class="row pt-2">
            <div class="col-md-12 text-center">
                <img src="{{asset('image/logo.png')}}" alt="Logo" width="auto" height="400">
            </div>
        </div>
        {{-- Button to Login Here --}}
        <div class="row pt-5">
            <div class="col-md-12 text-center">
                <a href="{{route('starterPage')}}" class="btn btn-danger btn-lg NotoSanFont fs-3 fw-bold" id="loginButton">ເຂົ້າສູ່ລະບົບ</a>
            </div>
        </div>
    </div>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
</body>
</html>