<?php

namespace Src\Configs;

class UploadedFile
{
    public string $name;
    public string $fullPath;
    public string $mimeType;
    public string $tmpName;
    public int $error;
    public int $size;
    public string $extension;
    public bool $isValid;

    public function __construct(array $file)
    {
        $this->name = $file["name"];
        $this->fullPath = $file["full_path"];
        $this->mimeType = $file["type"];
        $this->tmpName = $file["tmp_name"];
        $this->error = $file["error"];
        $this->size = $file["size"];
        $this->extension = pathinfo($this->name, PATHINFO_EXTENSION);
        $this->isValid = $this->error === UPLOAD_ERR_OK;
    }

    /**
     * Get random name
     * 
     * @param string $prefix
     * @return string
     */
    public function getRandomName(string $prefix): string
    {
        return $prefix . "_" . time() . "_" . generateRandomString() . "." . $this->extension;
    }
}
