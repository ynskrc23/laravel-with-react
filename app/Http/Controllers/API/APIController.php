<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class APIController extends Controller
{
    //http://127.0.0.1:8000/api/register-user
    public function registerUser(Request $request)
    {
        if($request->isMethod('post'))
        {
            $data = $request->input();

            $rules = [
                "name" => "required",
                "email" => "required|email|unique:users",
                "password" => "required"
            ];

            $customMessages = [
                "name.required" => "Bu alan zorunlu",
                "email.required" => "Bu alan zorunlu",
                "email.unique" => "Bu mail zaten kayıtlı",
                "password.required" => "Bu alan zorunlu",
            ];

            $validator = Validator::make($data,$rules,$customMessages);
            if($validator->fails()){
                return response()->json([$validator->errors()],422);
            }

            $user = new User();
            $user->name = $data["name"];
            $user->email = $data["email"];
            $user->password = bcrypt($data["password"]);
            $user->save();

            return response()->json(['status'=>true,'message'=>'Tebrikler kayıt başarılı'],201);
        }
    }
}
