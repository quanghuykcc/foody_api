<?php

namespace App\Http\Criteria;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;

class FavoriteUserIdCriteria implements CriteriaInterface
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
        $favorite_user_id = $this->request->get('favorite_user_id', null);

        if ($favorite_user_id) {
            $model->whereHas('favorite', function ($query) use ($favorite_user_id) {
                $query->where('user_id', '=', $favorite_user_id);
            });
        }


        return $model;
    }
}