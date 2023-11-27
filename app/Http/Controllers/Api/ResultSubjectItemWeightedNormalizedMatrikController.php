<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ApiSubjectItemRequest;
use App\Http\Resources\ResultSubjectItemWeightedNormalizedMatrikResource;
use App\Models\ResultSubjectItemWeightedNormalizedMatrik;
use App\Services\BaseCrud\BaseCrud;

class ResultSubjectItemWeightedNormalizedMatrikController extends BaseCrud
{
    public $model = ResultSubjectItemWeightedNormalizedMatrik::class;
    public $resource = ResultSubjectItemWeightedNormalizedMatrikResource::class;
    public $storeValidator = ApiSubjectItemRequest::class;
    public $updateValidator = ApiSubjectItemRequest::class;
    public $defaultOrder = "id";
    public $modelKey = "id";
    public $cacheInMinute = 10;
}
