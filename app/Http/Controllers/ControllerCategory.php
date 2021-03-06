<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class ControllerCategory extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.categories', compact('categories'));
    }

    public function create()
    {
        return view('categories.newCategory');
    }

    public function store(Request $request)
    {
        $msg = [
            'categoryName.required' => 'Por favor, insira o nome da categoria',
            'categoryName.unique' => 'Essa categoria já está cadastrada'
        ];

        $request->validate([
            'categoryName' => 'required|unique:App\Category,name',
        ], $msg);

        $category = new Category();
        $category->name = $request->input('categoryName');
        $category->save();

        return redirect('/categories');
    }

    public function edit($id)
    {
        $category = Category::find($id);

        return isset($category) 
            ? view('categories.editCategory', compact('category')) 
            : redirect('/categories');
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        $msg = [
            'categoryName.required' => 'Por favor, insira o novo nome da categoria',
            'categoryName.unique' => 'Essa categoria já está cadastrada'
        ];
        
        $request->validate([
            'categoryName' => 'required|unique:App\Category,name',
        ], $msg);

        if (isset($category)) {
            $category->name = $request->input('categoryName');
            $category->save();
        }

        return redirect("/categories");
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if (isset($category)) {
            $category->delete();
        }

        return redirect('/categories');
    }
}
