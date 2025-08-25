<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Booking
 *
 * @property int $id
 * @property string $booking_code
 * @property string $full_name
 * @property string $email
 * @property string $phone
 * @property string $booking_type
 * @property int|null $boat_ticket_id
 * @property int|null $tour_package_id
 * @property \Illuminate\Support\Carbon $departure_date
 * @property int $passenger_count
 * @property float $total_price
 * @property string $payment_method
 * @property string $payment_status
 * @property string|null $qr_code
 * @property \Illuminate\Support\Carbon|null $paid_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\BoatTicket|null $boatTicket
 * @property-read \App\Models\TourPackage|null $tourPackage
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Booking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking query()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereBoatTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereBookingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereBookingType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereDepartureDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking wherePassengerCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereQrCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereTourPackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking paid()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking pending()
 * @method static \Database\Factories\BookingFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'booking_code',
        'full_name',
        'email',
        'phone',
        'booking_type',
        'boat_ticket_id',
        'tour_package_id',
        'departure_date',
        'passenger_count',
        'total_price',
        'payment_method',
        'payment_status',
        'qr_code',
        'paid_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'departure_date' => 'date',
        'passenger_count' => 'integer',
        'total_price' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    /**
     * Get the boat ticket that owns the booking.
     */
    public function boatTicket(): BelongsTo
    {
        return $this->belongsTo(BoatTicket::class);
    }

    /**
     * Get the tour package that owns the booking.
     */
    public function tourPackage(): BelongsTo
    {
        return $this->belongsTo(TourPackage::class);
    }

    /**
     * Scope a query to only include paid bookings.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    /**
     * Scope a query to only include pending bookings.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    /**
     * Generate a unique booking code.
     */
    public static function generateBookingCode(): string
    {
        do {
            $code = 'FB' . date('ymd') . strtoupper(bin2hex(random_bytes(2)));
        } while (self::where('booking_code', $code)->exists());

        return $code;
    }
}