<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route("admin.home");
        }
        return view("auth.login");
    }
    public function login(LoginRequest $request)
    {
        $user = User::where("email", $request->email)->first();

        if (!$user || $user->level == 1) {
            return redirect("/");
        }



        $credentials = [
            "email" => $request->email,
            "password" => $request->password,
            "status" => 1,
        ];

        if (Auth::attempt($credentials)) {
            return redirect()->route('admin.category.index')->with('success', "Login success");
        }

        return redirect()->route("showLogin")->with("error", "Login fail");
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
