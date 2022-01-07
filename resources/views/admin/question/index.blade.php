@extends('admin.adminLayout')
@section('content')
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb NotoSanFont">
            <li class="breadcrumb-item"><a href="{{ route('admin_home') }}">ໜ້າຫຼັກ</a></li>
            <li class="breadcrumb-item active NotoSanFont" aria-current="page">ຄຳຖາມສອບເສັງ</li>
        </ol>
    </nav>
    {{-- card box to display list of question --}}
    <div class="card">
        <div class="card-header">
            <div style="display: inline-flex">
                <h3 class="card-title NotoSanFont">
                    ລາຍການ ຄຳຖາມສອບເສັງ
                </h3>
            </div>

        </div>
        <div class="card-body">
            <div class="row">
                {{-- start form --}}
                <form class="col-md-4 shadow" action="{{route('questionStore')}}" method="POST" enctype="multipart/form-data">
                    @include('flashMessage')
                    @csrf
                    {{-- question textbox --}}
                    <div class="mb-3">
                        <label for="" class="form-label NotoSanFont">ຄຳຖາມທີ່ຕ້ອງການເພີ່ມ</label>
                        <textarea type="text" class="form-control NotoSanFont {{$errors->has('question') ? 'border-danger':''}}" name="question" rows="3"></textarea>
                       @if ($errors->has('question'))
                           <div class="mt-1 text-danger NotoSanFont">
                               {{$errors->first('question')}}
                           </div>
                       @endif
                    </div>
                    {{-- question image dialog --}}
                    <div class="mb-3">
                        <label for="" class="form-label NotoSanFont">ຮູບພາບປະກອບຖ້າມີ</label>
                        <input type="file" name="questionImage" id="questionImage" class="form-control {{$errors->has('questionImage')? 'border-danger':''}}">
                        @if($errors->has('questionImage'))
                            <div class="mt-1 NotoSanFont text-danger">
                                {{$errors->first('questionImage')}}
                            </div>
                        @endif
                    </div>
                    {{-- Submit Button --}}
                    <div class="mb-3 text-center">
                        <button class="ms-2 btn btn-danger NotoSanFont btn-lg" style="width: 50%">ເພີ່ມ</button>
                    </div>
                    
                </form>
                {{-- End Form --}}
                <div class="col-md-8">
                    <table class="table table-hover">
                        <thead>
                            <tr class="NotoSanFont">
                                <th style="width: 5%">#</th>
                                <th>ຄຳຖາມ</th>
                                <th>ຄຳຕອບ</th>
                                <td class="text-center"><i class="bi bi-sliders"></i></td>
                            </tr>
                        </thead>
                        <tbody class="NotoSanFont">
                            @foreach ($questions as $item)
                                <tr>
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{$item->question}}</td>
                                    <td>{{$item->answer}}</td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-danger btn-sm dropdown-toggle NotoSanFont" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-arrow-down"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                                              <li><a class="dropdown-item " href="#"><i class="bi bi-chevron-right"></i> ຕົວເລືອກຄຳຕອບ</a></li>
                                              <li><a class="dropdown-item" href="{{route('questionEdit',['id'=>$item->id])}}"><i class="bi bi-pencil"></i> ແກ້ໄຂຄຳຖາມ</a></li>
                                              <li><hr class="dropdown-divider"></li>
                                              <li class="bg-danger"><a class="dropdown-item  text-white" href="#"><i class="bi bi-trash-fill"></i> ລຶບຄຳຖາມ</a></li>
                                            </ul>
                                          </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$questions->links()}}
                </div>
            </div>

        </div>
    </div>
@endsection
