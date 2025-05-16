<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Document extends Model
{
    use LogsActivity;
    protected $fillable = ['name', 'type', 'client_id', 'file'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function getActivitylogOptions(): \Spatie\Activitylog\LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->logOnly(['name', 'type'])
            ->setDescriptionForEvent(fn(string $eventName) => "Document was {$eventName} by " . auth()->user()->name);
    }
}
