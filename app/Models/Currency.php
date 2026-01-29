<?php

namespace App\Models;

use App\Scopes\DelFlagScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;


    protected $table = 'currency';

    protected $fillable = [
        'id',
        'code',
        'rate',
        'ins_id',
        'upd_id',
        'ins_datetime',
        'upd_datetime',
        'del_flag'
    ];

    public $timestamps = false;

    protected static function booted()
    {
        static::addGlobalScope(new DelFlagScope());
    }
}
