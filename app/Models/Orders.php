<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Orders extends Model
{
    use HasFactory;

    public const WAITING   = 0;
    public const FINISH    = 1;


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'client_id',
        'delivery_at',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
    ];

    /**
     * Register a creating model event to automatically generate a UUID.
     *
     * @return void
     */
    public static function boot(): void
    {
        parent::boot();

        static::creating(
            function ($model) {
                $model->uuid = Str::uuid();
            }
        );
    }

    /**
     * The attributes that should be cast to native types.
     *
     *@return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItems::class, 'order_id', 'id');
    }
}
