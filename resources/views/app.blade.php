<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <!--<meta http-equiv="X-UA-Compatible" content="IE=edge">-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <title>Plantilla</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    </head>
    <body>
        <div id="app">
            <main-app/>
        </div>

        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
