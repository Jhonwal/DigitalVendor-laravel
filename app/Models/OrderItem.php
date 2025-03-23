<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'price',
        'quantity',
        'download_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
    ];

    /**
     * Get the order that owns the order item.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product that owns the order item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Calculate the subtotal for this order item.
     */
    public function getSubtotalAttribute()
    {
        return $this->price * $this->quantity;
    }

    /**
     * Format the subtotal as a dollar amount.
     */
    public function formattedSubtotal()
    {
        return '$' . number_format($this->subtotal, 2);
    }

    /**
     * Format the price as a dollar amount.
     */
    public function formattedPrice()
    {
        return '$' . number_format($this->price, 2);
    }

    /**
     * Get the download URL for this order item.
     */
    public function getDownloadUrlAttribute()
    {
        return route('orders.download', [
            'orderNumber' => $this->order->order_number,
            'downloadToken' => $this->download_token,
        ]);
    }
}