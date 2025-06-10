<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Contact extends Model
{
    use HasFactory;

  protected $fillable = [
    'first_name',
    'last_name',
    'email',
    'phone',
    'company',
    'position',
    'address',
];


public function owner()
{
    return $this->belongsTo(User::class, 'contact_owner_id');
}

    public function assignedUser() {
        return $this->belongsTo(User::class, 'assigned_to');
    }
public function tasks()
{
    return $this->morphMany(Task::class, 'taskable');
}

}
