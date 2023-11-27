<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ApiSubjectItemRequest;
use App\Http\Resources\ResultSubjectItemNormalizedMatrikResource;
use App\Models\ResultSubjectItemNormalizedMatrik;
use App\Services\BaseCrud\BaseCrud;

class ResultSubjectItemNormalizedMatrikController extends BaseCrud
{
    public $model = ResultSubjectItemNormalizedMatrik::class;
    public $resource = ResultSubjectItemNormalizedMatrikResource::class;
    public $storeValidator = ApiSubjectItemRequest::class;
    public $updateValidator = ApiSubjectItemRequest::class;
    public $defaultOrder = "id";
    public $modelKey = "id";
    public $cacheInMinute = 10;
}
