<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;


use App\Models\Product;
use App\Models\Category;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SearchFilterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function search(Request $request)
    {
        $checkValid = false;
        if (
            ($request->status && !is_array($request->status)) ||
            ($request->featured && !is_array($request->featured)) ||
            ($request->category_id && !is_numeric($request->category_id))
        ) {
            $checkValid = true;
        } else {
            if ($request->featured) {
                foreach ($request->featured as $key => $value) {
                    $checkValid = !is_numeric($value) ? true : false;
                }
            }

            if ($request->status) {
                foreach ($request->status as $key => $value) {
                    $checkValid = !is_numeric($value) ? true : false;
                }
            }
        }

        if ($checkValid) {
            return response()->json(['status_code' => 400, 'msg' => "Query params not correct", 'queryparams' => ["s" => "truyền vào phải là chuỗi", "status-featured" => "truyền vào là mảng và phần tử mảng là number", "category_id" => "phải là số"]]);
        }


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

    public function get_category()
    {
        $data = Category::orderBy('created_at', 'DESC')->get(["id", "name"]);
        return response()->json(['status_code' => 200, 'msg' => "Kết nối thành công nha bạn.", "data" => $data]);
    }
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
