<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Uspdev\Replicado\DB;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'codpes',
        'nompes',
        
    ];
}
