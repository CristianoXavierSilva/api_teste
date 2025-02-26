<?php

namespace App\Http\Controllers;

use App\Models\Entities\UserMatrizModel;
use App\Models\Repositories\UserMatrizModelRepository;
use Firebase\JWT\JWT;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private UserMatrizModelRepository $user;

    public function __construct(UserMatrizModelRepository $user) {
        $this->user = $user;
    }

    public function login(Request $request): JsonResponse {

        $validation = Validator::make($request->all(), [
            'uf' => 'required|string',
            'usuario' => 'required|string|email',
            'senha' => 'required|string'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'messsage' => 'Erro de validação',
                'data' => $validation->errors()
            ], 422, [], JSON_UNESCAPED_UNICODE);
        }
        $user = $this->user->login();

        if (!$user) {
            return response()->json([
                'message' => "Nenhum usuário encontrado!",
                'data' => null
            ], 404, [], JSON_UNESCAPED_UNICODE);
        }

        if (password_verify($request->input('senha'), $user->password)) {
            return response()->json([
                'message' => "Usuário autenticado com sucesso!",
                'data' => [
                    'token' => JWT::encode([
                        'uf' => $request->input('uf'),
                        'id' => $user->id,
                        'user' => $user->name,
                        'login' => date('Y-m-d H:i:s', strtotime('NOW'))
                    ], env('JWT_SECRET'), 'HS256'),
                    'expireIn' => date('Y-m-d H:i:s', strtotime('+1 hours'))
                ]
            ], 201, [], JSON_UNESCAPED_UNICODE);
        }

        return response()->json([
            'message' => "Erro de autenticação! Usuário e/ou senha incorretos!",
            'data' => null
        ], 401, [], JSON_UNESCAPED_UNICODE);
    }
}
