<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
   public function user() {
    return $this->belongsTo(User::class);
}

public function class() {
    return $this->belongsTo(ClassModel::class);
}

public function attendance() {
    return $this->hasMany(Attendance::class);
}

}
