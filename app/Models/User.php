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
        'dataDefesa',
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
        return $this->hasMany(Emprestimo::class, 'user_id'); // Substitua 'user_id' pelo nome da chave estrangeira correta
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
                    array_push($vinculos, 'Aluno de pós');
                }elseif(str_contains($r['tipvin'], 'SERVIDOR')){
                    if($r['tipfnc'] == 'Docente'){
                        array_push($vinculos, 'Docente');
                    }
                }
            }
        }

        return $vinculos;
    }


    public static function testDataDefesa($codpes)
    {  
    $query = " SELECT dtadfapgm";
    $query .= " FROM AGPROGRAMA AS AP";
    $query .= " WHERE AP.codpes = :codpes";
    $query .= " AND AP.vinalupgm = :vinalupgm";
    $param = [
        'codpes' => $codpes,
        'vinalupgm' => 'REGULAR'
    ];

    $res = array_unique(DB::fetchAll($query, $param), SORT_REGULAR);

    if ($res && !empty($res[0]['dtadfapgm'])) {
        return Carbon::createFromFormat('Y-m-d H:i:s', $res[0]['dtadfapgm']);
    } else {
        return null;
    }
    
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

    public function setDataDefesaAttribute($value)
    {
        $user = auth()->user(); // Obtém o usuário logado
    
        if ($user) {
            $codpes = $user->codpes; // Obtém o código do usuário logado
    
            // Chame o método testDataDefesa para obter a data de defesa.
            $dataDefesa = self::testDataDefesa($codpes);
    
            // Atribua a data de defesa à coluna dataDefesa se existir.
            if ($dataDefesa) {
                $this->attributes['dataDefesa'] = $dataDefesa;
            }
        }
    }

    public static function booted(){

        static::created(function ($user){
            $codpes = $user->codpes;
            if (str_contains(env('LOG_AS_ADMINISTRATOR'), $codpes)){
                $user->assignRole("Administrador");
            }
            foreach($user->getVinculosFromReplicadoByCodpes($codpes) as $vinculo){
                if ($vinculo == 'Docente'){
                    $user->assignRole("Docente");
                }
                if ($vinculo == 'Aluno de pós'){
                    $user->assignRole("Aluno de pós");
                }
            }
        });
    }


}