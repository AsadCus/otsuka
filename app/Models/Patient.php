<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'patients';
    protected $guarded = ['id'];
    protected $appends = ['province_name', 'regency_name'];

    public function getProvinceNameAttribute()
    {
        return $this->province ? $this->province->name : 'No Province';
    }

    public function getRegencyNameAttribute()
    {
        return $this->regency ? $this->regency->name : 'No Regency';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }
}
