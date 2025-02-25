<?php

namespace App\Controllers;

use App\Controllers\Controller;

class ProductController extends Controller
{
    public function addProduct()
    {
        $this->render("/add");
    }
}
