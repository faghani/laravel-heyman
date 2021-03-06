<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

class EloquentEventsManager
{
    private $event;

    private $modelClass;

    /**
     * RouteConditionApplier constructor.
     *
     * @param $event
     * @param $modelClass
     *
     * @return \Imanghafoori\HeyMan\WatchingStrategies\EloquentEventsManager
     */
    public function init($event, $modelClass)
    {
        $this->event = $event;
        $this->modelClass = $modelClass;

        return $this;
    }

    /**
     * @param $callback
     */
    public function startGuarding(callable $callback)
    {
        foreach ($this->modelClass as $model) {
            $model::{$this->event}($callback);
        }
    }
}
