<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function testCreate()
    {
        return "TEST: Product Create Page is working!";
    }
    
    public function testCreateWithView()
    {
        return view('products.create-new');
    }
}
