<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    public const UNITS = ['kg', 'liter', 'pcs', 'botol'];

    protected $fillable = [
        'category_id',
        'name',
        'price',
        'unit',
        'description',
    ];

    protected $casts = [
        'price' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /** Contoh: "Rp 15.000" */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /** Link WhatsApp untuk memesan produk */
    public function whatsappOrderUrl(): string
    {
        $message = 'Halo ' . config('shop.name') . ', saya ingin memesan ' . $this->name
            . ' (' . $this->formatted_price . ' / ' . $this->unit . '). '
            . 'Mohon dibantu ya. Terima kasih.';

        return $this->whatsappUrl($message);
    }

    /** Link WhatsApp untuk menanyakan stok */
    public function whatsappStockUrl(): string
    {
        $message = 'Halo ' . config('shop.name') . ', apakah ' . $this->name
            . ' masih tersedia? Terima kasih.';

        return $this->whatsappUrl($message);
    }

    private function whatsappUrl(string $message): string
    {
        $number = preg_replace('/\D/', '', (string) config('shop.whatsapp'));

        return 'https://wa.me/' . $number . '?text=' . rawurlencode($message);
    }
}