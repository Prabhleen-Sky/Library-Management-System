<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Books</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        /* Add your custom styles here */
        /* Left Side Navigation Styles */
        .sidenav {
            height: 200px;
            width: 250px;
            z-index: 1;
            margin-top: 6%;
            margin-left: 3%;
            margin-right: 7%;
            background-color: #cdcfd2;
            overflow-x: hidden;
            transition: 0.5s;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
            border-radius: 5%;
        }

        .sidenav a {
            padding: 8px 8px 8px 32px;
            background-color: rgb(150, 154, 174);
            /* color: #fff;  */
            color: #F8F9FA;
            text-decoration: none;
            font-size: 18px;
            /* color: #D3D3D3;  */
            display: block;
            transition: 0.3s;
            margin: 2%;
        }

        .sidenav a:hover {
            color: #F8F9FA;
            /* Lighter text color on hover */
            background-color: rgb(125, 129, 147);
        }

        /* Main Content Margin */
        .content {
            margin-left: 250px;
            transition: margin-left 0.5s;
        }
    </style>

</head>

<body>

    @include('navbar', ['panelTitle' => 'Admin Panel', 'panelRoute' => 'adminpanel'])

    <div class="parent-div d-flex justify-content-start">


        <div class="sidenav bg-light d-flex flex-column ">
            <a href="{{ route('manage.books') }}" class="btn btn-light text-light mb-2 mt-4">Manage Books</a>
            <a href="{{ route('manage.students') }}" class="btn btn-light text-light mb-2">Manage Students</a>
            <a href="{{ route('manage.issued.books') }}" class="btn btn-light text-light mb-2">Manage Issued Books</a>
        </div>



        <div class="py-12 m-4">
            <div class="container">

                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">

                            <div class="d-flex justify-content-between p-2">
                                <h3 class="text-lg font-semibold mb-4">List of Books</h3>
                                <a href="{{ route('add.book') }}" class="btn btn-secondary btn-md m-2 mb-4 p-2">Add
                                    Book
                                </a>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Photo</th>
                                            <th>Name</th>
                                            <th>Author</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Total Inventory</th>
                                            <th>Issued Copies</th>
                                            <th>Price</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($books as $book)
                                            <tr>
                                                <td><img src="{{ asset('storage/' . $book['photo']) }}"
                                                        alt="{{ $book['name'] }}" style="max-width: 50px;"></td>
                                                <td>{{ $book['name'] }}</td>
                                                <td>{{ $book['author'] }}</td>
                                                <td>{{ $book['description'] }}</td>
                                                <td>{{ $book['status'] }}</td>
                                                <td>{{ $book['total_inventory'] }}</td>
                                                <td>{{ $book['issued_copies'] }}</td>
                                                <td><span style="display: inline-block;">Rs.
                                                    </span>{{ $book['price'] }}</td>

                                                <td>
                                                    <div class="d-flex align-items-center justify-content-between">

                                                        <button class="btn btn-danger btn-sm"
                                                            onclick="confirmDelete('{{ $book['_id'] }}')">Delete
                                                        </button>

                                                        <a href="{{ route('edit.book', ['id' => $book['_id']]) }}"
                                                            class="btn btn-warning btn-sm ml-1">Edit</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                       
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center align-items-center">
        {{ $books->links() }}
    </div>

    <script>
        function confirmDelete(bookId) {
            var result = confirm("Are you sure you want to delete this book?");
            if (result) {
                window.location.href = "{{ url('delete-book') }}/" + bookId;
            }
        }
    </script>

    <!-- Success Modal -->
    @if (session('success'))
        <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="successModalLabel">Success</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{ session('success') }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Show the success modal on page load
            document.addEventListener('DOMContentLoaded', function() {
                var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
            });
        </script>
    @endif

    <!-- Error Modal -->
    @if ($errors->any())
        <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="errorModalLabel">Error</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Show the error modal on page load
            document.addEventListener('DOMContentLoaded', function() {
                var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                errorModal.show();
            });
        </script>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>
