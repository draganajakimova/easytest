<?php

namespace App\Http\Controllers\Conversion\Models;

use App\Http\Controllers\Currencies\Models\Currency;
use App\Traits\UuidScopeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Conversion extends Model
{
    use HasFactory, UuidScopeTrait;

    protected $table = 'conversion_info';
    public $timestamps=true;
    public $incrementing=true;

    protected $fillable = [
        'exchange_rate',
        'source_currency_value',
        'target_currency_value',
        'source_currency_id',
        'target_currency_id'
    ];

    protected $hidden = [
        'id',
        'source_currency_id',
        'target_currency_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function sourceCurrency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'source_currency_id');
    }

    public function targetCurrency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'target_currency_id');
    }
}
