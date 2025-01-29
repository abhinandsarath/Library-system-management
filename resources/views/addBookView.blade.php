
@extends('master')
@section('content')
<div class="alert alert-success" role="alert" style="display: none;" id="successDiv">
</div>
<div class="alert alert-danger" role="alert" style="display: none;" id="errorDiv">
</div>

    <div class="container px-0">
      <div class="row">
        <h2>Add Book </h2>
      </div>
      <form action="{{route('bookSave')}}" method="post">
        @csrf
        <div class="form-group row pt-3">
            <label class="col-sm-2">Book Name :</label>
            <div class="col-sm-4"> 
              <input  type="text" name="bookName" class="form-control" id="bookName" placeholder="" required>
            </div>
        </div>

        <div class="form-group row pt-3">
          <label class="col-sm-2">Book Category :</label>
          <div class="col-sm-4">
            <select class="form-select " name="category" id="category" required>
              <option value="" selected>--Category--</option>
              @foreach ($bookCategoryData as $category)
                <option value="{{$category->id}}">{{$category->book_category_name}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-sm-2">
            <a class="btn btn-secondary" id="addCategory" href ={{route('categoryList')}}>
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
              </svg>
            </a>
          </div>
        </div>

      <div class="form-group row pt-3">
        <label class="col-sm-2">Book Author :</label>
        <div class="col-sm-4">
          <select class="form-select " name="author" required>
            <option value="" selected>--Author--</option>
            @foreach ($authorData as $author)
              <option value="{{$author->id}}">{{$author->author_name}}</option>
            @endforeach
          </select>
        </div>
        <div class="col-sm-2">
          <a class="btn btn-secondary" id="addAuthor" href="{{route('authorList')}}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
              <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
            </svg>
          </a>
        </div>
      </div>
      <div class="row px-3 py-3">
        <button class="btn btn-primary" type="submit" style="width:auto;">Save</button>
      </div>
      </form>
    </div>

    <script>
      $(document).ready(function(){

      });
    </script>

@endsection