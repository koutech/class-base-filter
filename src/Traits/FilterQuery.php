<?php 

namespace Koutech\TopLayerForSpatieQueryBuilder\Traits;


use Spatie\QueryBuilder\QueryBuilder;

trait FilterQuery 
{

    /**
     * @var Object
     */
    protected $query;


    /**
     * set the base query [set the eager loading if requested]
     * 
     */
    public function loadQuery() 
    {

        if (!is_null($this->model)) {
            $this->query = QueryBuilder::for($this->model);
        }

        if (!is_array($this->eagerLoading()) || !count($this->eagerLoading())) {
            return;
        }

        $this->query->with($this->eagerLoading());


    }


    /**
     * Filter for more possible result
     * 
     * @return  \Illuminate\Database\Eloquent\Collection 
     * 
     */
    public function filterByMore() 
    {


        return $this->query
            ->allowedIncludes(
                $this->getAllowedIncludes()
            )
            ->allowedFilters(
                $this->buildFilter('partial')
            )
        ->get();
        
    }

    /**
     * Filter for more accurate result
     *
     * @return  \Illuminate\Database\Eloquent\Collection 
     * 
     */
    public function filterByAccurate() 
    {
        
        return $this->query
            ->allowedIncludes(
                $this->getAllowedIncludes()
            )
            ->allowedFilters(
                $this->buildFilter('exact')
            )
        ->get();
    }

    
    /**
     * Filter for all result
     *
     * @return  \Illuminate\Database\Eloquent\Collection 
     */
    public function filterByAll()
    {

        return $this->query
            ->allowedIncludes(
                $this->getAllowedIncludes()
            )
            ->allowedFilters(
                $this->buildFilter('partial')
            )
        ->get();

    }
}