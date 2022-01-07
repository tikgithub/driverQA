<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin {{config('app.name')}}</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('customStyle/app.css')}}">
    <link rel="stylesheet" href="{{asset('bootstrap-icons/font/bootstrap-icons.css')}}">

</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 pt-4 ">
                <div class="card border shadow">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="{{asset('image/logo.png')}}" alt="" srcset="" width="auto" height="150">
                        </div>
                        <div class="pt-4"></div>
                        @include('flashMessage')
                        <form action="{{route('postLogin')}}" method="post">
                            @csrf
                            {{-- Username control --}}
                            <div class="mb-2 pt-3">
                                <label for="name" class="form-label NotoSanFont">ຊື່ຜູ້ໃຊ້</label>
                                <input type="text" class="form-control form-control-lg" id="name" name="name" placeholder="">
                            </div>
                            {{-- Password control --}}
                            <div class="mb-2 pt-3">
                                <label for="password" class="form-label NotoSanFont">ລະຫັດຜ່ານ</label>
                                <input type="password" class="form-control form-control-lg" name="password" id="password" placeholder="">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-danger btn-lg NotoSanFont">ເຂົ້າສູ່ລະບົບ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>

    <script src="{{asset('js/bootstrap.min.js')}}"></script>
</body>
</html>