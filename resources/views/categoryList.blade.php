
@extends('master')
@section('content')
<style>
    .addBookBtn{
        width: auto;
    }
    .addBookBtnRow{
        justify-content: end;
        display: flex;
    }
</style>
    <div class="container px-0">
      @if(session('message'))
      <div class="alert alert-success" role="alert" id="successDiv">
        {{session('message')}}
      </div>
      @endif
      <div class="alert alert-danger" role="alert" style="display: none;" id="errorDiv">
      </div>
        <div class="row pt-3 addBookBtnRow">
            <a  href="" class="btn btn-primary addBookBtn" data-toggle="modal" data-target ="#addCategoryModal">Add Category</a>
        </div>
        <div class="row px-0 pt-5">
            <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Category Name</th>
                    <th scope="col px-3" style="text-align: end">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($bookCategoryData as $category)
                  <tr>
                    <th scope="row">{{$loop->iteration}}</th>
                    <td>{{$category->book_category_name}}</td>
                    <td>
                      <div class="row" style="justify-content: end">
                        <div class="col-sm-2">
                          <a class="btn btn-secondary editCategoryBtn" data-id = {{$category->id}} >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                              <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                            </svg>
                          </a>
                        </div>
                        <div class="col-sm-2">
                          <a class="btn btn-danger" href="{{ route('deleteCategory', ['id' => $category->id]) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                              <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                              <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                            </svg>                          
                          </a>
                        </div>
                      </div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="addCategoryModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add category</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group row pt-3">
                <label class="col-sm-2">Book Category :</label>
                <div class="col-sm-4"> 
                  <input  type="text" name="bookCategory" class="form-control" id="bookCategory" placeholder="" required>
                </div>
            </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id ="addCategoryBtn">Save </button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="editCategoryModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit category</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="POST" action="{{route('editCategorySave')}}">
            @csrf
          <div class="modal-body">
              <div class="form-group row pt-3">
                <label class="col-sm-2">Book Category :</label>
                <div class="col-sm-4"> 
                  <input  type="text" name="bookCategoryEdit" class="form-control" id="bookCategoryEdit" placeholder="" required>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" name="categoryIDEdit" id="categoryIDEdit" value="">
            <button type="submit" class="btn btn-primary" id ="addCategoryBtn">Save </button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
        </div>
      </div>
    </div>

    <script>
       $(document).ready(function(){
        $('#addCategoryBtn').click(function(){
          var categoryName = $('#bookCategory').val();
          $.ajax({
            url:'{{route('saveCategory')}}',
            method:'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data:{
              categoryName:categoryName
            },
            success:function(response){
              if(response.status == 'true'){
                var len = response.bookCategoryData.length;
                var options = '';
                for(var i=0;i<len;i++){
                  var bookCategory = response.bookCategoryData[i];
                  var option = `<option value="${bookCategory.id}">${bookCategory.book_category_name}</option>`;
                  options += option;               
                }
                $('#category').append(options).trigger('change');
                $('#addCategoryModal').modal('hide');
                $('#successDiv').html('Category Added Successfully');
                $('#successDiv').show();
                setTimeout(() => {
                  $('#successDiv').html('');
                  $('#successDiv').hide();
                }, 3000);
                window.reload();

              }else{
                $('#addCategoryModal').modal('hide');
                $('#errorDiv').html('Already have same category');
                $('#errorDiv').show();
                setTimeout(() => {
                  $('#errorDiv').html('');
                  $('#errorDiv').hide();
                }, 3000);
              }
            }
          });
        });

        $('.editCategoryBtn').click(function(){
          var categoryId = $(this).data('id');
          $.ajax({
            url:'{{route('getCategoryData')}}',
            method:'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data:{
              categoryId:categoryId
            },
            success:function(response){
              $('#bookCategoryEdit').val(response.bookCategoryData.book_category_name);
              $('#categoryIDEdit').val(categoryId);
              $('#editCategoryModal').modal('show');
            },
          });
        });
      });
    </script>
@endsection