<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contracts extends Model
{
    use HasFactory;
    protected $table='contracts';

    public function employees(){
        return $this->belongsTo('App\Models\Employees','employees_id');
    }
}
