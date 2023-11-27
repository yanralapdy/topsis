<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ApiSubjectItemRequest;
use App\Http\Resources\ResultCriteriaResource;
use App\Models\ResultCriteria;
use App\Services\BaseCrud\BaseCrud;

class ResultCriteriaController extends BaseCrud
{
    public $model = ResultCriteria::class;
    public $resource = ResultCriteriaResource::class;
    public $storeValidator = ApiSubjectItemRequest::class;
    public $updateValidator = ApiSubjectItemRequest::class;
    public $defaultOrder = "id";
    public $modelKey = "id";
    public $cacheInMinute = 10;
}
