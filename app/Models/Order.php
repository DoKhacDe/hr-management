<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Order extends Model
{
    use LogsActivity;
    protected $fillable = ['order_client_id', 'product_name', 'quantity', 'price', 'status', 'notes'];

    public function orderClient()
    {
        return $this->belongsTo(OrderClient::class);
    }

    public function getActivitylogOptions(): \Spatie\Activitylog\LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Order was {$eventName} by " . auth()->user()->name);
    }
}
