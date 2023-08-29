<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Armario;
use Carbon\Carbon;



class Emprestimo extends Model
{
    use HasFactory;

    protected $fillable = [
        'datafim',
        
        'armario_id',
        'user_id',
    ];

    protected $casts = [
        'dataprev' => 'date:d/m/Y',
        'datafinal'=> 'date:d/m/Y',
        
    ];

    public function setDataprevAttribute($value)
    {
        $this->attributes['dataprev'] = Carbon::createFromFormat('d/m/Y', $value);
    
    }
        
    public function setDatafinalAttribute($value)
    
    {
        $this->attributes['datafinal'] = Carbon::createFromFormat('d/m/Y', $value);
    
    }
    public function getDataprevAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d/m/Y') : '';
    }
    public function getDatafinalAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d/m/Y') : '';
    }

    public function armario(){
        return $this->belongsTo(Armario::class,'armario_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
