<?php

namespace App\Models;

use App\Services\BaseCrud\Traits\HasBaseOwner;
use App\Services\BaseCrud\Traits\HasBaseTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResultCriteria extends Model
{
    use HasFactory;
    use HasBaseTable;
    use HasBaseOwner;
    use SoftDeletes;

    protected $table = 'result_criterias';

    protected $fillable = [
        "title",
        "description",
        "value",
        'ideal_best_value',
        'ideal_worst_value',
        'slug',
        'result_id'
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $withoutUUID = true;
}
