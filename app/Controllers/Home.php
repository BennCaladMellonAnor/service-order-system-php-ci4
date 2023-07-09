<?php

namespace App\Controllers;

use CodeIgniter\Router\RouteCollection;

class Home extends BaseController
{


    public function index(){
        $data = [
            'title' => 'Home',
        ];
        return view('home/index', $data);
    }
    public function mark(){
        return view('mark');
    }

    public function note(){
        return view('note');
    }

    public function layout(){

        $data = [
            'title' => 'Home'
        ];

        return view('Home/index', $data);
    }
}
