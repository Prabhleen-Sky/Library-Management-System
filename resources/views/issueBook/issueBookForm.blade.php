<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Issue Book Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        .card {
            box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;
        }
    </style>

</head>

<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">


    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error') || $errors->any())
            <div class="alert alert-danger">
                <ul>
                    {{ session('error') }}
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card p-4">
            <h3 class="text-lg font-semibold mb-4">Issue Book</h3>

            <form action="{{ route('store.issued.book') }}" method="post">
                @csrf

                <div class="mb-3">
                    <label for="book_id" class="form-label">Book Id</label>
                    <input type="text" name="book_id" id="book_id" class="form-control" autocomplete="off" required
                        value="{{ old('book_id') }}">
                </div>

                <div class="mb-3">
                    <label for="user_id" class="form-label">User Id</label>
                    <input type="text" name="user_id" id="user_id" class="form-control" autocomplete="off" required
                        value="{{ old('user_id') }}">
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-secondary">Issue Book</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
