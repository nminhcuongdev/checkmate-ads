<?php

namespace App\Models;

use App\Scopes\DelFlagScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountReport extends Model
{
    use HasFactory;

    protected $table = 'account_report';

    protected $fillable = [
        'account_id',
        'date',
        'spent',
        'ins_id',
        'upd_id',
        'ins_datetime',
        'upd_datetime',
        'del_flag'

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

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
