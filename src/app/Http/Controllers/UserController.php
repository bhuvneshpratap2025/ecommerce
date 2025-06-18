<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10); // paginate 10 per page
        if(in_array('super-admin',Auth::user()->getRoleNames()->toArray())){
             return view('admin.users.index', compact('users'));
        }else if(in_array('admin',Auth::user()->getRoleNames()->toArray())){
             return view('admin.users.index', compact('users'));
        }else{
            die('You are not allowed.');
            //return view('products.productslist', compact('users'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::where('name', '!=', 'super-admin')->get();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:10',
            'email' => 'required|email|unique:users',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user = User::create($request->all());
        if(is_null($request->input('role'))){
           $user->assignRole('default');
        }else{
            $role = Role::findOrFail($request->input('role')); // Find user or throw 404
            $user->assignRole($role->name);
        }
        $user->password = Hash::make($request->input('password'));
        $user->save(); // Save changes
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {    
        $roles = Role::where('name', '!=', 'super-admin')->get();
        $user->role = $user->roles->first()?->id;
        return view('admin.users.edit', compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|min:10',
            'email' => ['required', 'email',Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);
        
        if(empty($request->input('password'))){
            $request->merge([
                'password' => 'secret123'
            ]);
        }
        $user->update($request->all());

        if(is_null($request->input('role'))){
           $user->assignRole('default');
        }else{
            $user->syncRoles([]);
            $role = Role::findOrFail($request->input('role')); // Find user or throw 404
            $user->assignRole($role->name);
        }
        $user->password = Hash::make($request->input('password'));
        $user->save(); // Save changes

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
        /* 
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|min:10',
                'description' => 'required|string|min:255',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $product->update($validator->validated());

            return redirect()->route('products.index')->with('success', 'Product updated successfully.');
        */
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
