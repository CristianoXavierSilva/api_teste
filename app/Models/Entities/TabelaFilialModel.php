<?php

namespace App\Models\Entities;

use App\Models\ModelOrquestrador;
use Illuminate\Database\Eloquent\SoftDeletes;

class TabelaFilialModel extends ModelOrquestrador
{
    use SoftDeletes;

    protected $table = 'tabela';
    protected $primaryKey = 'tabela_id';

    protected $fillable = [
        'titulo',
        'subtitulo',
        'texto',
        'cadastro',
        'alteracao',
        'exclusao',
    ];

    const CREATED_AT = 'cadastro';
    const UPDATED_AT = 'alteracao';
    const DELETED_AT = 'exclusao';

    public function __construct(array $atributes = []) {
        parent::__construct($atributes, 'filial');
    }
}
