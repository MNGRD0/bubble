<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calendrier extends Model
{
    public function user() {
    return $this->belongsTo(User::class);
}

}
