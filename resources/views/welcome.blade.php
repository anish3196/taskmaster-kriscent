<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ env('APP_NAME') }}</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link href="https://cdn.datatables.net/v/dt/dt-1.13.5/datatables.min.css" rel="stylesheet"/>
      {{-- <script src="https://code.jquery.com/jquery-3.7.0.js"></script> --}}

      <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        {{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}"> --}}

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased nav-md"> 
        <div class="container body">
        <div id="app" class="main_container">
        </div>
    </div>
        {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
            
    </body>
</html>
