@extends('admin.adminLayout')
@section('content')
<nav aria-label="breadcrumb ">
    <ol class="breadcrumb NotoSanFont">
        <li class="breadcrumb-item"><a href="{{ route('admin_home') }}">ໜ້າຫຼັກ</a></li>
        <li class="breadcrumb-item active NotoSanFont" aria-current="page">ຕັ້ງຄ່າການສອບເສັງ</li>
    </ol>
</nav>
{{-- Control form --}}
<div class="card">
    <div class="card-body">
        <form action="{{route('appSettingUpdate')}}" method="post">
            @csrf
            <input type="hidden" name="id" value="{{isset($settings->id)? $settings->id:'0'}}">
            <div class="mb-3">
                <label for="test_time" class="NotoSanFont form-label">ເວລາໃຊ້ໃນການສອບເສັງ(ຫົວໜ່ວຍເປັນວິນາທີ)</label>
                <input type="number" name="test_time" id="test_time" class="form-control" value="{{isset($settings->test_time)? $settings->test_time:'0'}}" style="width: 200px;">
            </div>
            <div class="mb-3">
                <label for="questionNo" class="form-label NotoSanFont">ຈຳນວນຄຳຖາມໃຊ້ໃນການສອບເສັງ</label>
                <input type="number" name="questionNo" id="questionNo" class="form-control" style="width: 100px;" value="{{isset($settings->questionNo)? $settings->questionNo:'0'}}">
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-danger btn-lg NotoSanFont">ບັນທຶກ</button>
            </div>
        </form>
    </div>
</div>
@endsection