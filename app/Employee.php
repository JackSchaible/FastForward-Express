<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $timestamps = false;
    public $primaryKey = "employee_id";

    protected $fillable = ['employee_id', 'contact_id', 'user_id', 'employee_number', 'start_date', 'sin', 'dob', 'active'];

    public function contact() {
        return $this->belongsTo('App\Contact');
    }

    public function contacts() {
        return $this->belongsToMany('App\Contact', 'employee_emergency_contacts');
    }
}
