<?php 

namespace Koutech\TopLayerForSpatieQueryBuilder;

use Exception;
use Illuminate\Http\Request;
use Koutech\TopLayerForSpatieQueryBuilder\FilterMode;
use Koutech\TopLayerForSpatieQueryBuilder\FilterAbstract;
use Koutech\TopLayerForSpatieQueryBuilder\FilterEloquent;
use Koutech\TopLayerForSpatieQueryBuilder\Traits\FilterPart;
use Koutech\TopLayerForSpatieQueryBuilder\Traits\RequestNot;
use Koutech\TopLayerForSpatieQueryBuilder\Traits\FilterQuery;
use Koutech\TopLayerForSpatieQueryBuilder\Traits\FilterCallable;

class Filter extends FilterAbstract implements FilterEloquent, FilterMode
{

    use FilterPart, RequestNot, FilterCallable, FilterQuery;
    

    /**
     * @var $request
     */
    protected $request;

    /**
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(?Request $request) 
    {
        $this->request = $request;

        // initialize 
        $this->initializeFilter();

    }


    /**
     * filter 
     * 
     * @param \Illuminate\Http\Request $request
     */
    public static function filter(?Request $request = null) 
    {
        if (is_null($request)) {
            $request = app(Request::class);
        }

        return new static($request);

    }


    /**
     * initialize the filter 
     */
    public function initializeFilter() 
    {

        if (!$this->checkRequirement) {
            throw new Exception('Class base filter require spatie/laravel-query-builder');
        }

        $this->buildProcess();

    }

    /**
     * build satffs for model && methods
     */
    protected function buildStaffs() 
    {
        $this->manualModel();

        $this->buildMethod();
    }


    public function get() 
    {

        if (!$this->method) {
            return $this->filterByAll();
        }

        
       return $this->{$this->method} ();
    }


     /**
     * get mode 
     * 
     * @return string 
     */
    public function getMode() 
    {
        if (!$this->hasMode()) 
        {
            return;
        }

        return $this->request->mode;
    }

    /**
     * build all process
     */
    protected function buildProcess() 
    {
        $this->buildStaffs();

        $this->loadQuery();

        // set part for includes &^ fields 
        $this->setPart(
            $this->includes(),
            $this->fields()
        );

        // init for request if not equal 
        $this->requestNotEqualInit();
    }

    /**
     * check requirement
     * 
     * @return bool
     */
    public function checkRequirement() 
    {
        return (bool) class_exists('Spatie\QueryBuilder\QueryBuilder');
    }


    public function __get($name) 
    {
        if (!method_exists($this, $name)) {
            return;
        }

        return $this->{$name} ();
    }    



    public function includes() 
    {
        return  [];
    }

    public function fields() 
    {
        return [];
    }


    public function eagerLoading() 
    {
        return [];
    }
    
    
}