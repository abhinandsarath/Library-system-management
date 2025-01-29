

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Library-Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<body>  
    <div class="container">
        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <div class="row pt-5">
                    <h3>Register</h3>

                    <form action="{{route('userRegister')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Name :</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="name" required>
                        </div>

                        <div class="form-group">
                            <label>Email :</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="email" required>
                        </div>
    
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="password" required>
                        </div>
    
                        <div class="row pt-3 px-2">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                    <div class="row">
                        <a href="{{route('userLoginView')}}">Log In</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4"></div>
        </div>
    </div>
</body>
</html>
