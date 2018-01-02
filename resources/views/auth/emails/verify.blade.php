<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <h1>{{ $data['title'] }}</h1><br>

    <p> {{ $data['content'] }} <a href="http://project.test/account/verify/{{ $user->confirmation }}"> http://project.test/account/verify/{{ $user->confirmation }} </a></p>

</body>
</html>