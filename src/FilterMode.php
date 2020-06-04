<?php 

namespace Koutech\TopLayerForSpatieQueryBuilder;


use Illuminate\Http\Request;

interface FilterMode
{
    /**
     * filter for more possible result
     * 
     */
    public function filterByMore();

    /**
     * filter for specific result
     * 
     */
    public function filterByAccurate();
    

    /**
     * filter for all result
     * 
     */
    public function filterByAll();
    
}