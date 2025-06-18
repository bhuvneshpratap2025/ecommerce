@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <p>Welcome, {{ Auth::user()->name }}!</p>

    <p>Your role(s): {{ implode(', ', Auth::user()->getRoleNames()->toArray()) }}</p>

    @role('admin')
        <p>You have full admin access.</p>
    @endrole

    @role('writer')
        <p>You can write and manage your articles.</p>
    @endrole
@endsection
