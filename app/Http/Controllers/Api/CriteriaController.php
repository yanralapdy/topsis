<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ApiCriteriaRequest;
use App\Http\Resources\CriteriaResource;
use App\Models\Criteria;
use App\Services\BaseCrud\BaseCrud;

class CriteriaController extends BaseCrud
{
    public $model = Criteria::class;
    public $resource = CriteriaResource::class;
    public $storeValidator = ApiCriteriaRequest::class;
    public $updateValidator = ApiCriteriaRequest::class;
    public $defaultOrder = "id";
    public $modelKey = "id";
    public $cacheInMinute = 10;
}
