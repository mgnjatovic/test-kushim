<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model {
    protected $fillable = ['avatar', 'first_name', 'last_name', 'address', 'city', 'zip', 'country', 'email', 'phone', 'note'];

    public function groups() {
        return $this->belongsToMany('App\Group');
    }
}
