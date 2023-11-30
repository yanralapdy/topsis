<?php

namespace App\Models;

use App\Services\BaseCrud\Traits\HasBaseOwner;
use App\Services\BaseCrud\Traits\HasBaseTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Result extends Model
{
    use HasFactory;
    use HasBaseTable;
    use HasBaseOwner;
    use SoftDeletes;

    protected $table = 'results';

    protected $fillable = [
        "title",
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $withoutUUID = true;


    public function resultCriterias()
    {
        return $this->hasMany(ResultCriteria::class, 'result_id', 'id');
    }

    public function resultSubjectItems()
    {
        return $this->hasMany(ResultSubjectItem::class, 'result_id', 'id');
    }

    public function resultSubjectItemNormalizedMatriks()
    {
        return $this->hasMany(ResultSubjectItemNormalizedMatrik::class, 'result_id', 'id');
    }

    public function resultSubjectItemWeightedNormalizedMatriks()
    {
        return $this->hasMany(ResultSubjectItemWeightedNormalizedMatrik::class, 'result_id', 'id');
    }
}
