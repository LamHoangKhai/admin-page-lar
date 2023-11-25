<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreRequest;
use App\Http\Requests\Admin\User\UpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.modules.user.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        User::create([
            "email" => $request->email,
            "password" => bcrypt($request->password),
            "level" => $request->level,
            "phone" => $request->phone,
            "full_name" => $request->full_name,
            "status" => $request->status,
        ]);
        return redirect()->route("admin.user.index")->with("success", "Create user success");
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
        $user = User::findOrFail($id);
        $my_sefl = false;
        if (Auth::user()->id == $id) {
            $my_sefl = true;
        }

        $permission = true;

        if (Auth::user()->id != "9ab0345b-59de-4d6f-85ac-091cfc88204d" && ($user["level"] == 2 && !$my_sefl)) {
            $permission = false;
        }
        if (Auth::user()->id != "9ab0345b-59de-4d6f-85ac-091cfc88204d" && $id == "9ab0345b-59de-4d6f-85ac-091cfc88204d") {
            $permission = false;
        }


        if ($permission) {
            return view('admin.modules.user.edit', ["data" => $user, "id" => $id]);
        } else {
            return redirect()->route("admin.user.index")->with("error", "Not permision edit!");
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {

        $dataCurrent = User::findOrFail($id);
        $data = [
            "full_name" => $request->full_name,
            "level" => $request->level,
            "phone" => $request->phone,
            "status" => $request->status,
        ];

        if (!empty($request->password)) {
            $request->validate([
                "password" => "min:6",
                "confirmation_password" => "required|same:password",
            ], [
                "password.min" => "Password toi thieu 6 ky tu",
                "confirmation_password.same" => "Password confirmation không giống nhau",
                "confirmation_password.required" => "Vui lòng nhập password confirm",
            ]);
            $data["password"] = bcrypt($request->password);
        }

        $dataCurrent->update($data);
        return redirect()->route("admin.user.index")->with("success", "Update user success");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->status = 3;
        $user->save();
        return redirect()->route("admin.user.index")->with("success", "Delete user success");
    }
}
