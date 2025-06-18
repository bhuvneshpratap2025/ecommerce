<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate(10); // paginate 10 per page
        if(in_array('super-admin',Auth::user()->getRoleNames()->toArray())){
             return view('admin.categories.index', compact('categories'));
        }else if(in_array('admin',Auth::user()->getRoleNames()->toArray())){
             return view('admin.categories.index', compact('categories'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $categories = Category::all(); // paginate 10 per page
        return view('admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories',
            'parent_id' => 'nullable|integer'
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

        Category::create($request->all());

        $message = 'Category created successfully.';

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => $message,
            ], 201);
        }

        return redirect()->route('categories.index')->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = Category::all(); // paginate 10 per page
        return view('admin.categories.edit', compact(['category','categories']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string',Rule::unique('categories')->ignore($id)],
                'parent_id' => 'nullable|integer'
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
            $category->update($validator->validated());
            if ($request->wantsJson()) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Category updated successfully.',
                    ], 201);
                }
            return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
        } catch (ModelNotFoundException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Category not found.'
                ], 404);
            }
            return redirect()->route('categories.index')->with('error', 'Category not found.');
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
