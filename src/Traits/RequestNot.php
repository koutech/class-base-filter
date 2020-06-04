<?php 

namespace Koutech\TopLayerForSpatieQueryBuilder\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

trait RequestNot
{

    protected $notEqual = [];
    

    protected function requestNotEqualInit() 
    {
        if (!method_exists($this, 'requestIgnore') || !is_array($this->requestIgnore()))
        {
            return;
        }

        foreach ($this->requestIgnore() as $field => $value) {
            $value = (array) $value;
            $this->requestNotEqualTo($field, $value);
        }



    }

    /**
     * 
     * @param string $field
     * @param array $equal
     */
    protected function requestNotEqualTo(string $field, array $equal) 
    {

        if ($this->reqFilterHas($field)) {

            $req = $this->ensureBoolean((array) $this->getReqFilter($field));

            // dump($this->getReqFilter($field));
            // dump($req);

            $check = $this->valueCheck($equal, $req);

            // dd($check);

            if ($check <= 0) {
                $this->removeFilter($field);
            }

        }        
    }

    /**
     * @param array $arr1
     * @param array $arr2
     * 
     * 
     * check value in second give array exist in first
     */ 
    protected function valueCheck($arr1, $arr2) 
    {

        $c = 0;

        for ($i = 0; $i < count($arr2); $i++) {

            if (in_array($arr2[$i], $arr1, true)) {
                $c++;
            }
        }

        return $c;
    
    }

    /**
     * @param array $array 
     * 
     * string 0, 1 => integer 0, 1
     */
    protected function ensureBoolean($arr) 
    {
        foreach ($arr as $key => $value) {
            if ($value === "0" || $value === "1") {
                $arr[$key] = (int) $value;
            }
        }

        return $arr;
    }

    
}