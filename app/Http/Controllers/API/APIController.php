<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class APIController extends Controller
{
    //http://127.0.0.1:8000/api/register-user
    public function registerUser(Request $request)
    {
        if($request->isMethod('post'))
        {
            $data = $request->input();

            $user = new User();
            $user->name = $data["name"];
            $user->email = $data["email"];
            $user->password = bcrypt($data["password"]);
            $user->save();

            return response()->json(['status'=>true,'message'=>'Tebrikler kayıt başarılı'],201);
        }
    }
}
