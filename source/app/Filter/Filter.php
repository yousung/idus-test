<?php

declare(strict_types=1);

namespace App\Filter;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

abstract class Filter
{
    protected Request $request;
    protected object $builder;
    protected array $filters = [];

    const ORDER_TYPE = ['DESC', 'ASC'];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilter() as $filter => $value) {
            $filter = Str::camel($filter);
            if (method_exists($this, $filter)) {
                $this->{$filter}($value);
            }
        }

        if (method_exists($this, 'init')) {
            $this->init();
        }
    }

    public function getFilter()
    {
        return array_filter($this->request->only($this->filters));
    }

    protected function hasFilter($filter): bool
    {
        return method_exists($this, $filter) && $this->request->has($filter);
    }
}
