<?php

namespace Src\Models;

abstract class Model
{
    public string|null $createdAt = null;
    public string|null $updatedAt = null;

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
