<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

   protected $fillable = [
    'owner_id', 'account_name', 'account_site', 'account_number', 'account_type',
    'annual_revenue', 'phone', 'fax', 'website', 'ownership', 'employees',
    'billing_street', 'billing_city', 'billing_state', 'billing_code', 'billing_country',
    'shipping_street', 'shipping_city', 'shipping_state', 'shipping_code', 'shipping_country',
    'description'
];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
