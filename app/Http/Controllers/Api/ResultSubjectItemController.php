<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ApiSubjectItemRequest;
use App\Http\Resources\SubjectItemResource;
use App\Models\ResultSubjectItem;
use App\Services\BaseCrud\BaseCrud;

class ResultSubjectItemController extends BaseCrud
{
    public $model = ResultSubjectItem::class;
    public $resource = SubjectItemResource::class;
    public $storeValidator = ApiSubjectItemRequest::class;
    public $updateValidator = ApiSubjectItemRequest::class;
    public $defaultOrder = "id";
    public $modelKey = "id";
    public $cacheInMinute = 10;
}
