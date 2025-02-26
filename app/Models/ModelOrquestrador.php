<?php

namespace App\Models;

use App\Helpers\Utils;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelOrquestrador extends Model
{
    public function __construct(array $atributes = [], string $connection = 'matriz') {
        parent::__construct($atributes);
        $this->resetConnection($connection);
    }

    protected function resetConnection(string $connection): Connection {

        if (request()->bearerToken()) {
            Utils::exeConnection($connection);

            DB::purge($connection);
            DB::disconnect($connection);
            DB::setDefaultConnection($connection);

            return DB::reconnect($connection);
        }
        return DB::connection($connection);
    }
}
