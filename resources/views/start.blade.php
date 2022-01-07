<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{config('app.name')}}</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('customStyle/app.css')}}">
    <link rel="stylesheet" href="{{asset('bootstrap-icons/font/bootstrap-icons.css')}}">
</head>
<body>
    {{-- Nav-bar --}}
    <nav class="navbar navbar-expand-lg navbar-danger bg-danger">
        <div class="container-fluid">
          <a class="navbar-brand" href="#"></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              {{-- <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Features</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Pricing</a>
              </li> --}}
            </ul>
            <span class="navbar-text text-white NotoSanFont">
              <a href="{{route('getLogin')}}" class="btn btn-light"> <i class="bi bi-unlock-fill"></i>ເຂົ້າສູ່ລະບົບ</a>
            </span>
          </div>
        </div>
      </nav>

    <div class="container">
        <div class="row pt-5">
            <div class="col-md-3 text-center">
                <img src="{{asset('image/logo.png')}}" class="" alt="Logo" width="auto" height="200" >
            </div>
            <div class="col-md-9">
                <h1 class="NotoSanFont text-center pt-4">ສອບເສັງໃບຂັບຂີ່ພາກທິດສະດີ</h1>
                <br>
                @include('flashMessage')
                <form action="{{route('validateStater')}}" autocomplete="off" method="POST">
                    @csrf
                    <div class="mb-3 row">
                        <label for="testerFullname" class="NotoSanFont col-sm-3 col-form-label">ຊື່ ແລະ ນາມສະກຸນ</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control NotoSanFont {{$errors->has('testerFullname')? 'border-danger':''}}" id="testerFullname" name="testerFullname" value="{{old('testerFullname')}}">
                            @if ($errors->has('testerFullname'))
                                <p class="text-danger NotoSanFont pt-1">{{$errors->first('testerFullname')}}</p>
                            @endif
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label for="testingNo" class="NotoSanFont col-sm-3 col-form-label">ໝາຍເລກສອບເສັງ</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control NotoSanFont {{$errors->has('testingNo')? 'border-danger':''}}" id="testingNo" name="testingNo" value="{{old('testingNo')}}">
                          @if ($errors->has('testingNo'))
                              <p class="NotoSanFont text-danger">{{$errors->first('testingNo')}}</p>
                          @endif
                        </div>
                      </div>
                      <div class="mb-3 row" style="padding-top: 20px;">
                          <label for="testTypeId" class="NotoSanFont col-md-3 col-form-label">ປະເພດສອບເສັງ</label>
                            <div class="col-md-9">
                                @foreach ($testTypes as $item)
                                    <input type="radio" class="btn-check" name="testTypeId" id="{{$item->id}}" autocomplete="off" value="{{$item->id}}" >
                                    <label class="btn btn-outline-danger NotoSanFont me-2 pt-2" for="{{$item->id}}">{{$item->name}}</label>
                                @endforeach
                                @if ($errors->has('testTypeId'))
                                    <p class="pt-1 text-danger NotoSanFont"><b><u>{{$errors->first('testTypeId')}}</u></b></p>
                                @endif
                            </div>
                      </div>
                      <div class="row pt-5">
                          <div class="col-md-12 text-center">
                              <button type="submit" class="btn btn-danger btn-lg NotoSanFont"><i class="bi bi-watch"></i> ເຂົ້າສອບເສັງ</button>
                          </div>
                      </div>
                </form>
                
            </div>
        </div>
    </div>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
</body>
</html>