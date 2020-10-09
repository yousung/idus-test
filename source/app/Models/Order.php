<?php

namespace App\Models;

use App\Casts\DateTimeString;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $casts = [
        'settlement_at' => DateTimeString::class,
        'created_at' => DateTimeString::class,
        'updated_at' => DateTimeString::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
