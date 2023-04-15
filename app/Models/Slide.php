<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'sub_title',
        'sub_title_text',
        'main_title',
        'main_title_text',
        'text_button',
        'link_button',
    ];
}
