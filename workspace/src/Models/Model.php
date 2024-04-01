<?php

namespace Src\Models;

abstract class Model
{
    public int|null $createdAt;
    public int|null $updatedAt;

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
