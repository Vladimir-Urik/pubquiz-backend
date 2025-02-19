<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use Illuminate\Http\Request;

class AvatarsController extends Controller
{

    public function all() {
        return Avatar::all();
    }

}
