<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairRequest extends Model
{
    protected $table = 'repair_request';

    protected $fillable = [
        'user_id',
        'status_id',
        'brand',
        'model',
        'year',
        'comment',
        'probable_problem',
        'client_problem_info',
        'time_to_complete',
        'employees_required_info',
        'employees_comment',
        'user_comment',
        'changed_parts',
        'parts_price',
        'labor_price',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Status');
    }
}
