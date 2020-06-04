<?php 

namespace Koutech\TopLayerForSpatieQueryBuilder;


use Illuminate\Http\Request;

interface FilterEloquent 
{
    /**
     * filter 
     * 
     * @param \Illuminate\Http\Request $request
     */
    public static function filter(?Request $request = null);

    /**
     * set allowed includes
     */
    public function includes();
    
    /**
     * set allowed fields
     */
    public function fields();

    /**
     * egaer loading 
     */
    public function eagerLoading();
}