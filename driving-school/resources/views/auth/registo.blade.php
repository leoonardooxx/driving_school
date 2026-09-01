<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="{{url('register')}}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Name">
        <input type="text" name="last_name" placeholder="last_name">
        <input type="email" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">
        <input type="text" name="profile" placeholder="profile">
        <input type="text" name="nif" placeholder="nif">
        
        <button type="submit">Register</button>
    </form>
    
    @foreach($errors->all() as $error)
    <div>
        {{$error}}
    </div>
    @endforeach
</body>
</html>
