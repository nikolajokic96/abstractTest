<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="antialiased login-body">
<form class="form-signin" action="/login" method="post">
    <h1 class="h3 mb-3 font-weight-normal">{{__('labels.signIn')}}</h1>
    <label for="inputEmail" class="sr-only">{{__('labels.username')}}</label>
    <input type="text" id="inputEmail" name="username" class="form-control" required="" autofocus="">
    <label for="inputPassword" class="sr-only">{{__('labels.password')}}</label>
    <input type="password" id="inputPassword" name="password" class="form-control" required="">
    <button class="btn btn-lg btn-primary btn-block" type="submit">{{__('labels.signButton')}}</button>
</form>
</body>
</html>
