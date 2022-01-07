@extends('admin.adminLayout')
@section('content')
   <div class="card">
       <div class="card-header">
           <h4 class="card-title NotoSanFont">ແກ້ໄຂ ຄຳຖາມສອບເສັງ</h4>
       </div>
       <div class="card-body">
           <div class="row">
               <div class="col-md-4"></div>
               <div class="col-md-4">
                   <form action="" method="post">
                       <div class="mb-3">
                           <label for="question" class="form-label NotoSanFont">ຄຳຖາມ</label>
                           <textarea name="question" id="question" rows="3" class="form-control NotoSanFont"></textarea>
                       </div>
                       <div class="mb-3">
                           
                       </div>
                       <div class="mb-3">
                           <label for="questionImage" class="form-label NotoSanFont">ເລືອກຮູບພາບ</label>
                           <input type="file" name="questionImage" id="questionImage" class="form-control">
                       </div>
                       <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-danger btn-lg NotoSanFont">ບັນທຶກ</button>
                       </div>
                   </form>
               </div>
               <div class="col-md-4"></div>
            </div>
       </div>
   </div>
@endsection