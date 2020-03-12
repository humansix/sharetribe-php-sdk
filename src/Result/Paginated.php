<?php

namespace Sharetribe\Sdk\Result;

use Sharetribe\Sdk\Api\ApiInterface;
use Sharetribe\Sdk\Result\Paginated;

class Paginated implements \Iterator
{
    protected $position = 0;

    protected $api;

    protected $method;

    protected $filter;

    protected $items;

    protected $totalItems;

    protected $totalPages;

    protected $page;

    protected $perPage;

    public function __construct(ApiInterface $api, $method, $filter = [])
    {
        $this->api = $api;
        $this->method = $method;
        $this->filter = $filter;
        $this->totalItems = $date['totalItems'];
        $result = call_user_func([$this->api, $this->method], $filter);
        $this->items = $result['data'];
        $this->totalItems = $result['meta']['totalItems'];echo $this->totalItems;
        $this->totalPages = $result['meta']['totalPages'];
        $this->page = $result['meta']['page'];
        $this->perPage = $result['meta']['perPage'];
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function current()
    {
        return $this->items[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        if ($this->position + 1 >= $this->perPage && $this->totalPages >= $this->page) {
            $this->page++;
            $this->position = 0;
            $filter = [
                'page' => $this->page,
                'perPage' => $this->perPage,
            ];
            $reflectionMethod = new \ReflectionMethod(get_class($this->api), $this->method);
            $this->items = $reflectionMethod->invoke($this->api, $filter)['data'];
        } else {
            ++$this->position;
        }
    }

    public function valid()
    {
        return isset($this->items[$this->position]);
    }
}
