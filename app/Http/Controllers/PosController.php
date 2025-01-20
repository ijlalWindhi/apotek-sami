<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\User;

class PosController extends Controller
{
    public function index(): View
    {
        $users = User::all();

        return view('pages.pos.index', [
            'title' => 'POS',
            'users' => $users
        ]);
    }
}
