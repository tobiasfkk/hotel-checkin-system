<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{

    use HasFactory;

    protected $table = 'pessoas';

    protected $fillable = [
        'nome',
        'cpf',
        'telefone',
    ];
    
    public $timestamps = false;

    /**
     * Realiza o tratamento para inserir no banco o CPF formatado (999.999.999-99).
     * @param string $value
     * @return void
     */
    public function setCpfAttribute($value)
    {
        $cpf          = preg_replace('/\D/', '', $value);
        $cpfFormatado = preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "$1.$2.$3-$4", $cpf);
        $this->attributes['cpf'] = $cpfFormatado;
    }

}
