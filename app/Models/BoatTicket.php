<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\BoatTicket
 *
 * @property int $id
 * @property string $name
 * @property string $origin
 * @property string $destination
 * @property string|null $description
 * @property float $price
 * @property int $duration_hours
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Booking> $bookings
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|BoatTicket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BoatTicket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BoatTicket query()
 * @method static \Illuminate\Database\Eloquent\Builder|BoatTicket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoatTicket whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoatTicket whereDestination($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoatTicket whereDurationHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoatTicket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoatTicket whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoatTicket whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoatTicket whereOrigin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoatTicket wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoatTicket whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoatTicket active()
 * @method static \Database\Factories\BoatTicketFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class BoatTicket extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'origin',
        'destination',
        'description',
        'price',
        'duration_hours',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'duration_hours' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get the bookings for this boat ticket.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Scope a query to only include active tickets.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}