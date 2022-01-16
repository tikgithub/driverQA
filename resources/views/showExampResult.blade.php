<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('customStyle/app.css') }}">
    <link rel="stylesheet" href="{{ asset('customStyle/loading.css') }}">
    <link rel="stylesheet" href="{{asset('bootstrap-icons/font/bootstrap-icons.css')}}">
</head>
<body>
    <div class="container bg-danger p-3 border rounded mt-3 shadow">
        <div class="row " style="height: 400px;">
            <div class="col-md-12 text-center text-white">
                <h1 class="NotoSanFont">
                   <b> ຜົນການສອບເສັງໃບຂັບຂີ່ ພາກທິດສະດີ {{$testType->name}}</b>
                </h1>
                <h3 class="NotoSanFont">
                    ຜູ້ສອບເສັງ: <b><U> {{$register->testerFullname}}</U></b>
                </h3>
                <h3 class="NotoSanFont">
                    ເລກທີຜູ້ສອບເສັງ: <b><u>{{$register->testingNo}}</u></b>
                </h3>
                <h3 class="NotoSanFont" style="padding-top: 100px;">
                   <b> ຕອບຜິດ {{sizeof($countWrongQuestion)}} ຂໍ້, ຍັງບໍ່ໄດ້ຕອບ {{$countQuestionNotAnswered}}, ທັງໝົດ {{$countAllQuestion}} ຂໍ້</b>
                </h3>
            </div>
        </div>
       

    </div>
    {{--  --}}
    {{-- Footer --}}
    <nav class="navbar navbar-light bg-danger fixed-bottom" >
        <div class="container-fluid justify-content-center">
            <a href="{{route('welcome')}}" class="btn btn-light me-2 NotoSanFont" type="button"><i class="bi bi-house-door"></i> ກັບໜ້າຫຼັກ</a>

             <!-- Button trigger modal -->
            <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-secondary NotoSanFont" type="button"><i class="bi bi-exclamation-circle-fill"></i> ເບິ່ງຄຳຖາມທີ່ຕອບຜິດ</button>
        </div>
      </nav>
   {{-- Modal --}}
  
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content NotoSanFont">
        <div class="modal-header">
          <h5 class="modal-title fs-2 fw-bold" id="exampleModalLabel"><img src="{{asset('image/logo.png')}}" height="50" width="auto"> ລາຍການທີ່ຕອບຜິດ</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <table class="table table-hover">
            <thead class="NotoSanFont fw-bold fs-4">
                <tr>
                    <td>#</td>
                    <td>ຄຳຖາມທີ່ຕອບຜິດ</td>
                    <td>ຄຳຕອບທີ່ເລືອກ</td>
                    <td class="text-center fs-4"><i class="bi bi-check-all"></i></td>
                </tr>
            </thead>
            <tbody class="NotoSanFont">
                @foreach ($questinoWrongList as $item)
                    <tr>
                        <td>{{$loop->index + 1}}</td>
                        <td>{{$item->question_string}}</td>
                        @if ($item->answer_text)
                            <td>{{$item->answer_title}}. {{$item->answer_text}}</td>
                        @else
                            <td>ບໍ່ໄດ້ຕອບ</td>
                        @endif
                        <td class="text-center">
                            @if ($item->correctOrNot == 'True')
                                <img src="{{asset('image/checked.png')}}" width="auto" height="30">
                            @elseif ($item->correctOrNot == 'False')
                                <img src="{{asset('image/cancel.png')}}" width="auto" height="30">
                            @elseif ($item->correctOrNot == '')
                                <i class="bi bi-dash-lg"></i>
                            @endif
                        </td>
                        
                    </tr>
                @endforeach
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ອອກ</button>
        </div>
      </div>
    </div>
  </div>
  <script src="{{asset('js/bootstrap.min.js')}}"></script>
</body>
</html>