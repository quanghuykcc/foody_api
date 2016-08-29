<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;

class CategoryIdCriteria implements CriteriaInterface
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
        $category_id = $this->request->get('category_id', null);

        if ($category_id) {
            $model->where('category_id', $category_id);
        }


        return $model;
    }
}