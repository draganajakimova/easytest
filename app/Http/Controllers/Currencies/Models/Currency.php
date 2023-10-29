<?php

namespace App\Http\Controllers\Currencies\Models;

use App\Traits\UuidScopeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
