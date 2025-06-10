<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Task extends Model
{
protected $fillable = [
    'subject',
    'due_date',
    'task_owner_id',
    'status',
    'priority',
    'deal_id',
    'description',
];


    public function owner()
    {
        return $this->belongsTo(User::class, 'task_owner_id');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }


public function deal()
{
    return $this->belongsTo(Deal::class);
}

    public function taskable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
public function assignedUser()
{
    return $this->belongsTo(User::class, 'assigned_to');
}

}
