<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use Illuminate\View\View;
use App\Models\User;

class PosController extends Controller
{
    public function index(): View
    {
        $users = User::all();
        $paymentTypes = PaymentType::all();

        return view('pages.pos.index', [
            'title' => 'POS',
            'users' => $users,
            'paymentTypes' => $paymentTypes,
        ]);
    }
}
