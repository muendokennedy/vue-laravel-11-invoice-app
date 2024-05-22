<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id',
        'product_id',
        'quantity',
        'unit_price'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
