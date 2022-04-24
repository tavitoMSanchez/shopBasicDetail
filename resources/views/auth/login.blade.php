@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    <div class="d-flex flex row g-0">
        <div class="col-md-6 mt-3">
            <div class="cardx card1 p-3">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                <div class="d-flex flex-column">  <span class="login mt-3" style="color: aliceblue">Iniciar sesion</span> </div>
                <div class="input-field d-flex flex-column mt-3"> 
                    <span style="color: aliceblue"  >Email</span>
                     <input class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus" placeholder="email@example.com"> 
                    <span  style="color: aliceblue" class="mt-3">Contraseña</span> 
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Ingresa tu contraseña">
                     <button type="submit" class="mt-4 btn btn-dark d-flex justify-content-center align-items-center">Iniciar</button>                 
                    <div  class="text2 mt-4 d-flex flex-row align-items-center"> <span style="color: aliceblue">No tienes una cuenta? <a class="nav-link register" href="{{ route('register') }}">Registrate aqui!</a> </span> </div>
                </div>
                </form>
            </div>
        </div>
      
    </div>
</div>
@endsection
