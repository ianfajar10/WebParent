<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password'
        ],
    );

        if($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 200);
        }

        $input = $request->all();
        $name = $input['name'];
        $email = $input['email'];
        $password = bcrypt($input['password']);
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ];
        $user = User::create($data);

        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['name'] = $user->name;

        $response = [
            'success' => true,
            'data' => $success,
            'message' => "Selamat, akun baru telah dibuat"
        ];

        return response()->json($response, 200);
    }

    public function login(Request $request) {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = $request->user();
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['name'] = $user->name;
            $success['id'] = $user->id;

            $response = [
                'success' => true,
                'data' => $success,
                'message' => "User login successfully"
            ];

            return response()->json($response, 200);
        } else {
            $response = [
                'success' => false,
                'message' => "Mohon periksa kembali kombinasi email dan password!"
            ];

            return response()->json($response, 200);
        }
    }
}
