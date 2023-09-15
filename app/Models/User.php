<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Emprestimo;
use Uspdev\Replicado\DB;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use \Spatie\Permission\Traits\HasRoles;
    use \Uspdev\SenhaunicaSocialite\Traits\HasSenhaunica;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function emprestimos(){
        return $this->hasToMany(Emprestimo::class); 
    }

    public static function test($codpes)
    {

        $query = " SELECT *";
        $query .= " FROM VINCULOPESSOAUSP AS VP";
        $query .= " WHERE VP.codpes = :codpes";
        $query .= " AND VP.tipfnc = :tipfnc";
        $query .= " AND VP.codund = :codund";
        $param = [
            'codpes' => $codpes,
            'tipfnc' => "Docente",
            'codund' => "45",
        ];

        return array_unique(DB::fetchAll($query, $param),SORT_REGULAR);

    }

    public static function getVinculosFromReplicadoByCodpes($codpes)
    {
        $query = " SELECT VP.tipvin, VP.dtafimvin, VP.tipfnc";
        $query .= " FROM VINCULOPESSOAUSP AS VP";
        $query .= " WHERE VP.codpes = :codpes";
        $param = [
            'codpes' => $codpes,
            
        ];

        $res = array_unique(DB::fetchAll($query, $param),SORT_REGULAR);
        
        $vinculos = [];
        foreach($res as $r){
            if(!$r['dtafimvin']){
                if( str_contains($r['tipvin'], 'ALUNOPOS') || str_contains($r['tipvin'], 'ALUNOPOSESP')){
                    array_push($vinculos, 'Aluno');
                }elseif(str_contains($r['tipvin'], 'SERVIDOR')){
                    if($r['tipfnc'] == 'Docente'){
                        array_push($vinculos, 'Docente');
                    }
                }
            }
        }

        return $vinculos;
    }


    public static function testDataDepositoTese($codpes)
    {

        $query = " SELECT dtadpopgm";
        $query .= " FROM AGPROGRAMA AS AP";
        $query .= " WHERE AP.codpes = :codpes";
        $query .= " AND AP.vinalupgm = :vinalupgm";
        $param = [
            'codpes' => $codpes,
            'vinalupgm' => 'REGULAR'
        ];


        $res = array_unique(DB::fetchAll($query, $param),SORT_REGULAR);
        return $res ? Carbon::createFromFormat('Y-m-d H:i:s',$res[0]['dtadpopgm'])->format('d/m/Y'):null;
    }



    public function isAluno()
    {
    $vinculos = self::getVinculosFromReplicadoByCodpes($this->codpes);
    if (in_array('Aluno', $vinculos)) {
        $role = Role::findByName('Aluno de pós'); 
        $this->assignRole($role);
        return true;
    }
    return false;
    }



}