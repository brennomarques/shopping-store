@extends('mails.layout')

@section('content')
<img src="{{ asset('image/logo.png') }}" width="300">

<h3 style="color: #013D52">Bem-vindo ao Shopping Store!</h3>

<img src="{{ asset('image/mail/welcome.png') }}" width="300">
<p><strong>{{ $user->name }}</strong>! Explore nosso catálogo e aproveite as melhores ofertas.</p>
<p>Estamos aqui para tornar sua experiência de compras simples e satisfatória. Boas compras!</p>

@endsection