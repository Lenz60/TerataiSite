<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatalogController extends Controller
{
    //

    public function index(Request $request){
        $furniture = DB::table('furniture')
        ->get();

        return Inertia::render('Catalog', ['furnitures' => $furniture]);
    }

    public function cart(Request $request){
        // dd($request->all());
    }


}
