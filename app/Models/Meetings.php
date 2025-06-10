<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meetings extends Model
{
    protected $fillable = [
        'title', 'venue', 'location', 'all_day', 'start_time', 'end_time',
        'host_id', 'related_to_type', 'contact_id', 'description','scheduled_at'
    ];

    public function host()
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
