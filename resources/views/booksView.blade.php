
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
        <div class="row pt-3 addBookBtnRow">
            <a  href="{{route('addBookView')}}" class="btn btn-primary addBookBtn me-2">Add Book</a>
            <a   class="btn btn-primary addBookBtn" data-toggle="modal" data-target ="#filterModal">Filter</a>

        </div>
        <div class="row px-0 pt-5">
            <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Book Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Author</th>
                    <th scope="col">Borrowed By</th>
                    <th scope="col" style="text-align: end;">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @if(!$booksData->isEmpty())
                  @foreach($booksData as $books)
                  <tr>
                    <th scope="row">{{$booksData->firstItem() + $loop->index}}</th>
                    <td>{{$books->book_name}}</td>
                    <td>{{$books->book_category_name}}</td>
                    <td>{{$books->author_name}}</td>
                    <td>{{$books->name ?? ''}}</td>
                    <td>
                      <div class="row pe-2" style="justify-content: end">
                        <div class="col-sm-2">
                          <a class="btn btn-secondary " data-id = {{$books->id}} href="{{ route('editBookView', ['id' => $books->id]) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                              <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                            </svg>
                          </a>
                        </div>
                        <div class="col-sm-2">
                          <a class="btn btn-danger" href="{{ route('deleteBook', ['id' => $books->id]) }}">
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
                  @else
                  <tr>
                    <td colspan="6" style="text-align: center;">No Data Found.</td>
                  </tr>
                  @endif
                </tbody>
              </table>
              <div class="d-flex justify-content-end">
                {{ $booksData->links() }}
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="filterModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Filter</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="GET" action="{{route('booksView')}}">
            @csrf
          <div class="modal-body">
              <div class="form-group row pt-3">
                <label class="col-sm-4">Book Category :</label>
                <div class="col-sm-8">
                  <select class="form-select " name="category" id="category" >
                    <option value="">--Category--</option>
                    @foreach ($bookCategoryData as $category)
                      <option value="{{$category->id}}" {{$categoryID == $category->id ? 'selected' : '' }}>{{$category->book_category_name}}</option>
                    @endforeach
                  </select>
                </div>
            </div>
            <div class="form-group row pt-3">
              <label class="col-sm-4">Author :</label>
              <div class="col-sm-8">
                <select class="form-select " name="author">
                  <option value="" selected>--Author--</option>
                  @foreach ($authorData as $author)
                    <option value="{{$author->id}}" {{$authorID == $author->id ? 'selected' : '' }}>{{$author->author_name}}</option>
                  @endforeach
                </select>
              </div>
          </div>

          <div class="form-group row pt-3">
            <label class="col-sm-4">Borrowed By :</label>
            <div class="col-sm-8">
              <select class="form-select " name="borrowedBy">
                <option value="" selected>--User--</option>
                @foreach ($userData as $user)
                  <option value="{{$user->id}}" {{$borrowedBy == $user->id ? 'selected' : '' }}>{{$user->name}}</option>
                @endforeach
              </select>
            </div>
        </div>

          </div>
          <div class="modal-footer">
            <input type="hidden" name="from" value="filter">
            <button type="submit" class="btn btn-primary" id ="addCategoryBtn">Filter </button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
        </div>
      </div>
    </div>

@endsection