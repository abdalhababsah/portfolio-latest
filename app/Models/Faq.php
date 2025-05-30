<?php
// app/Models/Faq.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'question_en', 'question_ar',
        'answer_en', 'answer_ar',
        'display_order',
    ];
}