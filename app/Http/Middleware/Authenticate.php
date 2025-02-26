<?php

namespace App\Http\Middleware;

use App\Models\Entities\UserMatrizModel;
use Closure;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Authenticate
{
    public function handle(Request $request, Closure $next): mixed {
        try {
            $payload = JWT::decode($request->bearerToken(), new Key(env('JWT_SECRET'), 'HS256'));

            if (strtotime('NOW') > strtotime(date('Y-m-d H:i:s', strtotime($payload->login . ' +1 hours')))) {
                return response()->json([
                    'message' => 'Acesso negado!Token expirado!',
                    'data' => null
                ], 403, [], JSON_UNESCAPED_UNICODE);
            }
            $user = UserMatrizModel::findOrFail($payload->id);

            if (!$user) {
                return response()->json([
                    'message' => "Nenhum usuário encontrado!",
                    'data' => null
                ], 404, [], JSON_UNESCAPED_UNICODE);
            }

            return $next($request);

        } catch (Exception $ex) {
            Log::error('Erro ao tentar decodificar token!', [
                'code' => $ex->getCode(),
                'message' => $ex->getMessage(),
                'file' => $ex->getFile(),
                'line' => $ex->getLine()
            ]);

            return response()->json([
                'message' => 'Acesso negado!Token inválido',
                'data' => null
            ], 403, [], JSON_UNESCAPED_UNICODE);
        }
    }
}
