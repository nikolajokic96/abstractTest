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
<br>
<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col">{{__('crud.fileName')}}</th>
        <th scope="col">{{__('crud.filePath')}}</th>
        <th scope="col">{{__('crud.zipFilePath')}}</th>
        <th scope="col">{{__('crud.action')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($files as $file)
        <tr>
            <td>{{$file->getFile()['fileName']}}</td>
            <td>{{$file->getFile()['path']}}</td>
            <td>{{$file->getZipFile()['path']}}</td>
            <td>
                <div class="flex">
                    <form action="/download" method="post">
                        <input type="hidden" name="filePath" value="{{$file->getZipFile()['path']}}">
                        <button type="submit" class="btn btn-outline-primary">{{__('crud.download')}}</button>
                    </form>&nbsp;
                    <form action="/delete" method="post">
                        <input type="hidden" name="fileName" value="{{$file->getFile()['fileName']}}">
                        <button type="submit" class="btn btn-outline-danger">{{__('crud.delete')}}</button>
                    </form>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
