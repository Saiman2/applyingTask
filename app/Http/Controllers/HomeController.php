<?php

namespace App\Http\Controllers;

use App\Models\RepairRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;

class HomeController extends Controller
{

    public function index()
    {
        $tableInfo = null;
        if (!Auth::guest()) {
            if (Auth::user()->role == 1) {
                $tableInfo = RepairRequest::orderBy('created_at', 'DESC')->paginate(15);
            } else {
                $tableInfo = RepairRequest::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(15);
            }
        }
        return view('home', compact('tableInfo'));
    }
}
