<?php

namespace App\Models;

use App\Services\BaseCrud\Traits\HasBaseOwner;
use App\Services\BaseCrud\Traits\HasBaseTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Criteria extends Model
{
    use HasFactory;
    use HasBaseTable;
    use HasBaseOwner;
    use SoftDeletes;

    protected $table = 'criterias';

    const SLUG_PRICE = 'price';
    const SLUG_RATING = 'rating';
    const SLUG_STAR = 'star';
    const SLUG_FACILITY = 'facility';

    protected $fillable = [
        "title",
        "description",
        "value",
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $withoutUUID = true;
}
