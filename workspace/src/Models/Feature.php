<?php

namespace Src\Models;

class Feature extends Model
{
    public int $id;
    public string $i18nKey;
    public string $url;
    public string $bsIcon;
    public string|null $deletedAt;

    public function __construct(
        int $id,
        string $i18nKey,
        string $url,
        string $bsIcon,
        string $createdAt,
        string $updatedAt,
        string|null $deletedAt,
    ) {
        $this->id = $id;
        $this->i18nKey = $i18nKey;
        $this->url = $url;
        $this->bsIcon = $bsIcon;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->deletedAt = $deletedAt;
    }

    /**
     * Create Feature model from array data
     * 
     * @param $source
     * @return Feature
     */
    public static function fromArray(array $source): Feature
    {
        return new Feature(
            $source["id"],
            $source["i18nKey"],
            $source["url"],
            $source["bsIcon"],
            $source["createdAt"],
            $source["updatedAt"],
            $source["deletedAt"],
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

    /**
     * Check is active
     * 
     * @return bool
     */
    public function isActive(): bool
    {
        $url = str_replace("/public", "", $_SERVER["REDIRECT_URL"]);
        return $this->url === $url;
    }
}
