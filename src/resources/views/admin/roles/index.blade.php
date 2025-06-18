@extends('layouts.admin')

@section('content')
    
<x-app-layout>
    @section('title', 'Role List')
 @if(session('success'))
        <div style="color: green; background: #d4edda; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="color: red; background: #f8d7da; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
            {{ session('error') }}
        </div>
    @endif
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Role List') }}
        </h2>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name
                            </th>
                            
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($roles as $role)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $role->name }}
                                </td>
                                

                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <!-- Edit Button -->
                                <a href="{{ route('roles.edit', $role->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    Edit
                                </a>
                                @if(auth()->user()->hasRole('super-admin') && auth()->user()->hasRole('admin') && auth()->user()->hasRole('default'))
                                <!-- Delete Button -->
                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        Delete
                                    </button>
                                </form>
                                 @endif
                            </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No products found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $roles->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@endsection

