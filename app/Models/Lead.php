<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\LeadTimeline;
use App\Models\User;
use App\Models\Deal;
use App\Models\Task;

class Lead extends Model {
    use HasFactory;

protected $fillable = [
   'lead_id', 'name', 'email', 'phone', 'company', 'status', 'notes','source', 'lead_owner','title', 'first_name', 'second_name', 'annual_revenue', 'website',
    'employees', 'rating', 'secondary_email', 'street', 'city',
    'state', 'country', 'zip_code', 'lead_image',
    'company', 'email', 'phone', 'source', 'lead_owner',
    'status', 'notes', 'account_id',
];

    public function assignedUser() {
        return $this->belongsTo(User::class, 'assigned_to');
    }

public function timeline()
{
    return $this->hasMany(LeadTimeline::class)->orderBy('created_at', 'desc');
}

public function deals()
{
    return $this->hasMany(Deal::class);
}

public function user()
{
    return $this->belongsTo(User::class, 'assigned_to');
}

public function tasks()
{
    return $this->morphMany(Task::class, 'taskable');
}

public function owner()
{
    return $this->belongsTo(User::class, 'lead_owner');
}


}

