@extends('layouts.admin')

@section('content')
  @section('title', 'Edit Category')  
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Category') }}
        </h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                     {!! Form::model($category, ['route' => ['categories.update', $category->id], 
                        'method' => 'PUT']) !!}
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="name">
                            Name
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                            @if ($errors->has('name'))
                                <span class="error" style="color:red">{{ $errors->first('name') }}</span>
                            @endif
                    </div>
                    <div class="mb-4">
                        {!! Form::label('name', 'Select Parent Category',['class' => 'block text-gray-700 font-bold mb-2']) !!}
                    
                        {!! Form::select('parent_id', $categories->pluck('name', 'id'), old('parent_id', $product->parent_id ?? null), ['class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline', 'placeholder' => 'Select Category']) !!}

                        @if ($errors->has('parent_id'))
                        <span class="error" style="color:red">{{ $errors->first('parent_id') }}</span>
                        @endif
                    </div>
                    

                    <div class="flex items-center justify-between">
                        <button type="submit" style="background-color: deepskyblue;"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Update Category
                        </button>

                        <a href="{{ route('categories.index') }}"
                           class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800">
                            Cancel
                        </a>
                    </div>
                 {!! Form::close() !!}
            </div>
        </div>
    </div>
</x-app-layout>
@endsection