<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Student Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        .card {
            box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;
        }
    </style>

</head>

<body class="bg-light d-flex align-items-center justify-content-center m-2 p-2" style="height: 100vh;">


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
            <h3 class="text-lg font-semibold mb-4">Edit Book</h3>

            <form action="{{ route('store.updated.book', ['id' => $book['_id']]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Book Name</label>
                    <input type="text" name="name" id="name" class="form-control" autocomplete="off" required
                        value="{{ old('name', $book['name']) }}">
                </div>

                <div class="mb-3">
                    <label for="author" class="form-label">Author</label>
                    <input type="text" name="author" id="author" class="form-control" autocomplete="off" required
                        value="{{ old('author', $book['author']) }}">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" autocomplete="off" required> {{ old('description', $book['description']) }} </textarea>
                </div>

                <div class="mb-3">
                    <label for="total_inventory" class="form-label">Total Inventory</label>
                    <input type="number" name="total_inventory" id="total_inventory" class="form-control"
                        autocomplete="off" required
                        value="{{ intval(old('total_inventory', $book['total_inventory'])) }}">
                </div>

                <div class="mb-3">
                    <label for="issued_copies" class="form-label">Issued Copies</label>
                    <input type="number" name="issued_copies" id="issued_copies" class="form-control"
                        autocomplete="off" required value="{{ intval(old('issued_copies', $book['issued_copies'])) }}">
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" name="price" id="price" class="form-control" autocomplete="off" required
                        value="{{ old('price', $book['price']) }}">
                </div>

                <div class="mb-3">
                    <label for="photo" class="form-label">Book Photo</label>
                    <input type="file" name="photo" id="photo" class="form-control" accept="image/*">

                    @if ($book['photo'])
                        <label class="block text-sm font-medium text-gray-700">Current Photo : </label>
                        <img src="{{ asset('storage/' . $book['photo']) }}" alt="Current Book Photo" class="mt-2 mx-w-xs"
                            style="max-width: 80px;">
                    @endif
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-warning">Edit Book</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
