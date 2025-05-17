<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class OrderClient extends Model
{
    use LogsActivity;
    protected $fillable = ['client_id', 'total_price', 'total_order'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function getActivitylogOptions(): \Spatie\Activitylog\LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Rank was {$eventName} by " . auth()->user()->name);
    }
}
