<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use ReflectionClass;
use ReflectionMethod;

abstract class QueryFilters
{
    /**
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * The builder instance.
     *
     * @var Builder
     */
    protected $builder;

    /**
     * Create a new QueryFilters instance.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = new Request(array_filter($request->input()));
    }
    /**
     * Creates a new instance with the specified filters.
     *
     * @param array $filters
     *
     * @return static
     */
    public static function make(array $filters = [])
    {
        return new static(new Request($filters));
    }

    /**
     * Apply the filters to the builder.
     *
     * @param Builder $builder
     * @param array   $defaults
     *
     * @return Builder
     */
    public function apply(Builder $builder, $defaults = [])
    {
        $this->builder = $builder;

        foreach ($this->filters() as $name => $value) {
            if (!method_exists($this, $name)) {
                continue;
            }

            if (empty($value)) {
                $this->$name();
            } else {
                $this->$name($value);
            }
        }

        if (!empty($defaults)) {
            $this->applyDefaults($defaults);
        }

        return $this->builder;
    }

    /**
     * Apply default filters to the builder.
     *
     * @param array $defaults
     *
     * @return void
     */
    public function applyDefaults($defaults)
    {
        foreach ($defaults as $filter => $value) {
            // Do not override if already applied.
            if (!array_key_exists($filter, $this->filters())) {
                $this->$filter($value);
            }
        }
    }

    /**
     * Get all request filters data.
     *
     * @return array
     */
    public function filters()
    {
        $keys = $this->getFilterMethods();

        return $this->request->only($keys);
    }

    /**
     * Get all the available filter methods.
     *
     * @return array
     */
    protected function getFilterMethods()
    {
        $class = new ReflectionClass(static::class);

        $methods = array_map(function ($method) use ($class) {
            if ($method->class === $class->getName()) {
                return $method->name;
            }

            return null;
        }, $class->getMethods(ReflectionMethod::IS_PUBLIC));

        return array_filter($methods);
    }
}
