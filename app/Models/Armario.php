<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Emprestimo;


class Armario extends Model
{
    use HasFactory;


    const LIVRE = 'LIVRE';
    const OCUPADO = 'OCUPADO';
    const BLOQUEADO = 'BLOQUEADO';



    protected $fillable = [
        "numero",
        "estado",

    ];

    public static function estados(){
        return [
            'Emprestado',
            'Disponível'
        ];
    }

    public function emprestimos(){
        return $this->hasMany(Emprestimo::class); 
    }

    public function emprestimoAtivo(){
        return $this->emprestimos()->where('datafim', null)->where('estado', Emprestimo::ATIVO)->first();
    }


    public static function getEstadosArmarios()
    {
        return [
            self::LIVRE => "LIVRE",
            self::OCUPADO => "OCUPADO",
            self::BLOQUEADO => "BLOQUEADO",
        ];
    }

    
}