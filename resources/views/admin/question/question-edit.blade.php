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
                   
                    <div class="row">
                        <div class="col-md-4">
                      
                            <h4 class="NotoSanFont">ເພີ່ມຄຳຕອບ</h4>
                            <form action="{{route('storeChoice')}}" method="post">
                                @csrf
                            <input type="hidden" name="question_id" value="{{$question->id}}">
                            <div class="mb-2">
                                <label for="answer" class="form-label NotoSanFont">ຄຳຕອບ</label>
                                <input type="text" name="answer" id="answer" class="form-control {{$errors->has('answer')?'border-danger':''}}">
                                @if ($errors->has('answer'))
                                    <small class="NotoSanFont text-danger"><i>{{$errors->first('answer')}}</i></small>
                                @else
                                    <small class="NotoSanFont"><i>ລົດທາງຊ້າຍມີສິດໄປກ່ອນ</i></small>
                                @endif
                               
                            </div>
                            <div class="mb-2">
                                <label for="pointing" class="form-label NotoSanFont">ຫົວຂໍ້</label>
                                <input type="text" name="pointing" id="pointing" class="form-control {{$errors->has('pointing')?'border-danger':''}}" style="width: 30%">
                                @if ($errors->has('pointing'))
                                    <small class="NotoSanFont text-danger"><i>{{$errors->first('pointing')}}</i></small>
                                @else
                                    <small class="NotoSanFont"><i>ກ. ຂ. ຄ. ງ./a. b. c. d. etc...</i></small>
                                @endif
                                
                            </div>
                            <div class="mb-3 pt-2 text-center">
                                <button type="submit" class="btn btn-danger NotoSanFont">ເພີ່ມຄຳຕອບ</button>
                            </div>
                            </form>
                        </div>

                        <div class="col-md-1">
                            <div class="vl"></div>
                        </div>

                        <div class="col-md-7">    
                            <h3 class="NotoSanFont">ລາຍການຄຳຕອບ</h3>
                            <ul class="list-group">
                                @foreach ($choices as $item)
                                
                                <div class="dropdown list-group-item" >
                                    <button class="btn btn-secondary dropdown-toggle text-start" style="width: 100%" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                      Dropdown button
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                      <li><a class="dropdown-item" href="#">Action</a></li>
                                      <li><a class="dropdown-item" href="#">Another action</a></li>
                                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                                    </ul>
                                  </div>
                                @endforeach
                            </ul>
                           
                        </div>
                    </div>
               </div>
            </div>
       </div>
   </div>
@endsection