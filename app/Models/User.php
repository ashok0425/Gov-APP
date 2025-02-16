<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * KYC status constants
     */
    public const KYC_STATUS_NOT_STARTED = 'not_started';

    public const KYC_STATUS_IN_PROGRESS = 'in_progress';

    public const KYC_STATUS_SUBMITTED = 'submitted';

    public const KYC_STATUS_UNDER_REVIEW = 'under_review';

    public const KYC_STATUS_ADDITIONAL_INFO_REQUIRED = 'additional_info_required';

    public const KYC_STATUS_APPROVED = 'approved';

    public const KYC_STATUS_REJECTED = 'rejected';

    public const KYC_STATUS_EXPIRED = 'expired';

    public const KYC_STATUS_ON_HOLD = 'on_hold';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'kyc_submitted_at' => 'datetime',
        'kyc_processed_at' => 'datetime',
    ];

    protected $appends = ['cart_count'];

    public static function getKycStatuses()
    {
        return [
            self::KYC_STATUS_NOT_STARTED,
            self::KYC_STATUS_IN_PROGRESS,
            self::KYC_STATUS_SUBMITTED,
            self::KYC_STATUS_UNDER_REVIEW,
            self::KYC_STATUS_ADDITIONAL_INFO_REQUIRED,
            self::KYC_STATUS_APPROVED,
            self::KYC_STATUS_REJECTED,
            self::KYC_STATUS_EXPIRED,
            self::KYC_STATUS_ON_HOLD,
        ];
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function discount()
    {
        return $this->hasMany(UserDiscount::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }


    public function carts()
    {
        return $this->hasMany(Cart::class);
    }


    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function requisition()
    {
        return $this->hasMany(Requisition::class);
    }

    public function getCartCountAttribute()
    {
        return $this->carts()->count();
    }

    public function defaultAddress()
    {
        return $this->addresses()->first();
    }

    /**
     * Determine if the user has completed their KYC.
     *
     * @return bool
     */
    public function hasCompletedKyc()
    {
        return $this->kyc_status === self::KYC_STATUS_APPROVED;
    }

    /**
     * Determine if the user's KYC is under review.
     *
     * @return bool
     */
    public function kycUnderReview()
    {
        return in_array($this->kyc_status, [
            self::KYC_STATUS_SUBMITTED,
            self::KYC_STATUS_UNDER_REVIEW,
        ]);
    }

    /**
     * Determine if the user's KYC requires action.
     *
     * @return bool
     */
    public function kycRequiresAction()
    {
        return in_array($this->kyc_status, [
            self::KYC_STATUS_ADDITIONAL_INFO_REQUIRED,
            self::KYC_STATUS_REJECTED,
            self::KYC_STATUS_EXPIRED,
        ]);
    }

    /**
     * Determine if the user can start or continue KYC process.
     *
     * @return bool
     */
    public function canStartOrContinueKyc()
    {
        return in_array($this->kyc_status, [
            self::KYC_STATUS_NOT_STARTED,
            self::KYC_STATUS_IN_PROGRESS,
            self::KYC_STATUS_ADDITIONAL_INFO_REQUIRED,
            self::KYC_STATUS_EXPIRED,
        ]);
    }

    public function discounts(){
        return $this->hasMany(UserDiscount::class,'user_id','id');
    }
}
