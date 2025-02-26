<?php

namespace App\Http\Controllers;

use App\Models\Entities\TabelaFilialModel;
use App\Models\Entities\TabelaMatrizModel;
use Illuminate\Http\JsonResponse;

class ListController extends Controller
{
    public function index(): JsonResponse {

        $listMatriz = TabelaMatrizModel::all();
        $listFilial = TabelaFilialModel::all();

        return response()->json([
            'message' => 'Lista de recursos',
            'data' => [
                'matriz' => $listMatriz,
                'filial' => $listFilial
            ]
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }
}
