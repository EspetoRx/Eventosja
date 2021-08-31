<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>EventosJá</title>

        <link rel="stylesheet" href="{{mix('css/app.css')}}">
    </head>
    <body>
        <div id="app">
            <vue-progress-bar></vue-progress-bar>
            <navbar-component></navbar-component>
            <router-view class="p-2"></router-view>
        </div>
        <script src="{{mix('js/app.js')}}"></script>
    </body>
</html>
