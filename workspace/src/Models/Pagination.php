<?php

namespace Src\Models;

class Pagination extends Model
{
    public array $data;
    public int $totalItems;
    public int $limit;
    public int $offset;
    public int $totalPages;
    public int $currentPage;
    public int $nextPage;
    public int $prevPage;
    public int $fromItems;
    public int $toItems;

    public function __construct(
        array $data,
        int $totalItems,
        int $limit,
        int $offset,
    ) {
        // Set attributes
        $this->data = $data;
        $this->totalItems = $totalItems;
        $this->limit = $limit;
        $this->offset = $offset;

        // Calc attribute
        $totalPages = $totalItems === 0 || $limit === 0 ? 0 : ceil($totalItems / $limit);
        $currentPage = $offset === 0 ? 1 : ($offset / $limit) + 1;
        $nextPage = $currentPage + 1;
        $prevPage = $currentPage - 1;
        $fromItems = $offset + 1;
        $toItems = $offset + $limit;
        $this->totalPages = $totalPages;
        $this->currentPage = $currentPage;
        $this->nextPage = $nextPage > $totalPages ? $totalPages : $nextPage;
        $this->prevPage = $prevPage < 1 ? 1 : $prevPage;
        $this->fromItems = $fromItems;
        $this->toItems = $toItems > $totalItems ? $totalItems : $toItems;
    }

    /**
     * Create Feature model from array data
     * 
     * @param $source
     * @return Pagination
     */
    public static function fromArray(array $source): Pagination
    {
        return new Pagination(
            $source["data"],
            $source["totalItems"],
            $source["limit"],
            $source["offset"],
        );
    }

    /**
     * Convert this model to array
     * 
     * @return array
     */
    public function toArray(): array
    {
        return (array) $this;
    }
}
