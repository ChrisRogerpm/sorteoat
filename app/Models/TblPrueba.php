<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 23 Jan 2019 16:45:37 -0500.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TblPrueba
 * 
 * @property int $id
 * @property string $nombre_sub
 * @property \Carbon\Carbon $fecha
 *
 * @package App\Models
 */
class TblPrueba extends Eloquent
{
	protected $table = 'tbl_prueba';
	public $timestamps = false;

	protected $dates = [
		'fecha'
	];

	protected $fillable = [
		'nombre_sub',
		'fecha'
	];
}
