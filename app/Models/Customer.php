<?php

namespace App\Models;

use App\Scopes\DelFlagScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Kyslik\ColumnSortable\Sortable;

class Customer extends Authenticatable
{
    use HasFactory, Sortable;
    protected $table = 'customers';

    protected $fillable = [
        'id',
        'email',
        'name',
        'nick_name',
        'balance',
        'fee',
        'password',
        'amount_fee',
        'admin_id',
        'account_id',
        'group_id',
        'ins_id',
        'upd_id',
        'ins_datetime',
        'upd_datetime',
        'del_flag'
    ];

    protected $with = ['admin', 'account', 'histories', 'customerReports'];

    protected $hidden = [
        'password',
    ];

    public $sortable = ['id', 'name', 'nick_name'];

    public $timestamps = false;

    protected static function booted()
    {
        static::addGlobalScope(new DelFlagScope());
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function customerReports()
    {
        return $this->hasMany(CustomerReport::class);
    }

    public function histories()
    {
        return $this->hasMany(History::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function account()
    {
        return $this->belongsTo(Admin::class, 'account_id', 'id');
    }
}
