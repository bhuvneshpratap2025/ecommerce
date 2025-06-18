@extends('layouts.admin')

@section('content')
  @section('title', 'Edit Product')  
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Product') }}
        </h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('products.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="name">
                            Name
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                            @if ($errors->has('name'))
                                <span class="error" style="color:red">{{ $errors->first('name') }}</span>
                            @endif
                            </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="description">
                            Description
                        </label>
                        <textarea name="description" id="description" rows="4"
                                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description', $product->description) }}</textarea>
                                   @if ($errors->has('description'))
                                <span class="error" style="color:red">{{ $errors->first('description') }}</span>
                            @endif
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="price">
                            Price
                        </label>
                        <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                               @if ($errors->has('price'))
                                <span class="error" style="color:red">{{ $errors->first('price') }}</span>
                            @endif
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="stock">
                            Stock
                        </label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                               @if ($errors->has('stock'))
                                <span class="error" style="color:red">{{ $errors->first('stock') }}</span>
                            @endif
                    </div>
                    <div class="mb-4">
                        {!! Form::label('name', 'Select Category',['class' => 'block text-gray-700 font-bold mb-2']) !!}
                    
                        {!! Form::select('category_id', $categories->pluck('name', 'id'), old('category_id', $product->category_id ?? null), ['class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline', 'placeholder' => 'Select Category']) !!}

                        @if ($errors->has('category_id'))
                        <span class="error" style="color:red">{{ $errors->first('category_id') }}</span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between">
                        <button type="submit" style="background-color: deepskyblue;"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Update Product
                        </button>

                        <a href="{{ route('products.index') }}"
                           class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
@endsection