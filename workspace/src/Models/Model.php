<?php

namespace Src\Models;

abstract class Model
{
    public int|null $createdAt = null;
    public int|null $updatedAt = null;

    /**
     * Create model from array data
     * 
     * @param $source
     * @return Model
     */
    public abstract static function fromArray(array $source): Model;

    /**
     * Convert this model to array
     * 
     * @return array
     */
    public abstract function toArray(): array;
}
