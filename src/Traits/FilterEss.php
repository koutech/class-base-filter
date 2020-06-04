<?php 

namespace Koutech\TopLayerForSpatieQueryBuilder\Traits;

trait FilterEss 
{
    /**
     * allowed includes default []
     */
    public function includes() 
    {
        return  [];
    }

    /**
     * allowed fields default []
     */
    public function fields() 
    {
        return [];
    }

    /**
     * egaerLoading default []
     */
    public function eagerLoading() 
    {
        return [];
    }
}