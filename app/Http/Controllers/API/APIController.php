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

            $messages = "Tebrikler kayıt başarılı";
            return response()->json(['status'=>true,'message'=>$messages],201);
        }
    }

    //http://127.0.0.1:8000/api/login-user
    public function loginUser(Request $request)
    {
        if($request->isMethod('post'))
        {
            $data = $request->input();

            $userCount = User::where('email',$data['email'])->count();
            if($userCount)
            {
                $userDetails = User::where('email',$data['email'])->first();
                if(password_verify($data['password'],$userDetails->password))
                {
                    $messages = "Giriş işlemi başarılı";
                    return response()->json(['status'=>true,'message'=>$messages],201);
                }
                else
                {
                    $messages = "Şifreniz yanlış lütfen kontrol ediniz.";
                    return response()->json(['status'=>false,'message'=>$messages],422);
                }
            }
            else
            {
                $messages = "Bu email bulunamadı lütfen kontrol ediniz.";
                return response()->json(['status'=>false,'message'=>$messages],422);
            }
        }
    }
}
