<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class APIController extends Controller
{
    //http://127.0.0.1:8000/api/users
    public function getUsers()
    {
        $getUsers = User::get();
        //return $getUsers;
        return response()->json(["users" => $getUsers], 200);
    }

    //http://127.0.0.1:8000/api/user/2
    public function getByUserId($id)
    {
        $getByUserId = User::find($id);
        //return $getByUserId;
        return response()->json(["user" => $getByUserId], 200);
    }
}
