<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblLogReniec extends Model
{
    protected $table = 'tbl_log_reniec';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    protected $fillable = [
        'dni',
        'estadoConsulta',
        'fechaRegistro'
    ];

    public static function RegistrarLogReniec($dni, $estadoConsulta)
    {
        $log = new TblLogReniec();
        $log->dni = $dni;
        $log->estadoConsulta = $estadoConsulta;
        $log->fechaRegistro = now();
        $log->save();
    }
}
