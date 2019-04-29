<?php

use Faker\Generator as Faker;

$factory->define(App\Models\TblCliente::class, function (Faker $faker) {    
    return [
        'nombre' => $faker->firstName,
        'apellidoPaterno'=>$faker->lastName,
        'apellidoMaterno'=>$faker->lastName,
        'dni'=>rand(80000,99999),
        'ticketsInvalidos'=>1       
    ];
});
// $factory->define(App\Models\TblConsolidadoOpcionesSorteo::class, function (Faker $faker) {
//     $stacke_amout=(rand(50,1000))/10;
//     $fecha=$faker->dateTimeThisMonth;
//     return [
//         'id_cliente' => rand(1, 100),
//         'id_sorteo'=>'1',
//         'unit_id'=>rand(80000,99999),
//         'local'=>'local',
//         'game'=>$faker->firstName,
//         'cantidad_opciones'=>rand(2,50),
//         'fecha_registro'=>$fecha,
//         'id_tienda'=>rand(1,20),
//         'cantidad_tickets'=>rand(1,10),
//         'stake_amount'=>$stacke_amout,  
//         'zona'=>rand(1,4)
//     ];
// });
// $factory->define(App\Models\TblGeneracionOpcionesSorteo::class, function (Faker $faker) {
//     $stacke_amout=(rand(50,1000))/10;
//     $fecha=$faker->dateTimeThisMonth;
//     return [
//         'id_cliente' => rand(1, 100),
//         'id_sorteo'=>'1',
//         'ticket_id'=>rand(100000000,700000000),
//         'unit_id'=>rand(80000,99999),
//         'local'=>'local',
//         'time_played'=> $fecha,
//         'event_id'=>rand(19581,99581),
//         'game'=>$faker->firstName,
//         'stake_amount'=>$stacke_amout,
//         'currency'=>'PEN',
//         'ticket_status'=>'Lost',
//         'winning_amount'=>0.00,
//         'jackpot'=>0.00,
//         'result'=>'result',
//         'cantidad_opciones'=>(int)($stacke_amout/5),
//         'fecha_registro'=>$fecha,
//         'id_tienda'=>rand(1,20),
//         'paid_out_time'=>$fecha,
//     ];
// });
