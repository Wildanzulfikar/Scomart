@extends('layouts.app')

@section('title', 'User Dashboard')

@section('header')
    <h2 class="text-xl font-semibold">Dashboard User</h2>
@endsection

@section('content')
    <div class="py-4 text-gray-900">
        Selamat datang di dashboard user, {{ Auth::user()->name }}!
    </div>
@endsection
