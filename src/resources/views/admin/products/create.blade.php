@extends('layouts.admin')

@section('content')
  @section('title', 'Add Product')  
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Add Product') }}
        </h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                {!! Form::open(['route' => 'products.store']) !!}

                <div class="mb-4">
                    {!! Form::label('name', 'Name',['class' => 'block text-gray-700 font-bold mb-2']) !!}
                    {!! Form::text('name',null,['class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline','id' => 'name', 'placeholder' => 'Enter name']) !!}
                    @if ($errors->has('name'))
                    <span class="error" style="color:red">{{ $errors->first('name') }}</span>
                    @endif
                </div>

                <div class="mb-4">
                    {!! Form::label('name', 'Description',['class' => 'block text-gray-700 font-bold mb-2']) !!}
                    {!! Form::textArea('description',null ,['rows'=>"4",'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline','id' => 'description', 'placeholder' => 'Enter name']) !!}
                    @if ($errors->has('description'))
                    <span class="error" style="color:red">{{ $errors->first('description') }}</span>
                    @endif
                </div>

                <div class="mb-4">
                    {!! Form::label('name', 'Stock',['class' => 'block text-gray-700 font-bold mb-2']) !!}
                    {!! Form::number('stock', null, ['class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline', 'min' => 0]) !!}
                    @if ($errors->has('stock'))
                    <span class="error" style="color:red">{{ $errors->first('stock') }}</span>
                    @endif
                </div>

                <div class="mb-4">
                    {!! Form::label('name', 'Price',['class' => 'block text-gray-700 font-bold mb-2']) !!}
                     {!! Form::number('price', null, ['class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline', 'min' => 0]) !!}
                    @if ($errors->has('price'))
                    <span class="error" style="color:red">{{ $errors->first('price') }}</span>
                    @endif
                </div>
                <div class="mb-4">
                    {!! Form::label('name', 'Select Category',['class' => 'block text-gray-700 font-bold mb-2']) !!}
                   
                    {!! Form::select('category_id', $categories->pluck('name', 'id'), null, ['class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline', 'placeholder' => 'Select Category']) !!}

                    @if ($errors->has('category_id'))
                    <span class="error" style="color:red">{{ $errors->first('category_id') }}</span>
                    @endif
                </div>
                <button type="submit" style="background-color: deepskyblue;" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Add Product
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