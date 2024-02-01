<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $panelTitle }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        .dropdown {
            right: 150%;
        }

        .custom-btn {
            background-color: #989EA1;
            color: #fff; 
            border: none;
        }

        .custom-btn:hover {
            background-color: #6f7578; 
            color: #fff;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand navbar-light bg-light p-2">
        <div class="container-fluid ">
            <a class="navbar-brand" href="{{ route($panelRoute) }}">{{ $panelTitle }}</a>

            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit" class="btn p-4" style="color: #dc3545;">Logout</button>
            </form>

        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</body>

</html>
