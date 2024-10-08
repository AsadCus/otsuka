<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Province extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reg_provinces';
    protected $guarded = ['id'];

    public function regencies()
    {
        return $this->hasMany(Regency::class);
    }
}
