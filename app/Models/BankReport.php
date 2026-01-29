<?php

namespace App\Models;

use App\Scopes\DelFlagScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankReport extends Model
{
    use HasFactory;

    protected $table = 'bank_reports';

    protected $fillable = [
        'id',
        'bank_id',
        'date',
        'balance',
        'receive',
        'transfer',
        'refund',
        'pay',
        'pay_usd',
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

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
