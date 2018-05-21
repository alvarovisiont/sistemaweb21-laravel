<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;
use Session;


class HomeController extends Controller
{
    //

    public function index()
    {
      session(['id_permiso' => 2]);
      Menu::print_menu();
    	return view('welcome');
    }
}
