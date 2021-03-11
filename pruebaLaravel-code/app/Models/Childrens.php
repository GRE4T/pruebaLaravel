<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Childrens extends Model
{
    use HasFactory;

    protected $table='childrens';

    public function employees(){
        return $this->belongsTo('App\Models\Employees','employees_id');
    }
}
