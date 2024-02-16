<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsPagesModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'url',
        'footer_type',
        'status',
    ];

    public $table = "cms_pages";
}
