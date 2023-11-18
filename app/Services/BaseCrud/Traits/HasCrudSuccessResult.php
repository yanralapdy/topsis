<?php

namespace App\Services\BaseCrud\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;

trait HasCrudSuccessResult
{
    public function __successList($query)
    {
        $request = $this->requestData;

        $data = $this->resource::collection($query)->additional($this->__additionalCollection());

        if ($request->query("is_cache") == "1") {
            $key =  Request::getRequestUri();

            Cache::put($key, $data, Carbon::now()->addMinutes($this->cacheInMinute));
        }

        return $this->__success($data);
    }

    public function __successShow()
    {
        $request = $this->requestData;

        $data = new $this->resource($this->row);

        if ($request->query("is_cache") == "1") {
            $key =  Request::getRequestUri();

            Cache::put($key, $data, Carbon::now()->addMinutes($this->cacheInMinute));
        }

        return $this->__success($data);
    }

    public function __successUpdate()
    {
        return $this->__success(new $this->resource($this->row), [
            "message" => $this->updateMessage
        ]);
    }

    public function __successStore()
    {
        return $this->__success(new $this->resource($this->row), [
            "message" => $this->storeMessage
        ]);
    }

    public function __successDestroy()
    {
        return $this->__success(
            null,
            [
                "message" => $this->destroyMessage,
            ]
        );
    }

    public function __successBulkDestroy()
    {
        return $this->__success(
            null,
            [
                "message" => "Data berhasil dihapus",
            ]
        );
    }


    public function __success($data = null, $additonal = [])
    {
        $additionalResponse = ["success" => true, "data" => []];
        if (!empty($data)) {
            $additonalResponse = array_merge($additionalResponse, ["message" => "Berhasil memuat data"]);
            if (!empty($additonal)) {
                $additonalResponse = array_merge($additonalResponse, $additonal);
            }

            return $data->additional($additonalResponse);
        }


        if (!empty($additonal)) {
            return array_merge($additionalResponse, $additonal);
        }

        return $additionalResponse;
    }

    public function __additionalCollection()
    {
        return [];
    }
}
