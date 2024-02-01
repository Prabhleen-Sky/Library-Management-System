<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

</head>

<body>

    @include('navbar', ['panelTitle' => 'Admin Panel', 'panelRoute' => 'adminpanel'])

    {{-- content  --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-2 d-flex justify-content-around align-items-center p-2 pt-3 ">
                        <a href="{{ route('manage.books') }}" class="btn custom-btn">Manage Books</a>
                        <a href="{{ route('manage.students') }}" class="btn custom-btn ml-2">Manage Students</a>
                        <a href="{{ route('manage.issued.books') }}" class="btn custom-btn ml-2">Manage Issued Books</a>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</body>

</html>
