@extends('layouts.admin')

@section('content')
  @section('title', 'Add User')  
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Add User') }}
        </h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                {!! Form::open(['route' => 'users.store']) !!}

                <div class="mb-4">
                    {!! Form::label('name', 'Name',['class' => 'block text-gray-700 font-bold mb-2']) !!}
                    {!! Form::text('name',null,['class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline','id' => 'name', 'placeholder' => 'Enter name']) !!}
                    @if ($errors->has('name'))
                    <span class="error" style="color:red">{{ $errors->first('name') }}</span>
                    @endif
                </div>

                <div class="mb-4">
                    {!! Form::label('name', 'Email',['class' => 'block text-gray-700 font-bold mb-2']) !!}
                    {!! Form::text('email',null,['class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline','id' => 'email', 'placeholder' => 'Enter email']) !!}
                    @if ($errors->has('email'))
                    <span class="error" style="color:red">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                <div class="mb-4">
                    {!! Form::label('name', 'Password',['class' => 'block text-gray-700 font-bold mb-2']) !!}
                    {!! Form::text('password','secret123',['class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline','id' => 'email', 'placeholder' => 'Enter Password']) !!}
                    @if ($errors->has('password'))
                    <span class="error" style="color:red">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="mb-4">
                    {!! Form::label('name', 'Confirm Password',['class' => 'block text-gray-700 font-bold mb-2']) !!}
                    {!! Form::text('password_confirmation','secret123',['class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline','id' => 'email', 'placeholder' => 'Enter confirm password']) !!}
                    @if ($errors->has('password_confirmation'))
                    <span class="error" style="color:red">{{ $errors->first('password_confirmation') }}</span>
                    @endif
                </div>
                <div class="mb-4">
                    {!! Form::label('name', 'Select Role',['class' => 'block text-gray-700 font-bold mb-2']) !!}
                    {!! Form::select('role', $roles->pluck('name', 'id'), null, ['class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline', 'placeholder' => 'Select role']) !!}
                    @if ($errors->has('role'))
                    <span class="error" style="color:red">{{ $errors->first('role') }}</span>
                    @endif
                </div>
               
                <button type="submit" style="background-color: deepskyblue;" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Add User
                </button>
                <a href="{{ route('products.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800">
                    Cancel
                </a>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</x-app-layout>
@endsection