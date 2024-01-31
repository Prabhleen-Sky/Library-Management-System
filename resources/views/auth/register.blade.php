<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            background-color: #fff;
            border-radius: 20px;
            box-shadow: rgba(0, 0, 0, 0.25) 0px 25px 50px -12px;
            padding: 3%;
            margin-top: 6%;
            max-width: 30%; /* Set max-width */
            margin-left: auto;
            margin-right: auto;
        }

        h1 {
            color: #343a40;
            margin-bottom: 3%;
        }

        .form-group {
            margin-bottom: 3.75%;
        }

        label {
            /* font-weight: bold; */
            color: #555;
        }

        input {
            width: 94%;
            padding: 1.5%;
            margin-top: 0.5%;
            margin-bottom: 1.875%;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .a-link{
            color: black;
            text-decoration : underline;
        }

        .a-link:hover{
            color: #6e6464;
        }

        .btn-custom{
            font-size: 14px;
            border-radius:7%;
        }

    </style>
</head>
<body>
    <div class="container">
       

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf


            <div class="form-group">
                <label for="fname">First Name</label>
                <input type="text" id="fname" class="form-control" name="fname" value="{{ old('fname') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="lname">Last Name</label>
                <input type="text" id="lname" class="form-control" name="lname" value="{{ old('lname') }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email"  id="email" class="form-control" name="email" value="{{ old('email') }}"  required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" class="form-control" name="password" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="number" id="phone" class="form-control" name="phone" required>
            </div>
            
            <div class="d-flex justify-content-end ">
                <a href="/login" class="mt-2 mr-4 a-link">Already registered? </a>
                <button type="submit" class="btn btn-dark btn-md btn-custom">REGISTER</button>
            </div>           

            {{-- <button type="submit" class="btn btn-primary btn-block">Register</button> --}}
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
