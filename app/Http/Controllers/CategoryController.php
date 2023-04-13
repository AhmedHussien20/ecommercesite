<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $search = $request->query('search');
        $categories = Category::where('name', 'LIKE', '%' . $search . '%')
                      ->orWhere('description', 'LIKE', '%' . $search . '%')
                      ->paginate(10);  
        return view('category.index',compact('categories'));
    }

   public function create(){
       return view('category/create');
   }
  
   public function insert(Request $request)
   {
    $data = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'description'=>[ 'string', 'max:255']
    ]);
    $category = Category::create($request->all());
    return redirect()->back()->with('success', 'Category created successfully.');
   }

   public function edit($id){
    $category = Category::find($id);
    return view('category.edit', compact('category'));
   }
   public function update(Request $request,$id){
    $category = Category::find($id);
    
    if (!$category) {
        return back()->withErrors([
            'message' => 'Category not found',
        ]);
    }
    
    $validatedData = $request->validate([
        'name' => ['required', 'string', 'max:255'],
    ]);
    
    $category->name = $validatedData['name'];
    $category->save();
    return redirect('/category/index')->with('success', 'Category updated successfully');

   }
   public function delete($id){
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('category.index')->with('success', 'Category deleted successfully');

   }
}
