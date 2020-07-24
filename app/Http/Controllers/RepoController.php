<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RepoController extends Controller
{
    public function create(Request $request)
    {
        $id = $request->id;
        return view('home.clone', compact('id'));
    }
}