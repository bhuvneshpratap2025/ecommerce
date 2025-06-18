<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - @yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        body { display: flex; min-height: 100vh; margin: 0; }
        .sidebar {
            width: 220px;
            background: #343a40;
            color: white;
            padding: 20px;
        }
        .sidebar a {
            display: block;
            color: white;
            margin-bottom: 10px;
            text-decoration: none;
        }
        .sidebar a:hover {
            text-decoration: underline;
        }
        .content {
            flex: 1;
            padding: 30px;
            background-color: #f8f9fa;
        }
        .addProduct{
            margin-left:15px;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h4 style="font-size: x-large;">Admin Panel</h4>
        <a href="/dashboard">Dashboard</a>
        @if(auth()->user()->hasRole('super-admin') && auth()->user()->hasRole('admin') && auth()->user()->hasRole('default'))
            <a href="{{ route('users.index') }}">Manage Users</a>  
            <a class="addProduct" href="{{ route('users.create') }}">Add User</a>    
            <a href="{{ route('products.index') }}">Manage Products</a>
            <a class="addProduct" href="{{ route('products.create') }}">Add Product</a>            
            <a href="{{ route('categories.index') }}">Manage Categories</a>
            <a class="addProduct" href="{{ route('categories.create') }}">Add Category</a>   
            <a href="{{ route('products.index') }}">Manage Orders</a>      
            <a href="{{ route('roles.index') }}">Manage Roles</a>   
            <a class="addProduct" href="{{ route('roles.create') }}">Add Role</a>          
        @elseif(auth()->user()->hasRole('admin') && auth()->user()->hasRole('default'))
            <a href="{{ route('products.index') }}">Manage Products</a>
            <a href="{{ route('categories.index') }}">Manage Categories</a>  
        @else
            <p>You are a regular user</p>
        @endif
    </div>

    <div class="content">
        @yield('content')
    </div>

</body>
</html>
