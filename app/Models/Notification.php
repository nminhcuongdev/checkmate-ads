<?php

namespace App\Models;

use App\Scopes\DelFlagScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'id',
        'title',
        'content',
        'date',
        'type',
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

    public function customerNotifications()
    {
        return $this->hasMany(CustomerNotification::class);
    }
}
