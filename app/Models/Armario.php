<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
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

    //** Esse método retorna o empréstimo ativo para o armário em questão */
    public function emprestimoAtivo(){
        
        return $this->belongsTo(Emprestimo::class)->where(function (Builder $query) {
            $query->where('estado', Emprestimo::ATIVO);
        });



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