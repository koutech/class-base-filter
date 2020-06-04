<?php 

namespace Koutech\TopLayerForSpatieQueryBuilder;


use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;

abstract class FilterAbstract
{

    private $byInstance = 'filter by';

    /**
     * available modes for searching 
     * 
     * @var array 
     *
     */
    protected $modes = [
        'all',
        'more',
        'accurate'
    ];

    /**
     * name of the method
     * 
     * @var string
     */
    protected $method = '';

    
   
    /**
     * check request has mode 
     * 
     * @return bool
     */
    public function hasMode()
    {
        return (bool) $this->request->has('mode') && in_array($this->request->mode, $this->modes);
    }

    /**
     * check request[filter] has 
     * 
     * @param string $name
     */
    public function reqFilterHas(string $name) 
    {
        if (!$this->request->has('filter')) {
            return false;
        }

        return (bool) array_key_exists($name, $this->request->filter);

    }
    
    /**
     * get the request filter 
     * 
     * @param string name
     * @param bool $flag
     */
    public function getReqFilter(string $name, bool $flag = false) 
    {

        if ($flag && !$this->reqFilterHas($name)) {
            return;
        }

        // dump($this->request->filter[$name]);

        // if ($this->request->filter[$name] === 'true' 
        //     || $this->request->filter[$name] === 'false') 
        // {

        //     return filter_var($this->request->filter[$name], FILTER_VALIDATE_BOOLEAN);
        // }

        return $this->request->filter[$name];

    }

    /**
     * check request has status 
     * 
     * @return bool
     */
    public function getStatus()
    {
        return filter_var($this->request->filter[status], FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * build dynamic method for filter 
     */
    public function buildMethod() 
    {
        if (!$this->hasMode()) {
            return;
        }

        $this->method = Str::camel($this->byInstance. ' ' . $this->getMode());

    }

    /**
     * set allowed includes and allowd filters
     * @param array $relationships
     * @param array $fields       
     */
    public function setPart(array $relationships, array $fields) 
    {

        $this->setAllowedIncludes($relationships);

        $this->setAllowedFilters($fields);

    }


    /**
     * build the allowed filter
     * @param  string $method 
     * @return array       
     */
    public function buildFilter(string $method) 
    {

        foreach ($this->getAllowedFilters() as $key => $filter) {
            $filters[$key] = AllowedFilter::$method($filter);
        }

        return $filters;

    }
    
}