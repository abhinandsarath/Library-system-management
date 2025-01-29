
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Bootstrap JS -->
{{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}

    <title>Library-Management</title>
</head>
<body>

<style>
    .addBookBtn{
        width: auto;
    }
    .addBookBtnRow{
        justify-content: end;
        display: flex;
    }
</style>
<nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
  <div class="collapse navbar-collapse" id="navbarText" style="justify-content: end; padding-right:2%;">
    <div class="row">
      <a href="{{route('logout')}}" class="btn btn-primary" style="width: auto;">Log Out</a>
    </div>
  </div>
</nav>
    <div class="container px-0">
      @if(session('message'))
      <div class="alert alert-success" role="alert" id="successDiv">
        {{session('message')}}
      </div>
      @endif

      <div class="alert alert-success" role="alert" style="display: none;" id="borrowSuccessDiv">
      </div>

        <div class="row px-0 pt-5">
            <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Book Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Author</th>
                    <th scope="col" style="text-align: end;">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @if(!$booksData->isEmpty())
                  @foreach($booksData as $books)
                  <tr>
                    <th scope="row">{{$loop->iteration}}</th>
                    <td>{{$books->book_name}}</td>
                    <td>{{$books->book_category_name}}</td>
                    <td>{{$books->author_name}}</td>
                    <td>
                      @if($books->UsableBook == 'true')
                      <div class="row pe-2" style="justify-content: end">
                        <div class="form-check" style="display: flex; justify-content:end;">
                          <input class="form-check-input borrowBook" type="checkbox" name="borrowBook{{$loop->iteration}}" id="borrowBook" value="borrow" data-bookid ={{$books->id}} {{$books->bookBorrowed == 'true' ? 'checked' : ''}}>
                          <label class="form-check-label ps-1 borrowLabel">
                            @if($books->bookBorrowed == 'true')
                            Return
                            @else
                            Borrow
                            @endif
                          </label>
                        </div>
                        {{-- <div class="form-check" style="display: flex; justify-content:end;">
                          <input class="form-check-input borrowBook" type="radio" name="borrowBook{{$loop->iteration}}" id="borrowBook" value="return" data-bookid ={{$books->id}}>
                          <label class="form-check-label ps-2" for="flexRadioDefault2">
                            Return
                          </label>
                        </div> --}}
                      </div>
                      @else
                      <p style="text-align: end;">This Book Alredy Borrowed by another user</p>
                      @endif
                    </td>
                  </tr>
                  @endforeach
                  @else
                  <tr>
                    <td colspan="6" style="text-align: center;">No Data Found.</td>
                  </tr>
                  @endif
                </tbody>
              </table>
        </div>
    </div>

    <script>
      $(document).ready(function(){
        $('.borrowBook').click(function(){
          var action = '';
          var element = $(this).parent().find('.borrowLabel');

        if($(this).is(':checked')){
          action = 'borrow';

        }else{
          action = 'return';
        }
          // var action = $(this).val();
          var bookID = $(this).data('bookid');

          $.ajax({
            url:'{{route('borrowBook')}}',
            type:'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data:{
              action:action,
              bookID:bookID,
            },
            success:function(response){
              if(response.status =='true'){
                $('#borrowSuccessDiv').html(response.message);
                $('#borrowSuccessDiv').show();
                element.html(response.action);
                setTimeout(() => {
                  $('#borrowSuccessDiv').html('');
                  $('#borrowSuccessDiv').hide();
                }, 3000);
              }
            },
          });
        });
      });
    </script>

</body>
</html>