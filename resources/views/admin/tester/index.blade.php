@extends('admin.adminLayout')
@section('content')
        {{-- ฺฺNavigation bar --}}
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb NotoSanFont">
                <li class="breadcrumb-item"><a href="{{ route('admin_home') }}">ໜ້າຫຼັກ</a></li>
                <li class="breadcrumb-item active NotoSanFont" aria-current="page">ນັກສອບເສັງ</li>
            </ol>
        </nav>

        <div class="container">

            <div class="row">
                @include('flashMessage')
                <div class="col-md-6">

                    {{-- Form to add Information --}}
                    <form action="{{route('TesterStore')}}" method="post" class="NotoSanFont">

                        <ul>
                            @foreach ($errors->all() as $item)
                            <li class="text-danger">
                                {{$item}}
                            </li>
                            @endforeach
                        </ul>
                        @csrf
                        <div class="mb-2">
                            <label for="testerFullname">ຊື່ ແລະ ນາມສະກຸນ</label>
                            <input type="text" name="testerFullname" id="testerFullname" class="form-control" value="{{old('testerFullname')}}">
                        </div>
                        <div class="mb-2">
                            <label for="testngNo">ເລກທີ່ສອບເສັງ</label>
                            <input type="text" name="testingNo" id="testingNo" class="form-control" value="{{old('testingNo')}}">
                        </div>
                        <div class="mb-2">
                            <label for="testTypeId">ປະເພດສອບເສັງ</label>
                            <select name="testTypeId" id="testTypeId" class="form-control">
                                <option value="NULL">ເລືອກ</option>
                                @foreach ($testType as $item)
                                    <option value="{{$item->id}}" {{(old('testTypeId')==$item->id)? 'selected':''}}>{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="contact">ເບິໂທຕິດຕໍ່</label>
                            <input type="text" name="contact" id="contact" class="form-control" value="{{old('contact')}}">
                        </div>
                        <div class="mb-2">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}">
                        </div>
                        <div class="mb-2 text-center">
                            <button type="submit" class="btn btn-lg btn-danger">ເພີ່ມ</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 NotoSanFont">
                    <h3>ຄົ້ນຫາ</h3>
                    <form action="{{route('TesterSearch')}}" method="GET">
                        <div class="mb-2">
                            <label for="searchFullname">ຊື່ ແລະ ນາມສະກຸນ</label>
                            <input type="text" name="searchFullname" id="searchFullname" class="form-control">
                        </div>
                        <div class="mb-2">
                            <p></p>
                              <input type="radio" id="active" name="status" value="active">
                              <label for="active">Active</label><br>
                              <input type="radio" id="disactive" name="status" value="disactive">
                              <label for="disactive">Disactive</label><br>
                        </div>
                        <div class="mb-2 text-center">
                            <button type="submit" class="btn btn-warning">ຄົ້ນຫາ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
