<?php

namespace App\Models\Repositories;

use App\Models\Entities\UserMatrizModel;

class UserMatrizModelRepository extends UserMatrizModel
{
    public function login(): object {
        return $this->resetConnection('matriz')
            ->table($this->table)
            ->where('email', request()->input('usuario'))
            ->first();
    }
}
