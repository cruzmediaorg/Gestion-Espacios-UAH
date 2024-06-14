<?php

namespace App;

use App\Helper\RelateToAll;

trait CustomRelationship
{
    public function relatoToAll($related, $foreignKey = 'id'): RelateToAll
    {
        $instance = $this->newRelatedInstance($related);
        return new RelateToAll($instance->newQuery(), $this, $foreignKey);
    }
}
