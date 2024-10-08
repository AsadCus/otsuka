<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Village extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reg_villages';
    protected $guarded = ['id'];

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
