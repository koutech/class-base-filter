<?php 

namespace Koutech\TopLayerForSpatieQueryBuilder\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

trait FilterPart
{

    /**
     * @var array
     */
    protected $allowedIncludes = [];

    /**
     * @var array
     */
    protected $allowedFilters = [];

    /**
     * set allowed includes 
     * 
     * @param array $include
     */
    protected function setAllowedIncludes(array $includes) 
    {

        if (!count($includes)) {
            return;
        }
        
        if(is_array($includes[0])) {
            $includes = Arr::collapse($includes);
        }


        $this->allowedIncludes = $includes;
    }

    /**
     * get allowed includes 
     *
     * @return  array
     */
    protected function getAllowedIncludes() 
    {
        return $this->allowedIncludes;
    }


    /**
     * set allowed filters 
     * 
     * @param array $filters
     */
    protected function setAllowedFilters(array $filters) 
    {
        if (is_array($filters[0])) {
            $filters = Arr::collapse($filters);
        }

        $this->allowedFilters = $filters;
    }

    /**
     * remove allowed filters 
     * 
     * @param string|array $field
     */
    protected function removeFilter($field) 
    {
        if (!$this->reqFilterHas($field)) {
            return;
        }

        $key = array_search($field, $this->allowedFilters);

        unset($this->allowedFilters[$key]);

        $this->allowedFilters = array_values($this->allowedFilters);


    }

    /**
     * get allowed filters
     *
     * @return array
     */
    protected function getAllowedFilters() 
    {
        return $this->allowedFilters;
    }

    /**
     * check filter has field
     *
     * @return bool
     */
    public function filterHas(string $field) 
    {
        return (bool) in_array($field, $this->getAllowedFilters());
    }

    
}