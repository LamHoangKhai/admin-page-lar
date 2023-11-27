<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreRequest;
use App\Http\Requests\Admin\Product\UpdateRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::get();
        $data = Product::with("category")->orderBy('created_at', 'DESC')->paginate(20);
        $data->withPath('/admin/product/index');
        return view('admin.modules.product.index', ["products" => $data, "categories" => $categories]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $product = new Product();

        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->content = $request->content;
        $product->status = $request->status;
        $product->featured = $request->featured;
        $product->category_id = $request->category_id;
        $product->user_id = Auth::user()->id;
        $product->save();

        if (count($request->images) > 0) {
            $data_images = [];
            foreach ($request->images as $image_detail) {
                $filename = rand(1, 10000) . time() . "." . $image_detail->getClientOriginalName();
                $image_detail->move(public_path("uploads"), $filename);
                $data_images[] = [
                    "images" => $filename,
                    "product_id" => $product->id,
                ];

            }
            ProductImage::insert($data_images);
        }
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
        $data = Product::with("product_images")->findOrFail($id);
        $categories = Category::all();
        return view('admin.modules.product.edit', ["data" => $data, "id" => $id, "categories" => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $dataCurrent = Product::findOrFail($id);
        $data = [
            "name" => $request->name,
            "price" => $request->price,
            "description" => $request->description,
            "content" => $request->content,
            "status" => $request->status,
            "featured" => $request->featured,
            "category_id" => $request->featured,
        ];

        if (count($request->images) > 0) {
            $data_images = [];
            foreach ($request->images as $image_detail) {
                $filename = rand(1, 10000) . time() . "." . $image_detail->getClientOriginalName();
                $image_detail->move(public_path("uploads"), $filename);
                $data_images[] = [
                    "images" => $filename,
                    "product_id" => $dataCurrent->id,
                ];

            }
            ProductImage::insert($data_images);
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

    public function uploadFile(Request $request, $id)
    {

        $product_image = ProductImage::findOrFail($id);
        $imageCurrent = public_path("uploads/") . $product_image->images;
        if (file_exists($imageCurrent)) {
            unlink($imageCurrent);
        }

        $file = $request->image;
        $filename = time() . '.' . $file->getClientOriginalName();
        $file->move(public_path("uploads"), $filename);

        $product_image->images = $filename;
        $product_image->save();
        return response()->json(["success" => "Thành công"], 200);
    }

    public function deleteFile($id)
    {

        $product_image = ProductImage::findOrFail($id);
        $imageCurrent = public_path("uploads/") . $product_image->images;
        if (file_exists($imageCurrent)) {
            unlink($imageCurrent);
        }

        $product_image->delete();
        return response()->json(["success" => "Thành công"], 200);
    }
}
