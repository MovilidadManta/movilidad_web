<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlanEstrategicoController extends Controller
{
    public function index_pagina(){
        return view("Pagina_web.Plan_estrategico.pagina_plan_estrategico");
    }
}
