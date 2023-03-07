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
                "name.required" => "Name is required",
                "email.required" => "Email is required",
                "email.unique" => "Email already exists",
                "password.required" => "Password is required",
            ];

            $validator = Validator::make($data,$rules,$customMessages);
            if($validator->fails()){
                return response()->json($validator->errors(),422);
            }

            $user = new User();
            $user->name = $data["name"];
            $user->email = $data["email"];
            $user->password = bcrypt($data["password"]);
            $user->save();

            $messages = "Congratulations, the registration was successful.";
            return response()->json(['status'=>true,'message'=>$messages],201);
        }
    }

    //http://127.0.0.1:8000/api/login-user
    public function loginUser(Request $request)
    {
        if($request->isMethod('post'))
        {
            $data = $request->input();

            $rules = [
                "email" => "required|email|exists:users",
                "password" => "required"
            ];
            $customMessages = [
                "email.required" => "Email is required",
                "email.exists" => "Email does not exists",
                "password.required" => "Password is required"
            ];

            $validator = Validator::make($data,$rules,$customMessages);
            if($validator->fails()){
                return response()->json($validator->errors(),422);
            }

            $userCount = User::where('email',$data['email'])->count();
            if($userCount)
            {
                $userDetails = User::where('email',$data['email'])->first();
                if(password_verify($data['password'],$userDetails->password))
                {
                    $messages = "User Login Successfully!";
                    return response()->json([
                        'userDetails'=>$userDetails,
                        'status'=>true,
                        'message'=>$messages
                    ],201);
                }
                else
                {
                    $messages = "Password is Incorrect!";
                    return response()->json(['status'=>false,'message'=>$messages],422);
                }
            }
            else
            {
                $messages = "Email is Incorrect!";
                return response()->json(['status'=>false,'message'=>$messages],422);
            }
        }
    }

    public function updateUser(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->input();

            $rules = [
                "name" => "required"
            ];
            $customMessages = [
                "name.required" => "Name is required"
            ];

            $validator = Validator::make($data,$rules,$customMessages);
            if($validator->fails()){
                return response()->json($validator->errors(),422);
            }

            $userCount = User::where('id',$data['id'])->count();
            if($userCount)
            {
                if(empty($data['address'])){
                    $data['address']="";
                }
                if(empty($data['city'])){
                    $data['city']="";
                }
                if(empty($data['state'])){
                    $data['state']="";
                }
                if(empty($data['country'])){
                    $data['country']="";
                }
                if(empty($data['pincode'])){
                    $data['pincode']="";
                }
                User::where('id',$data['id'])->update([
                    'name' => $data['name'],
                    'address' => $data['address'],
                    'city'=> $data['city'],
                    'state'=> $data['state'],
                    'country'=> $data['country'],
                    'pincode'=> $data['pincode']
                ]);
                $userDetails = User::where('id',$data['id'])->first();
                $messages = "User Update Successfully!";
                return response()->json([
                    'userDetails'=>$userDetails,
                    'status'=>true,
                    'message'=>$messages
                ],201);
            }
            else
            {
                $messages = "User does not exists!";
                return response()->json(['status'=>false,'message'=>$messages],422);
            }
        }
    }
}
