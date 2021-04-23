<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    public function translations()
    {
        return $this->hasMany(Translation::class, 'entity_id')->where('entity_type', 'page');
    }
}
