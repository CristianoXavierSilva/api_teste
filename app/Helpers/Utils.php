<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Config;

class Utils
{
    public static function exeConnection(string $connection): void {

        $payload = JWT::decode(request()->bearerToken(), new Key(env('JWT_SECRET'), 'HS256'));
        $database = Config::get("constants.{$payload->uf}.$connection");

        Config::set("database.connections.$connection.database", $database);
    }
}
