<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{$data['title']}}</title>
</head>
<body>

    <p>{{ $data['body'] }}</p>
    <a href="{{ $data['url'] }}">click here to reset password.</a>
    <p>{{ $data['ignore'] }}</p>
    <p>Thank You</p>

</body>
</html>