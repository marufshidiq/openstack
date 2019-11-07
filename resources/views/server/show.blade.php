<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Server List</title>
</head>
<body>
    <table border="1">
        <tr>
            <th>#</th>
            <th>Server Name</th>
            <th>Action</th>
        </tr>
        @foreach($servers as $server)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$server->name}}</td>
            <td>
                <a href="#" onClick="VNCWindow=window.open('{{formatVNCURL($server->getVncConsole()['url'])}}','VNCWindow','width='+screen.availWidth+',height='+screen.availHeight); return false;">VNC</a>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>