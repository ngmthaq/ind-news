<?php

namespace Src\Models;

class Seo extends Model
{
    public string $title;
    public string $url;
    public string $description;
    public string $image;
    public string $keywords;

    public function __construct(
        string $title,
        string $url,
        string $description,
        string $image,
        string $keywords
    ) {
        $this->title = $title;
        $this->url = $url;
        $this->description = $description;
        $this->image = $image;
        $this->keywords = $keywords;
    }

    /**
     * Create SEO model from array data
     * 
     * @param $source
     * @return Seo
     */
    public static function fromArray(array $source): Seo
    {
        return new Seo(
            $source["title"],
            $source["url"],
            $source["description"],
            $source["image"],
            $source["keywords"]
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
