<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ['city', 'state', 'country', 'zip_code'];

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
