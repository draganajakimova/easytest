<?php

namespace App\Http\Controllers\Currencies\Models;

use App\Http\Controllers\Conversion\Models\Conversion;
use App\Traits\UuidScopeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Currency extends Model
{
    use HasFactory, UuidScopeTrait;

    protected $table = 'currencies';
    public $timestamps=true;
    public $incrementing=true;

    protected $fillable = [
        'code',
        'name'
    ];

    protected $hidden = [
        'id'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function sourceCurrencies(): HasMany
    {
        return $this->hasMany(Conversion::class,'category_id');
    }

    public function targetCurrencies(): HasMany
    {
        return $this->hasMany(Conversion::class,'category_id');
    }
}
