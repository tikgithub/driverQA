@extends('admin.adminLayout')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <a href="{{url()->previous()}}" class="btn btn-warning NotoSanFont">ຄົ້ນຫາໃໝ່</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover">
                <thead class="NotoSanFont">
                    <tr>
                        <td>#</td>
                        <td>ຊື່ ແລະ ນາມສະກຸນ</td>
                        <td>ເລກທີ່ສອບເສັງ</td>
                        <td>ເວລາເຫລືອໃນການສອບເສັງ</td>
                        <td>ປະເພດສອບເສັງ</td>
                        <td>ເບີໂທຕິດຕໍ່</td>
                        <td>ອີເມວ</td>
                        <td>ວັນທີ່ເລີມສອບເສັງ</td>
                        <td class="">De-Active/Active</td>
                        <td><i class="bi bi-gear"></i></td>
                    </tr>
                </thead>
                <tbody class="NotoSanFont">
                    @foreach ($result as $item)
                        <tr>
                            <td>{{$loop->index + 1}}</td>
                            <td>{{$item->testerFullname}}</td>
                            <td>{{$item->testingNo}}</td>
                            <td>{{($item->testing_timespan)/60}} ນາທິ</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->contact}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->start_test_date}}</td>
                            <td class="text-center">
                                <div class="spinner-border text-danger" role="status" id="spinner-{{$item->id}}" style="display: none">
                                    <span class="visually-hidden">Loading...</span>
                                  </div>
                                  <div class="form-check form-switch" id="switchBox-{{$item->id}}">
                                    <input onclick="onSlide({{$item->id}})" class="form-check-input" type="checkbox" id="{{$item->id}}" {{($item->status=='active')? 'checked':''}}>
                                </div>

                            </td>
                            <td>
                                <a href="{{route('TesterEdit',['id'=>$item->id])}}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        function onSlide(id){
           //Send data by json file
            console.log(id);
            var checkbox = document.getElementById(id);
            console.log(checkbox.checked);

            var spinner = document.getElementById('spinner-' + id);
            var switchBox = document.getElementById('switchBox-' + id);

            spinner.style.display = 'block';
            switchBox.style.display = 'none';
            //check check box status
            if(checkbox.checked ==true)
            {
                //Update active status
                fetch(window.location.origin + "/admin/api/tester/active/" + id)
                .then(response => response.json)
                .then(data=>{
                    console.log("OK");
                    spinner.style.display = 'none';
                    switchBox.style.display = 'block';
                }).catch(error=>{
                    console.log(error);
                    spinner.style.display = 'none';
                    switchBox.style.display = 'block';
                });
            }
            else if(checkbox.checked == false){
                fetch(window.location.origin + "/admin/api/tester/deactive/" + id)
                .then(response => response.json)
                .then(data=>{
                    console.log("OK");
                    spinner.style.display = 'none';
                    switchBox.style.display = 'block';
                }).catch(error=>{
                    console.log(error);
                    spinner.style.display = 'none';
                    switchBox.style.display = 'block';
                });
            }
        }
    </script>
@endsection
