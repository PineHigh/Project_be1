<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    public function index()
    {

        return view('admin.home', [
           'title' => 'Trang Quản Trị Admin',
        

        ]);
    }
}
