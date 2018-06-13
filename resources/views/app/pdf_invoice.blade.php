@extends('layouts.pdf')
@section('content')
    @include('app.single_invoice', ['invoice' => $invoice, 'h1' => $h1, 'h2' => $h2])
@stop
