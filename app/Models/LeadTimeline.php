<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadTimeline extends Model
{
    use HasFactory;

    protected $fillable = ['lead_id', 'description'];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}

