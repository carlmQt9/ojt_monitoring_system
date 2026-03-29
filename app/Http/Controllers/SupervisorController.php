<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class YourController extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ...existing methods...
}