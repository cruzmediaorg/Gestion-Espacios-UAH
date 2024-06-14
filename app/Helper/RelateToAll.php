<?php

namespace App\Helper;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class RelateToAll extends Relation
{
    private $catchAll;
    private $ownerKey;

    public function __construct(Builder $query, Model $parent, $ownerKey, $catchAll = null)
    {
        /*
          It is possible to provide own callback to query all models.
          By default, it assumes that ID is numeric and is > 0
        */
        if (is_null($catchAll)) {
            $catchAll = function($query) use ($ownerKey) {
                $query->where($ownerKey, '>', 0);
            };
        }

        $this->related = $parent;
        $this->ownerKey = $ownerKey;
        $this->catchAll = $catchAll;

        parent::__construct($query, $parent);
    }

    public function addConstraints()
    {
        if (static::$constraints) {
            $query = $this->getRelationQuery();
            ($this->catchAll)($query);
        }
    }

    public function addEagerConstraints(array $models)
    {
        /*
          Warning! It is not possible to eager load this relation!
        */
        throw new \Exception("No eager loading for catch all relation!", 1);
    }

    public function initRelation(array $models, $relation)
    {
        foreach ($models as $model) {
            $model->setRelation($relation, $this->related->newCollection());
        }

        return $models;
    }

    public function match(array $models, Collection $results, $relation)
    {
        return $this->matchMany($models, $results, $relation);
    }

    public function getResults()
    {
        return $this->query->get();
    }
}
