<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak</title>
    <!-- Bootstrap CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        /* Optional: Custom styles for better visual appeal */
        .error-container {
            padding: 4rem 2rem;
        }
        .error-icon {
            font-size: 5rem;
            color: #dc3545; /* Bootstrap's danger color */
        }
    </style>
</head>

@extends('SideBar')
@section('title', 'Akses Ditolak')
@section('content')

<body>
    <div class="container text-center error-container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <!-- SVG Icon for Access Denied -->
                <svg class="mb-4" xmlns="http://www.w3.org/2000/svg" width="96" height="96" fill="#dc3545" class="bi bi-shield-lock-fill" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.8 11.8 0 0 0 2.517 2.453c.386.273.744.54.992.713.248-.173.606-.44.992-.713a11.8 11.8 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.54 1.54 0 0 0-1.044-1.262c-.658-.215-1.777-.57-2.887-.87C9.843.266 8.69 0 8 0m0 5a1.5 1.5 0 0 1 .5 2.915l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595l.384-1.99A1.5 1.5 0 0 1 8 5"/>
                </svg>

                <h1 class="display-5 fw-bold text-danger">Akses Ditolak</h1>
                <p class="lead mt-3">
                    Maaf, Anda tidak memiliki izin atau hak akses untuk melihat halaman ini.
                </p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
@endsection
</html>
