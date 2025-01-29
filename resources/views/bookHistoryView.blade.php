
@extends('master')
@section('content')
<style>
    .addAuthor{
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

        <div class="row px-0 pt-5">
            <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Borrower Name</th>
                    <th scope="col">Borrowed Date</th>
                    <th scope="col">Returned Date</th>
                  </tr>
                </thead>
                <tbody>
                  @if(!($bookHistory)->isEmpty())
                  @foreach($bookHistory as $history)
                  <tr>
                    <th scope="row">{{$bookHistory->firstItem() + $loop->index}}</th>
                    <td>{{$history->name}}</td>
                    <td>{{\Carbon\Carbon::parse($history->Borrowed_date)->format('M j, Y, g A') }}</td>
                    <td>{{\Carbon\Carbon::parse($history->Returned_date)->format('M j, Y, g A')}}</td>
                  </tr>
                  @endforeach
                  @else
                  <tr>
                    <td colspan="4" style="text-align: center;">
                      No Data Found!
                    </td>
                  </tr>
                  @endif
                </tbody>
              </table>
              <div class="d-flex justify-content-end">
                {{ $bookHistory->links() }}
            </div>
        </div>
    </div>


  

    <script>
       $(document).ready(function(){
      });
    </script>
@endsection