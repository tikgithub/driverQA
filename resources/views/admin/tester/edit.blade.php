@extends('admin.adminLayout')
@section('content')
<div class="container">

    <div class="row">
        @include('flashMessage')
        <div class="col-md-6 offset-3">

            {{-- Form to add Information --}}
            <form action="{{route('TesterUpdate')}}" method="post" class="NotoSanFont">

                <ul>
                    @foreach ($errors->all() as $item)
                    <li class="text-danger">
                        {{$item}}
                    </li>
                    @endforeach
                </ul>
                @csrf
                <input type="hidden" name="id" value="{{$tester->id}}">
                <div class="mb-2">
                    <label for="testerFullname">ຊື່ ແລະ ນາມສະກຸນ</label>
                    <input type="text" name="testerFullname" id="testerFullname" class="form-control" value="{{$tester->testerFullname}}">
                </div>
                <div class="mb-2">
                    <label for="testngNo">ເລກທີ່ສອບເສັງ</label>
                    <input type="text" name="testingNo" id="testingNo" class="form-control" value="{{$tester->testingNo}}">
                </div>
                <div class="mb-2">
                    <label for="testTypeId">ປະເພດສອບເສັງ</label>
                    <select name="testTypeId" id="testTypeId" class="form-control">
                        <option value="NULL">ເລືອກ</option>
                        @foreach ($testType as $item)
                            <option value="{{$item->id}}" {{($tester->testTypeId ==$item->id)? 'selected':''}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-2">
                    <label for="contact">ເບິໂທຕິດຕໍ່</label>
                    <input type="text" name="contact" id="contact" class="form-control" value="{{$tester->contact}}">
                </div>
                <div class="mb-2">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{$tester->email}}">
                </div>
                <div class="mb-2 text-center">
                    <button type="submit" class="btn btn-lg btn-danger">ແກ້ໄຂ</button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
