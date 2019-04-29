<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 23 Jan 2019 16:45:37 -0500.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
/**
 * Class TblTipoBeneficio
 * 
 * @property int $id
 * @property string $descripcion
 *
 * @package App\Models
 */
class TblTipoBeneficio extends Eloquent
{
	protected $table = 'tbl_tipo_beneficio';
	public $timestamps = false;

	protected $fillable = [
		'descripcion'
	];	
}
