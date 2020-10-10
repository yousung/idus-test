<?php

declare(strict_types=1);

namespace App\Filter;

class UserFilter extends Filter
{
    protected array $filters = ['search'];

    public function search($search)
    {
        $this->builder->where(function ($searchQuery) use ($search) {
            $searchQuery->where('name', 'like', "%{$search}%");
            $searchQuery->orWhere('email', $search);
        });
    }

    public function init()
    {
        $this->builder->orderBy(request('orderBy', 'name'), 'ASC');
        $this->builder->with(['orders' => function($selectQuery){
            $selectQuery->select(['id', 'name', 'user_id', 'order_id', 'settlement_at', 'created_at', 'updated_at']);
        }]);
    }
}
