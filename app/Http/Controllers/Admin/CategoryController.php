<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\StoreRequest;
use App\Http\Requests\Admin\Category\UpdateRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Category::orderBy('created_at', 'DESC')->get();

        return view('admin.modules.category.index', ["categories" => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        Category::create([
            "parent_id" => $request->parent_id,
            "name" => $request->name,
            "status" => $request->status,
        ]);

        return redirect()->route('admin.category.index')->with('success', "Create category success");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Category::findOrFail($id);
        return view('admin.modules.category.edit', ["id" => $id, "data" => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $dataCurrent = Category::find($id);
        $data = [
            "parent_id" => $request->parent_id,
            "name" => $request->name,
            "status" => $request->status,
        ];
        $dataCurrent->update($data);
        return redirect()->route("admin.category.index")->with("success", "Update category success");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect()->route("admin.category.index")->with("success", "Delete category success");

    }
    public function record()
    {
        $categories = Category::onlyTrashed()->get();
        foreach ($categories as $category) {
            echo $category->id . "" . $category->name . "<br/>";
        }
        return "Success";

    }
    public function restore()
    {
        Category::withTrashed()->where('id', 1)->restore();
        return "Success";

    }
}
