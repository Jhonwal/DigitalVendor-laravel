<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'status',
        'payment_method',
        'payment_id',
        'customer_email',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order items for the order.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Format the total amount as a dollar amount.
     */
    public function formattedTotal()
    {
        return '$' . number_format($this->total_amount, 2);
    }

    /**
     * Get the order status badge HTML.
     */
    public function getStatusBadgeAttribute()
    {
        $class = 'bg-gray-500'; // Default

        switch ($this->status) {
            case 'pending':
                $class = 'bg-yellow-500';
                break;
            case 'paid':
                $class = 'bg-green-500';
                break;
            case 'cancelled':
                $class = 'bg-red-500';
                break;
            case 'refunded':
                $class = 'bg-purple-500';
                break;
        }

        return '<span class="px-2 py-1 text-xs font-bold text-white rounded-full ' . $class . '">' . 
               ucfirst($this->status) . 
               '</span>';
    }
}