@extends('layouts.admin')

@section('content')
  @section('title', 'Edit Role')  
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Role') }}
        </h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
               {!! Form::model($role, ['route' => ['roles.update', $role->id], 'method' => 'PUT']) !!}

                <div class="mb-4">
                    {!! Form::label('name', 'Name',['class' => 'block text-gray-700 font-bold mb-2']) !!}
                    {!! Form::text('name', old('name', $role->name ?? null),['class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline','id' => 'name', 'placeholder' => 'Enter name']) !!}
                    @if ($errors->has('name'))
                    <span class="error" style="color:red">{{ $errors->first('name') }}</span>
                    @endif
                </div>
             
                <button type="submit" style="background-color: deepskyblue;" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Role
                </button>
                <a href="{{ route('roles.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800">
                    Cancel
                </a>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</x-app-layout>
@endsection