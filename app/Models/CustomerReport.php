<?php

namespace App\Models;

use App\Scopes\DelFlagScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerReport extends Model
{
    use HasFactory;

    protected $table = 'customer_report';

    protected $fillable = [
        'customer_id',
        'date',
        'spent',
        'totalLive',
        'totalDie',
        'ins_id',
        'upd_id',
        'ins_datetime',
        'upd_datetime',
        'del_flag',

    ];

    public $timestamps = false;

    public function getStatusAttribute()
    {
        return config('const.status.'.$this->attributes['status']);
    }

    protected static function booted()
    {
        static::addGlobalScope(new DelFlagScope());
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
