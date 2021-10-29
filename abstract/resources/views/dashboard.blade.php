<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="antialiased dashboard-body">
<form class="form-signin" action="/upload" method="post" enctype="multipart/form-data">
    @csrf
    <h1 class="h3 mb-3 font-weight-normal">{{__('labels.addFail')}}</h1>
    <label for="inputEmail" class="sr-only">{{__('labels.failName')}}</label>
    <input type="text" id="fileName" name="fileName" class="form-control" autofocus="">
    <label for="inputPassword" class="sr-only">{{__('labels.chooseFile')}}</label>
    <input type="file" id="file" name="file" class="form-control" required="">
    <button class="btn btn-lg btn-primary btn-block" type="submit">{{__('labels.upload')}}</button>
</form>
</body>
</html>
