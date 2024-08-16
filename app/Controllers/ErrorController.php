<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class ErrorController extends Controller
{
    public function show404()
    {
        echo view('custom_404'); 
    }
}