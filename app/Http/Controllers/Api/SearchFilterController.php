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


        $search = $request->search ? $request->search : "";
        $status = $request->status;
        $featured = $request->featured;
        $category_id = $request->category_id;
        $query = Product::with("category");
        $page = (int) $request->page;
        $skip = 0;

        $queryWhere[] = ["name", "like", "%" . $search . "%"];

        if ($category_id) {
            $queryWhere[] = ["category_id", "=", $category_id];
        }

        $query = $query->where($queryWhere);
        if ($status) {
            $query = $query->whereIn("status", $status);
        }
        if ($featured) {
            $query = $query->whereIn("featured", $featured);
        }
        if ($page > 1) {
            for ($i = 1; $i < $page; $i++) {
                $skip += 20;
            }

        }
        $countData = $query->count();
        $data = $query->skip($skip)->take(20)->get();

        return response()->json(['status_code' => 200, 'msg' => "Kết nối thành công nha bạn.", "data" => $data, "amountOfData" => $countData]);

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
