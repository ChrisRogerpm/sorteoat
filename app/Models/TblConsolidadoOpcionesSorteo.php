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
 * Class TblConsolidadoOpcionesSorteo
 *
 * @property int $id
 * @property int $id_cliente
 * @property int $id_sorteo
 * @property string $unit_id
 * @property string $local
 * @property string $game
 * @property int $cantidad_opciones
 * @property \Carbon\Carbon $fecha_registro
 * @property int $id_tienda
 * @property int $cantidad_tickets
 *
 * @package App\Models
 */
class TblConsolidadoOpcionesSorteo extends Eloquent
{
    protected $table = 'tbl_consolidado_opciones_sorteo';
    public $timestamps = false;

    protected $casts = [
        'id_cliente' => 'int',
        'id_sorteo' => 'int',
        'cantidad_opciones' => 'int',
        'id_tienda' => 'int',
        'cantidad_tickets' => 'int',
        'stake_amount' => 'float'
    ];

    protected $dates = [
        'fecha_registro'
    ];

    protected $fillable = [
        'id_cliente',
        'id_sorteo',
        'unit_id',
        'local',
        'game',
        'cantidad_opciones',
        'fecha_registro',
        'id_tienda',
        'cantidad_tickets',
        'stake_amount',
        'zona'
    ];

    public static function ObtenerConsolidadoOpciones($clienteId, $sorteoId, $unitId, $game)
    {
        $consolidado = DB::table('tbl_consolidado_opciones_sorteo')->where([
            ['id_cliente', '=', $clienteId],
            ['id_sorteo', '=', $sorteoId],
            ['unit_id', '=', $unitId],
            ['game', '=', $game],
        ])->first();
        return $consolidado;
    }

    public static function InsertarConsolidadoOpciones($clienteId, $sorteoId, $unitId, $game, $oportunidades, $stake_amount, $zona)
    {
        DB::table('tbl_consolidado_opciones_sorteo')->insertGetId(
            [
                'id_cliente' => $clienteId,
                'id_sorteo' => $sorteoId,
                'unit_id' => $unitId,
                'local' => 'local',
                'game' => $game,
                'cantidad_opciones' => $oportunidades,
                'fecha_registro' => date('Y-m-d H:i:s'),
                'id_tienda' => 1,
                'cantidad_tickets' => 1,
                'stake_amount' => $stake_amount,
                'zona' => $zona,
            ]
        );
        return true;
    }

    public static function ActualizarConsolidadoOpciones($consolidadoId, $cantidad_opciones, $cantidad_tickets, $stake_amount)
    {
        DB::table('tbl_consolidado_opciones_sorteo')->where('id', $consolidadoId)->update(
            [
                'cantidad_opciones' => $cantidad_opciones,
                'cantidad_tickets' => $cantidad_tickets,
                'stake_amount' => $stake_amount
            ]
        );
        return true;
    }

    public static function ReporteClienteListarJson(Request $request)
    {
        $listar = [];
        $strQuery = ' SELECT *,tbl_clientes.nombre,tbl_clientes.apellidoPaterno,tbl_clientes.apellidoMaterno,tbl_clientes.dni 
        FROM tbl_consolidado_opciones_sorteo 
        left join tbl_clientes on tbl_clientes.ID=tbl_consolidado_opciones_sorteo.id_cliente';
        if ($request->arrLocales[0] == '0') {
            $strQuery = $strQuery . ' WHERE unit_id is not null';
        } else {
            $strQuery = $strQuery . ' WHERE unit_id in (' . $request->strLocales . ')';
        }
        if ($request->arrJuegos[0] != '0') {
            $strQuery = $strQuery . ' and game in (' . $request->strJuegos . ')';
        }
        if ($request->txtNombre != '') {
            $strQuery = $strQuery . ' and nombre Like "' . $request->txtNombre . '%"';
        }
        if ($request->txtApellido != '') {
            $strQuery = $strQuery . ' and (tbl_clientes.apellidoPaterno like "' . $request->txtApellido . '%" or tbl_clientes.apellidoMaterno like "' . $request->txtApellido . '%")';
        }
        if ($request->txtDni != '') {
            $strQuery = $strQuery . ' and tbl_clientes.dni = "' . $request->txtDni . '"';
        }
        $strQuery = $strQuery . ' and tbl_consolidado_opciones_sorteo.fecha_registro >= "' . $request->txtFechaInicio . '" and tbl_consolidado_opciones_sorteo.fecha_registro <= "' . $request->txtFechaFin . '"';
        $listar = DB::select($strQuery);

        $data = [];
        foreach ($listar as $l) {
            $unit_id = $l->unit_id;
            $departamento = TblUbigeo::ObtenerDepartamentoUbigeoJson($unit_id);
            $data [] = [
                'id' => $l->id,
                'id_cliente' => $l->id_cliente,
                'id_sorteo' => $l->id_sorteo,
                'unit_id' => $l->unit_id,
                'local' => $l->local,
                'game' => $l->game,
                'cantidad_opciones' => $l->cantidad_opciones,
                'fecha_registro' => $l->fecha_registro,
                'id_tienda' => $l->id_tienda,
                'cantidad_tickets' => $l->cantidad_tickets,
                'stake_amount' => $l->stake_amount,
                'zona' => $l->zona,
                'ID' => $l->ID,
                'tipo_cliente_id' => $l->tipo_cliente_id,
                'ruc' => $l->ruc,
                'dni' => $l->dni,
                'razon_social' => $l->razon_social,
                'nombre' => $l->nombre,
                'apellidoPaterno' => $l->apellidoPaterno,
                'apellidoMaterno' => $l->apellidoMaterno,
                'email' => $l->email,
                'telefono' => $l->telefono,
                'celular' => $l->celular,
                'direccion' => $l->direccion,
                'ubigeo_id' => $l->ubigeo_id,
                'banco_id' => $l->banco_id,
                'moneda_id' => $l->moneda_id,
                'numero_cuenta' => $l->numero_cuenta,
                'representante_id' => $l->representante_id,
                'infocorp' => $l->infocorp,
                'como_se_entero' => $l->como_se_entero,
                'como_se_entero_des' => $l->como_se_entero_des,
                'estado' => $l->estado,
                'verificacion' => $l->verificacion,
                'verificacionCorreo' => $l->verificacionCorreo,
                'editado' => $l->editado,
                'bloqueado' => $l->bloqueado,
                'fechaBloqueo' => $l->fechaBloqueo,
                'ticketsInvalidos' => $l->ticketsInvalidos,
                'observacion_ticket_agrupado' => $l->observacion_ticket_agrupado,
                'Departamento' => $departamento->nombre
            ];
        }

        return $data;
    }

