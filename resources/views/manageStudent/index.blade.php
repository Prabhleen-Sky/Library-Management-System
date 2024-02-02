<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Student</title>
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
                                <h3 class="text-lg font-semibold mb-4">List of Students</h3>
                                <a href="{{ route('add.student') }}" class="btn btn-secondary btn-md m-2 mb-4 p-2">Add
                                    Student
                                </a>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            {{-- <th>ID</th> --}}
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $student)
                                            <tr>
                                                {{-- <td>{{ $student->user_id }}</td> --}}
                                                <td>{{ $student['fname'] }}</td>
                                                <td>{{ $student['lname'] }}</td>
                                                <td>{{ $student['email'] }}</td>
                                                <td>{{ $student['phone'] }}</td>
                                                <td>{{ $student['status'] }}</td>
                                                <td>
                                                    <button class="btn btn-danger btn-sm"
                                                        onclick="confirmDelete('{{ $student['_id'] }}')">Delete </button>
                                                    {{-- <a href="{{ route('delete.student', ['id' => $student['_id']]) }}"
                                                        class="btn btn-danger btn-sm">Delete</a> --}}
                                                    <a href="{{ route('edit.student', ['id' => $student['_id']]) }}"
                                                        class="btn btn-warning btn-sm ml-1">Edit</a>
                                                    <a href="{{ route('issue.book', ['id' => $student['_id']]) }}"
                                                        class="btn btn-primary btn-sm ml-1">Issue Book</a>
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

    <script>
        function confirmDelete(userId) {
            var result = confirm("Are you sure you want to delete this user?");
            if (result) {
                window.location.href = "{{ url('delete-student') }}/" + userId;
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
