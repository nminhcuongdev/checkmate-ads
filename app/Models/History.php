<?php

namespace App\Models;

use App\Scopes\DelFlagScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class History extends Model
{
    use HasFactory, Sortable;

    protected $table = 'histories';

    protected $fillable = [
        'id',
        'customer_id',
        'date',
        'amount',
        'fee',
        'hashcode',
        'last_balance',
        'ins_id',
        'upd_id',
        'ins_datetime',
        'upd_datetime',
        'del_flag'
    ];

    protected $has = ['customer'];

    public $timestamps = false;

    public $sortable = ['id', 'date', 'amount'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
