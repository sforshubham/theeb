@extends('layouts.pdf')
@section('content')
    @include('app.single_payment', ['payment' => $payment, 'h1' => $h1, 'h2' => $h2])
@stop
