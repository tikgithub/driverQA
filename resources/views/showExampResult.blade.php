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
        <div class="row " style="height: 550px;">
            <div class="col-md-12 text-center text-white">
                <img src="{{asset('image/logo.png')}}" style="width: auto; height: 200px; border-radius: 50%; object-fit: cover">
                <h1 class="NotoSanFont mt-2">
                   <b> ຜົນການສອບເສັງໃບຂັບຂີ່ ພາກທິດສະດີ {{$testType->name}}</b>
                </h1>
                <h3 class="NotoSanFont">
                    ຜູ້ສອບເສັງ: <b><U> {{$register->testerFullname}}</U></b>
                </h3>
                <h3 class="NotoSanFont">
                    ເລກທີຜູ້ສອບເສັງ: <b><u>{{$register->testingNo}}</u></b>
                </h3>
                <h3 class="NotoSanFont" style="padding-top: 50px;">
                   <b> ຕອບຜິດ {{sizeof($countWrongQuestion)}} ຂໍ້, ຍັງບໍ່ໄດ້ຕອບ {{$countQuestionNotAnswered}}, ທັງໝົດ {{$countAllQuestion}} ຂໍ້</b>
                </h3>
                <br>
                <h1 class="NotoSanFont">
                    @if ($test_status===1)
                        <b>ຜ່ານ</b>
                    @elseif($test_status===0)
                        <b>
                            ບໍ່ຜ່ານ
                        </b>
                    @else
                        <b>UNKNOW STATUS</b>
                    @endif
                </h1>
            </div>
        </div>


    </div>
    {{--  --}}
    {{-- Footer --}}
    <nav class="navbar navbar-light bg-danger fixed-bottom">
        <div class="container-fluid justify-content-center">
            <a href="{{route('welcome')}}" class="btn btn-light me-2 NotoSanFont" type="button"><i class="bi bi-house-door"></i> ກັບໜ້າຫຼັກ</a>

             <!-- Button trigger modal -->
            <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-secondary NotoSanFont" type="button"><i class="bi bi-exclamation-circle-fill"></i> ເບິ່ງຄຳຖາມທີ່ຕອບຜິດ</button>

             <!-- Button trigger modal -->
             <button data-bs-toggle="modal" data-bs-target="#resetModal" class="ms-2 btn btn-primary NotoSanFont" type="button"><i class="bi bi-arrow-clockwise"></i> ສອບເສັງໃໝ່ອີກຄັ້ງ</button>

        </div>
      </nav>

{{-- Modal for retest confirmation --}}
<!-- Modal -->
<div class="modal fade" id="resetModal" tabindex="-1" aria-labelledby="resetModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title NotoSanFont" id="resetModalLabel">ແຈ້ງເຕືອນ</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body NotoSanFont">
            ທ່ານຕ້ອງການສອບເສັງຄືນໃໝ່ ?<br>
            <b>ໝາຍເຫດ:</b> ສອບເສັງຄືນໃຫມ່ຈະເຮັດໃຫ້ ຜົນສອບເສັງທີ່ຜ່ານມາຖືກລົບລ້າງ
        </div>

        <div class="modal-footer NotoSanFont">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ອອກ</button>
          <form action="{{route('resetExam')}}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">ຍິນຍອມ</button>
          </form>

        </div>
      </div>
    </div>
  </div>
{{-- End Modal for retest confirmation --}}
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
                    <td>ຄຳຕອບທີ່ຖືກຕ້ອງ</td>
                    <td>ຄຳຕອບທີ່ທ່ານເລືອກ</td>
                    <td class="text-center fs-4"><i class="bi bi-check-all"></i></td>
                </tr>
            </thead>
            <tbody class="NotoSanFont">
                @foreach ($questinoWrongList as $item)
                    <tr
                        @if ($item->correctOrNot == 'True')
                                style="background-color: #9bf2b2"
                        @elseif ($item->correctOrNot == 'False')
                                style="background-color: #f5856c"
                        @elseif ($item->correctOrNot == '')
                                style="background-color: #d9d5d4"
                        @endif
                    >
                        <td>{{$loop->index + 1}}</td>
                        <td>{{$item->question_string}}</td>
                        <td>{{$item->real_answer}}</td>
                        <td>
                            @if ($item->user_selected)
                                {{$item->user_selected}}
                            @else
                                {{"ບໍ່ໄດ້ຕອບ"}}
                            @endif
                        </td>
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
