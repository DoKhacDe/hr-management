<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Client extends Model
{
    use LogsActivity;

    protected $fillable = ['name', 'email', 'phone', 'address', 'notes'];

    public function documents()
    {
        return $this->hasOne(Document::class);
    }
    public function orderClient()
    {
        return $this->hasOne(OrderClient::class);
    }
    public function getActivitylogOptions(): \Spatie\Activitylog\LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->logOnly(['name', 'email', 'phone', 'address'])
            ->setDescriptionForEvent(fn(string $eventName) => "Client was {$eventName} by " . auth()->user()->name);
    }
}
