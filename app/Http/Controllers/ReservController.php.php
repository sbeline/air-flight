<?php

namespace App\Http\Controllers;

use App\Reserv;

use DB;
use DateTime;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ReservController.php extends Controller
{
    //
    public function index()
    {
        $reserv = Reserv::all();
        var_dump($reserv);
    }

    public
}
