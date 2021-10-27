@extends('layouts.main')
@section('content')
    hallo {{ Auth::user()->name }}
@endsection