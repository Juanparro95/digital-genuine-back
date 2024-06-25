<?php

namespace App\Models;

use App\Enums\Attributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        Attributes::NAME,
        Attributes::DESCRIPTION,
        Attributes::QUANTITY,
        Attributes::CATEGORY_ID
    ];
}
