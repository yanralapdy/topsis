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
        "description",
        "star",
        "subject_id",
        "price",
        "rating",
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $withoutUUID = true;

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}
