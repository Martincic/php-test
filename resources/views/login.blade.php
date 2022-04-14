@extends('template')
@section('content')
<h1>LOGIN</h1>
<form action="{{ route('post-login') }}" method="post">
    @csrf
    <label for="email">Email:</label><br>
    <input type="text" id="email" name="email" value="ahsoka.tano@q.agency"><br>
    <label for="password">Password:</label><br>
    <input type="text" id="password" name="password" value="Kryze4President"><br><br>
    @if($errors->any())
        <h4 style="color:red;margin:0;">{{$errors->first()}}</h4>
    @endif
    <input type="submit" value="Submit">
</form> 
@endsection