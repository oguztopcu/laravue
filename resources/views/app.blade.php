<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Laravel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
</head>
<body>
    <div id="app"></div>

    <script>
        window.BASE_URL = "{{ config('app.api_url') }}";
    </script>
    @vite('resources/js/app.js')
</body>
</html>
