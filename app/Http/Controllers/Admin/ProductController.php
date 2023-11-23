<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreRequest;
use App\Http\Requests\Admin\Product\UpdateRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        $data = Product::with("category")->orderBy('created_at', 'DESC')->get();

        return view('admin.modules.product.index', ["products" => $data, "categories" => $categories]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {

        $image = $request->image;
        $filename = time() . "." . $image->getClientOriginalName();



        $users = User::all();

        Product::create([
            "name" => $request->name,
            "price" => $request->price,
            "description" => $request->description,
            "content" => $request->content,
            "status" => $request->status,
            "featured" => $request->featured,
            "category_id" => $request->category_id,
            "user_id" => $users[0]->id,
            "image" => $filename
        ]);
        $image->move(public_path("uploads"), $filename);
        return redirect()->route('admin.product.index')->with('success', "Create product success");
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
        $data = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.modules.product.edit', ["data" => $data, "id" => $id, "categories" => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $dataCurrent = Product::findOrFailOrFail($id);
        $data = [
            "name" => $request->name,
            "price" => $request->price,
            "description" => $request->description,
            "content" => $request->content,
            "status" => $request->status,
            "featured" => $request->featured,
            "category_id" => $request->category_id
        ];

        if (!empty($request->image)) {
            $request->validate([
                'image' => 'mimes:png,jpg'
            ], [
                'image.mimes' => 'Vui lòng chọn đúng loại file (png,jpg)'
            ]);
            $imageCurrent = public_path("uploads/") . $dataCurrent->image;

            if (file_exists($imageCurrent)) {
                unlink($imageCurrent);
            }

            $image = $request->image;
            $filename = time() . "." . $image->getClientOriginalName();
            $image->move(public_path("uploads"), $filename);
            $data['image'] = $filename;
        }

        $dataCurrent->update($data);


        return redirect()->route('admin.product.index')->with('success', "Update product success");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $file = public_path("uploads/") . $product->image;

        if (file_exists($file)) {
            unlink($file);
        }

        $product->delete();
        return redirect()->route('admin.product.index')->with('success', 'Delete product success');
    }
}
