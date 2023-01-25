<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneBook extends Model
{
    use HasFactory;

    protected $table = 'phone_book';

    protected $fillable = [
        'user_id',
        'phone',
        'country_number',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
