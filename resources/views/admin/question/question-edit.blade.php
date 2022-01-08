@extends('admin.adminLayout')
@section('content')
    {{-- ฺฺNavigation bar --}}
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb NotoSanFont">
            <li class="breadcrumb-item"><a href="{{ route('admin_home') }}">ໜ້າຫຼັກ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('questionIndex') }}">ຄຳຖາມສອບເສັງ</a></li>
            {{-- Check if it is choice edit ? --}}
            @if (isset($choice->id))
                <li class="breadcrumb-item NotoSanFont" ><a href="{{ route('questionIndex') }}">ແກ້ໄຂຄຳຖາມສອບເສັງ</a></li>
                <li class="breadcrumb-item active NotoSanFont" aria-current="page">ແກ້ໄຂຊຸດຄຳຕອບ</li>
            @else
                <li class="breadcrumb-item active NotoSanFont" aria-current="page">ແກ້ໄຂຄຳຖາມສອບເສັງ</li>
            @endif
           
            
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
                    <form action="{{ route('questionUpdate') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="question_id" value="{{ $question->id }}">
                        <div class="mb-3">
                            <label for="question" class="form-label NotoSanFont">ຄຳຖາມ</label>
                            <textarea name="question" id="question" rows="3"
                                class="form-control NotoSanFont">{{ $question->question }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label NotoSanFont">ຮູບພາບປະກອບ</label>
                            @if ($question->photo)
                                <img src="{{ asset($question->photo) }}" width="auto" height="300">
                            @endif
                        </div>

                        <div class="mb-3 pt-3">
                            <label for="questionImage" class="form-label NotoSanFont">ເລືອກຮູບພາບ
                                (ຖ້າຕ້ອງການປ່ຽນໃໝ່)</label>
                            <input type="file" name="questionImage" id="questionImage" class="form-control">
                        </div>
                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-danger btn-lg NotoSanFont">ບັນທຶກ</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-8">

                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{isset($choice->id)? route('updateChoice'):route('storeChoice')}}" method="post">
                                @csrf
                                <input type="hidden" name="question_id" value="{{ $question->id }}">
                                @if (isset($choice->id))
                                    <input type="hidden" name="choice_id" value="{{ $choice->id }}">
                                @endif
                                <div class="mb-2">
                                    <label for="answer" class="form-label NotoSanFont">ຄຳຕອບ</label>
                                    <input type="text" name="answer" id="answer"
                                        class="form-control {{ $errors->has('answer') ? 'border-danger' : '' }} NotoSanFont"
                                        style="width: 600px;" value="{{ isset($choice->answer) ? $choice->answer : '' }}">
                                    @if ($errors->has('answer'))
                                        <small
                                            class="NotoSanFont text-danger"><i>{{ $errors->first('answer') }}</i></small>
                                    @else
                                        <small class="NotoSanFont"><i>ລົດທາງຊ້າຍມີສິດໄປກ່ອນ</i></small>
                                    @endif

                                </div>
                                <div class="mb-2">
                                    <label for="pointing" class="form-label NotoSanFont">ຫົວຂໍ້</label>
                                    <input type="text" name="pointing" id="pointing"
                                        class="form-control form-control-lg bg-warning {{ $errors->has('pointing') ? 'border-danger' : '' }} NotoSanFont"
                                        style="width: 100px;" value="{{ isset($choice->pointing) ? $choice->pointing : '' }}">
                                    @if ($errors->has('pointing'))
                                        <small
                                            class="NotoSanFont text-danger"><i>{{ $errors->first('pointing') }}</i></small>
                                    @else
                                        <small class="NotoSanFont"><i>ກ. ຂ. ຄ. ງ./a. b. c. d. etc...</i></small>
                                    @endif

                                </div>
                                <div class="mb-3 pt-2">
                                    <button type="submit"
                                        class="btn {{ isset($choice->id) ? 'btn btn-success' : 'btn btn-danger' }} NotoSanFont">{{ isset($choice->id) ? 'ແກ້ໄຂ' : 'ບັນທຶກ' }}</button>
                                    @if (isset($choice->id))
                                        <a href="{{ route('questionEdit', ['id' => $question->id]) }}"
                                            class="btn btn-info NotoSanFont"><i class="bi bi-plus-circle"></i> ເພີ່ມຄຳຕອບໃໝ່</a>
                                        {{-- <a href="{{ route('questionEdit', ['id' => $question->id]) }}"
                                            class="btn btn-danger NotoSanFont"><i class="bi bi-check-all"></i> ຕັ້ງເປັນຄຳຖາມຖືກຕ້ອງ</a> --}}
                                        @if ($question->correct_answer != $choice->pointing)
                                            <a href="{{route('questionUpdateCorrectAnswer',['choice_id'=>$choice->id,'question_id'=>$question->id])}}" class="btn btn-danger NotoSanFont">ຕັ້ງເປັນຄຳຕອບທີ່ຖືກຕ້ອງ</a>
                                        @endif    
                                    @endif
                                </div>
                            </form>

                            <hr>

                            <h3 class="NotoSanFont">ລາຍການຄຳຕອບ</h3>
                            <ul class="list-group">
                                @foreach ($choices as $item)
                                    <div class="mb-3">
                                        <a href="{{ route('editChoice', ['id' => $question->id, 'choice_id' => $item->id]) }}"
                                            class="btn {{($item->pointing == $question->correct_answer)? 'btn-success':'btn-warning'}} NotoSanFont text-start" style="width: 100%"><b
                                                class="fs-4">{{ $item->pointing }}</b>. {{ $item->answer }} {{($item->pointing == $question->correct_answer)? '(ຖືກ)':''}}</a>
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
