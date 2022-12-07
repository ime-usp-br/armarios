<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Armario;



class Emprestimo extends Model
{
    use HasFactory;

    protected $fillable = [
        'datafim',
        'armario_id',
        'user_id',
    ];
    public function armario(){
        return $this->belongsTo(Armario::class,'armario_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
