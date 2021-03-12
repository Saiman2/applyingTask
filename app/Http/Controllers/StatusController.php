<?php

namespace App\Http\Controllers;

use App\Models\Status;

class StatusController extends Controller
{
    /**
     * @return Status[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get()
    {
        return Status::all();
    }
}
