@extends('mails.layout')

@section('content')
<img src="{{ asset('image/logo.png') }}" width="300">

<h3 style="color: #013D52">Sua compra foi confirmada!</h3>

<img src="{{ asset('image/mail/orderCompleted.png') }}" width="300">
<p><strong>{{ $user->name }}</strong>! Agora é só aguardar a entrega e aproveitar seu novo produto.</p>
<p>Estamos aqui para tornar sua experiência de compras simples e satisfatória.</p>

@endsection