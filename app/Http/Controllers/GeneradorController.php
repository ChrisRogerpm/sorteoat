<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TblGeneracionOpcionesSorteo;

class GeneradorController extends Controller
{
    protected $RNG_INT = array();
    protected $qwe = 3;
    public function ObtenerAleatorio()
    {        
        // $this->XGSeed(636838438083932491);
        // $tmp=$this->XGRandom(100);
        $tmp=rand(0, 150000);
        //$tmp=TblGeneracionOpcionesSorteo::ObtenerTotalGanadorOpcionesSorteosJson();        
        return response()->json($tmp);  
    }         
    private function XGSeed($seed)
    {
        //$RNG_INT = array();
        if ($seed <= 0)
        {
            //$seed = time(0);
        }
        $this->RandomInit((int)$seed);
    }
    private function XGRandom($limit)
    {
        return $this->IRandom(0,$limit);
    }
    private function RandomInit($seed)
    {        
        $i=0;
        $s = $seed;
        for($i=0; $i<5; $i++) {
        	$s = $s * 29943829 - 1;
            $this->RNG_INT[$i] = $s;
        }                   
        for ($i=0; $i<19; $i++)
        {
            $this->BRandom();
        }
    }
    private function BRandom()
    {
        $sum=0;
        $sum = 2111111111 * $this->RNG_INT[3] +1492 * ($this->RNG_INT[2]) +1776 * ($this->RNG_INT[1]) +5115 * ($this->RNG_INT[0]) +$this->RNG_INT[4];
        $this->RNG_INT[3] = $this->RNG_INT[2];  
        $this->RNG_INT[2] = $this->RNG_INT[1];  
        $this->RNG_INT[1] = $this->RNG_INT[0];
        $this->RNG_INT[4] = ($sum >> 32);                  // Carry
        $this->RNG_INT[0] = $sum;                          // Low 32 bits of sum
        return $this->RNG_INT[0];
    }
    private function IRandom($min,$max)
    {        
        if ($max <= $min) 
        {
            if ($max == $min)
            {
                return $min;
            }
            else
            {
                return 0;
            }
        }
        // Assume 64 bit integers supported. Use multiply and shift method
        $interval;                  // Length of interval
        $longran;                   // Random bits * interval
        $iran;                      // Longran / 2^32
    
        $interval = ($max - $min + 1);
        $longran  = $this->BRandom() * $interval;
        $iran = ($longran >> 32);
        // Convert back to signed and return result
        return (int)$iran + $min;
    }
}
