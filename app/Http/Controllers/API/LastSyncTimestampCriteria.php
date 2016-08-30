<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;

class LastSyncTimestampCriteria implements CriteriaInterface
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply criteria in query repository.
     *
     * @param $model
     * @param \Prettus\Repository\Contracts\RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, \Prettus\Repository\Contracts\RepositoryInterface $repository)
    {
        $last_sync_timestamp = $this->request->get('last_sync_timestamp', null);

        if ($last_sync_timestamp) {
            $model->where('updated_at', '>=', $last_sync_timestamp);
        }


        return $model;
    }
}