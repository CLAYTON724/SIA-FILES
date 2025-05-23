<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodRequest extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'requester_id',
        'blood_type',
        'urgency',
        'location',
        'requester_name',
        'contact_phone',
        'units_needed',
        'description',
        'status',
        'expires_at',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expires_at' => 'datetime',
    ];
    
    /**
     * Get the user that created the blood request.
     */
    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }
}
