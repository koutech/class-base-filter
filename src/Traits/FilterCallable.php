<?php 

namespace Koutech\TopLayerForSpatieQueryBuilder\Traits;

use Exception;
use Reflection;

trait FilterCallable 
{

    /**
     * the eloquent model
     * 
     * @var $model
     */
    protected $model;


    /**
     * set model manually
     */
    public function manualModel() 
    {

        // if there is no model method set automatically
        if (!$this->hasMethod()) {
            return $this->auto();
        }

        $model = $this->model();

        if (!$this->hasModel($model)) {
            throw new Exception('Model not found: '. $model);
        }

        $this->setModel($model);

    }

    /**
     * set the model name automatically by naming convention
     */
    private function auto() 
    {

        $name = $this->getModelName();

        $class = $this->getModelFullPath($name);

        if (!$this->hasModel($class)) {
            throw new Exception('Method called model not found:');
        }

        return $this->setModel($class);

    }
    

    /**
     * set the model 
     * 
     * @param string $model
     */
    public function setModel(string $model) 
    {
        $this->model = $model;
    }

    /**
     * check model method available
     * 
     * @return bool
     */
    public function hasMethod() 
    {
        if (!method_exists($this, 'model')) {
            return false;
        }

        return true;
    }

    /**
     * check model exists or not 
     * 
     * @param string $model 
     * 
     * @return bool
     * 
     */
    public function hasModel($model) 
    {
        return (bool) class_exists($model);
    }

    /**
     * get using class name 
     * 
     * @return array 
     */
    public function getClassName() 
    {
        $class = explode('\\', get_class($this));

        return [
            'root' => $class[array_key_first($class)],
            'class' => $class[array_key_last($class)]
        ];
    }

    /**
     * get the name of the model 
     *
     * @return string
     */
    public function getModelName() 
    {
        $class = $this->getClassName()['class'];

        $name =  preg_split('/(?=[A-Z])/', $class, -1, PREG_SPLIT_NO_EMPTY);

        $name = $name[array_key_first($name)];

        return $name;
    }

    /**
     * @param string $name
     * 
     * get full model path
     *
     */
    public function getModelFullPath($name) 
    {
        $class = $this->getClassName()['root'].'\\' . $name;

        return $class;
    }

}