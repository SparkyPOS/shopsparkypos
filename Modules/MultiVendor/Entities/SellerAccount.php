<?php

namespace Modules\MultiVendor\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class SellerAccount extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function commission_type()
    {
        return $this->belongsTo(SellerCommssionType::class, 'seller_commission_id')->withDefault();
    }

    protected static function booted()
    {
        static::saved(function ($seller) {
            if ($seller->user) {
                $seller->user->updateSlug(); // Call category method to regenerate slug
            }
        });

        static::deleted(function ($seller) {
            if ($seller->user) {
                $seller->user->updateSlug();
            }
        });
    }

}
