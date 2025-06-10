<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
protected $fillable = [
    'deal_owner', 'deal_name', 'account_name',
    'amount', 'lead_source', 'contact_name',
    'description', 'closing_date'
];

public function owner()
{
    return $this->belongsTo(User::class, 'deal_owner');
}

public function tasks()
{
    return $this->morphMany(Task::class, 'taskable');
}

}
