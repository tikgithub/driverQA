@extends('admin.adminLayout')
@section('content')
{{-- ฺฺNavigation bar --}}
<nav aria-label="breadcrumb ">
    <ol class="breadcrumb NotoSanFont">
        <li class="breadcrumb-item"><a href="{{ route('admin_home') }}">ໜ້າຫຼັກ</a></li>
        <li class="breadcrumb-item"><a href="{{ route('questionIndex') }}">ຄຳຖາມສອບເສັງ</a></li>
        <li class="breadcrumb-item active NotoSanFont" aria-current="page">ແກ້ໄຂຄຳຖາມສອບເສັງ</li>
    </ol>
</nav>

   <div class="card">
       <div class="card-header">
           <h4 class="card-title NotoSanFont">ແກ້ໄຂ ຄຳຖາມສອບເສັງ</h4>
       </div>
       <div class="card-body">
           <div class="row">
               <div class="col-md-4">
                   @include('flashMessage')
                   <form action="{{route('questionUpdate')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="question_id" value="{{$question->id}}">
                       <div class="mb-3">
                           <label for="question" class="form-label NotoSanFont">ຄຳຖາມ</label>
                           <textarea name="question" id="question" rows="3" class="form-control NotoSanFont">{{$question->question}}</textarea>
                       </div>
                       <div class="mb-3">
                           <label class="form-label NotoSanFont">ຮູບພາບປະກອບ</label>
                           @if ($question->photo)
                            <img src="{{asset($question->photo)}}" width="auto" height="300">
                           @endif
                       </div>

                       <div class="mb-3 pt-3">
                           <label for="questionImage" class="form-label NotoSanFont">ເລືອກຮູບພາບ (ຖ້າຕ້ອງການປ່ຽນໃໝ່)</label>
                           <input type="file" name="questionImage" id="questionImage" class="form-control">
                       </div>
                       <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-danger btn-lg NotoSanFont">ບັນທຶກ</button>
                       </div>
                   </form>
               </div>
               <div class="col-md-8">
                    <h4 class="NotoSanFont">ຊຸດຄຳຕອບ</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-2">
                                <label for="answer" class="form-label NotoSanFont">ຄຳຕອບ</label>
                                <input type="text" name="answer" id="answer" class="form-control">
                                <small class="NotoSanFont"><i>ລົດທາງຊ້າຍມີສິດໄປກ່ອນ</i></small>
                            </div>
                            <div class="mb-2">
                                <label for="pointing" class="form-label NotoSanFont">ຫົວຂໍ້</label>
                                <input type="text" name="pointing" id="pointing" class="form-control" style="width: 30%">
                                <small class="NotoSanFont"><i>ກ. ຂ. ຄ. ງ./a. b. c. d. etc...</i></small>
                            </div>
                            <div class="mb-3 text-center">
                                <button type="submit" class="btn btn-danger NotoSanFont">ເພີ່ມຄຳຕອບ</button>
                            </div>
                        </div>
                        <div class="col-md-8">

                        </div>
                    </div>
               </div>
            </div>
       </div>
   </div>
@endsection