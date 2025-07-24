<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    public function sticker() {
    return $this->belongsTo(Sticker::class);
}

public function calendrier() {
    return $this->belongsTo(Calendrier::class);
}

public function user() {
    return $this->belongsTo(User::class);
}

}
