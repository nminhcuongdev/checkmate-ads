<?php

namespace App\Models;

use App\Scopes\DelFlagScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerNotification extends Model
{
    use HasFactory;

    protected $table = 'customers_notifications';

    protected $fillable = [
        'id',
        'customer_id',
        'notification_id',
    ];

    public $timestamps = false;

    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }
}
