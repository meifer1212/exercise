<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- styles del app --}}
    <link rel="stylesheet" href="css/app.css">
    <title>Inicio</title>
</head>

<body>
    <div id="app" class="container">
        @yield('body')
    </div>
    {{-- js donde carga vue y demas --}}
    <script src="{{asset('js/app.js')}}"></script>
</body>
</html>
