<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emprestimo extends Model
{
    use HasFactory;

    protected $fillable = [
        'datain',
        'datafim',
        'armario',
        'user',
    ];
    public function armario(){
        return $this->hasOne(Armario::class);
    }

    public function user(){
        return $this->hasOne(User::class);
    }
}
