<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        if (auth()->check()) {
            $wishlist = auth()->user()->wishlistItems()->with('product')->get();
        }else{
            $wishlist = collect(); // always returns a Collection
        }
        
        $products = Product::orderBy('created_at', 'desc')->paginate(10); // paginate 10 per page
        if ($request->wantsJson()) {
            return response()->json($products);
        }
        if(is_null(Auth::user())){
              return view('products.productslist', compact(['wishlist','products']));
        }else if(in_array('super-admin',Auth::user()->getRoleNames()->toArray())){
             return view('admin.products.index',compact(['wishlist','products']));
        }else if(in_array('admin',Auth::user()->getRoleNames()->toArray())){
             return view('admin.products.index', compact(['wishlist','products']));
        }else{
            return view('products.productslist', compact(['wishlist','products']));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all(); // paginate 10 per page
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:10',
            'description' => 'required|string|min:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors()
                ], 422);
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Product::create($request->all());

        $message = 'Product created successfully.';

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => $message,
            ], 201);
        }

        return redirect()->route('products.index')->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
       
        return response()->json([
            'status' => 'success',
            'data' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
         $categories = Category::all(); // paginate 10 per page
         //return view('admin.products.create', compact('categories'));
        return view('admin.products.edit', compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {   
        try {
            $product = Product::findOrFail($id);
            $validator = Validator::make($request->all(), [
                'name' =>           'sometimes|string|min:10',
                'description' =>    'sometimes|string|min:255',
                'price' =>          'sometimes|numeric|min:1',
                'stock' =>          'sometimes|integer|min:1',
                'category_id' =>    'sometimes|integer',
            ]);
           
            if ($validator->fails()) {
                if ($request->wantsJson()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Validation failed.',
                        'errors' => $validator->errors()
                    ], 422);
                }
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $product->update($validator->validated());
            if ($request->wantsJson()) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Product updated successfully.',
                    ], 201);
                }
            return redirect()->route('products.index')->with('success', 'Product updated successfully.');
        } catch (ModelNotFoundException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Product not found.'
                ], 404);
            }
            return redirect()->route('products.index')->with('error', 'Product not found.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id){
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Product deleted successfully.'
                ], 200);
            }
            return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
        } catch (ModelNotFoundException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Product not found.'
                ], 404);
            }
            return redirect()->route('products.index')->with('error', 'Product not found.');
        }
    }
    public function search(Request $request)
    {   
        if (auth()->check()) {
            $wishlist = auth()->user()->wishlistItems()->with('product')->get();
        }else{
            $wishlist = collect(); // always returns a Collection
        }
        
        $products = Product::where('name', 'like', '%' . $request->query('query') . '%')->orderBy('created_at', 'desc')->paginate(10); // paginate 10 per page
        if ($request->wantsJson()) {
            return response()->json($products);
        }
        return view('products.productslist', compact(['products','wishlist']));
    }
}
