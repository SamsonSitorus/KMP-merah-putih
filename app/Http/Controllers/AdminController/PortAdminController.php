<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PortAdminController extends Controller
{
    public function index(){
        return view("admin.ports.index");
    }
}