    public static function ReporteApuestaLocalesJson(Request $request)
    {
        $listar = DB::table('tbl_consolidado_opciones_sorteo as tbl')
            ->select(
                'tbl.local',
                DB::raw("(select SUM(t.unit_id) as Apuesta from tbl_consolidado_opciones_sorteo t where t.local = tbl.local) Apuesta"),
                DB::raw("(select SUM(t.stake_amount) as Apuesta from tbl_consolidado_opciones_sorteo t where t.local = tbl.local) Canjeado"))
            ->whereIn('tbl.local', $request->arrLocales)
            ->whereBetween('tbl.fecha_registro', array($request->txtFechaInicio, $request->txtFechaFin))
            ->groupBy('tbl.local')
            ->get();
        return $listar;
    }

    public static function ReporteApuestaGameJson(Request $request)
    {
        $listar = DB::table('tbl_consolidado_opciones_sorteo as tbl')
            ->select(
                'tbl.game',
                DB::raw("(select SUM(t.unit_id) as Apuesta from tbl_consolidado_opciones_sorteo t where t.game = tbl.game) Apuesta"),
                DB::raw("(select SUM(t.stake_amount) as Apuesta from tbl_consolidado_opciones_sorteo t where t.game = tbl.game) Canjeado"))
            ->whereIn('tbl.game', $request->arrJuegos)
            ->whereBetween('tbl.fecha_registro', array($request->txtFechaInicio, $request->txtFechaFin))
            ->groupBy('tbl.game')
            ->get();
        return $listar;
    }

    public static function ReporteApuestaClienteJson(Request $request)
    {
        $listar = DB::table('tbl_consolidado_opciones_sorteo as tbl')
            ->select(
                'tbc.nombre',
                DB::raw("(select SUM(t.unit_id) as Apuesta from tbl_consolidado_opciones_sorteo t where t.id_cliente = tbl.id_cliente) Apuesta"),
                DB::raw("(select SUM(t.stake_amount) as Apuesta from tbl_consolidado_opciones_sorteo t where t.id_cliente = tbl.id_cliente) Canjeado"))
            ->join('tbl_clientes as tbc', 'tbc.ID', 'tbl.id_cliente')
            ->whereIn('tbl.id_cliente', $request->arrClientes)
            ->whereBetween('tbl.fecha_registro', array($request->txtFechaInicio, $request->txtFechaFin))
//            ->groupBy('tbl.id_cliente')
            ->get();
        return $listar;
    }

    public static function ObtenerTotalConsolidadoOpcionesSorteosJson($idCliente)
    {
        $total = DB::table('tbl_consolidado_opciones_sorteo')
            ->select('id_cliente', DB::raw('SUM(cantidad_opciones) as total'))
            ->where('id_cliente', '=', $idCliente)
            ->groupBy('id_cliente')->first();
        return $total;
    }

    public static function ObtenerGanadorProbabilidadGeneracionOpcionesSorteo($sorteoId, $zona)
    {
        $vector = array();
        //$participantes=DB::table('tbl_generacion_opciones_sorteo')->orderBy('id', 'desc')->first();
        if ($zona == 0) {
            $participantes = DB::table('tbl_consolidado_opciones_sorteo')->where([['id_sorteo', '=', $sorteoId]])
                ->orderBy('id')
                ->get();
        } else {
            $participantes = DB::table('tbl_consolidado_opciones_sorteo')->where([['id_sorteo', '=', $sorteoId], ['zona', '=', $zona]])
                ->orderBy('id')
                ->get();
        }

        $anterior = 0;
        foreach ($participantes as $participante) {
            array_push($vector, $anterior + $participante->cantidad_opciones);
            $anterior = $anterior + $participante->cantidad_opciones;
        }
        $ganador = rand(1, end($vector));

        $indice = 0;
        foreach ($vector as $elemento) {
            if ($ganador > $elemento) {
                $indice = $indice + 1;
            } else {
                break;
            }
        }
        $response = new \stdClass();
        $response->id_cliente = $participantes[$indice]->id_cliente;
        $response->numeroGanador = $ganador;
        return $response;
    }

    public static function ValidarClientesConsolidadoOpcionesSorteoJson($idSorteo, $zona)
    {
        if ($zona == 0) {
            $lista = DB::table('tbl_consolidado_opciones_sorteo')
                ->select('id_cliente')
                ->where([
                    ['id_sorteo', '=', $idSorteo]
                ])
                ->distinct()
                ->limit(55)
                ->get();
        } else {
            $lista = DB::table('tbl_consolidado_opciones_sorteo')
                ->select('id_cliente')
                ->where([
                    ['id_sorteo', '=', $idSorteo],
                    ['zona', '=', $zona]
                ])
                ->distinct()
                ->limit(55)
                ->get();
        }
        return $lista;
    }
}
