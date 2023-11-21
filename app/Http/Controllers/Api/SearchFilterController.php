<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use APP\Http\Controllers\Admin\ProductController;
use APP\Http\Controllers\Admin\CategoryController;

use App\Models\Product;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SearchFilterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function search(Request $request)
    {
        $search = $request->s ? $request->s : "";
        $status = $request->status ? $request->status : [1, 2];
        $featured = $request->featured ? $request->featured : [1, 2];
        $category_id = $request->category_id;

        $queryWhere[] = ["name", "like", "%" . $search . "%"];

        if ($category_id) {
            $queryWhere[] = ["category_id", "=", $category_id];
        }

        $data = Product::with("category")->where($queryWhere)->whereIn("status", $status)->whereIn("featured", $featured)->get();
        return response()->json(['status_code' => 200, 'msg' => "Kết nối thành công nha bạn.", "data" => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
