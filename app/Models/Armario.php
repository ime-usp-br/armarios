<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Emprestimo;


class Armario extends Model
{
    use HasFactory;

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
        return $this->emprestimos()->where('datafim',null)->first(); 
    }
}
