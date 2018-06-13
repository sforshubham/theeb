@extends('layouts.pdf')
@section('content')
    @include('app.single_agreement', ['agreement' => $agreement, 'h1' => $h1, 'h2' => $h2])
@stop
