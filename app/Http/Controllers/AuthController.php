<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken($user->name.'_register_token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        //valida usuario e checa o password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'Credenciais invalidas'
            ], 401);
        }

        $token = $user->createToken($user->name.'_login_token')->plainTextToken;

        $response = [
            'token' => $token
        ];

        return response($response, 201);
    }

    public function list_users() {
        $users = User::paginate(5);

        return response()->json([
            'users' => $users
        ]);
    }

    public function get_user() {
        $user = auth()->user();

        return response()->json([
            'user' => $user,
        ]);
    }

    public function update_data(Request $request)
    {
        try {
            DB::beginTransaction();;
            $user = auth()->user();

            $newUser = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ];

            $user->update($newUser);
            DB::commit();

            return [
                'message' => 'Dados do usuário atualizados com sucesso'
            ];
        } catch (\Throwable $th) {
            DB::rollback();
            return $th->getMessage();
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logout efetuado com sucesso e exclusão dos tokens.'
        ];
    }

    public function remove_account()
    {
        $user = auth()->user();
        auth()->user()->tokens()->delete();
        $user->delete();

        return [
            'message' => 'Sua conta foi removida com sucesso'
        ];
    }
}
