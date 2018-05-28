<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contacts</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet" type="text/css">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-findcond h-100">
        <div class="container">
            <div class="navbar-header d-inline-block">
                <a href="http://homestead.test"><h1>Contacts directory</h1></a>
            </div>
        </div>
    </nav>
    @yield('content')
</div>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>