<?php

namespace App\Models;

use App\Services\BaseCrud\Traits\HasBaseOwner;
use App\Services\BaseCrud\Traits\HasBaseTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubjectItem extends Model
{
    use HasFactory;
    use HasBaseTable;
    use HasBaseOwner;
    use SoftDeletes;

    protected $table = 'subject_items';

    protected $fillable = [
        "title",
        "descriptions",
        "star",
        "price",
        "rating",
        "facility"
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $withoutUUID = true;
}
