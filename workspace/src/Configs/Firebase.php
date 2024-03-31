<?php

namespace Src\Configs;

use Google\Cloud\Storage\StorageObject;
use Kreait\Firebase\Contract\Storage;
use Kreait\Firebase\Factory;

class Firebase
{
    private Factory $factory;
    private Storage $storage;

    public function __construct()
    {
        $this->factory = new Factory();
        $this->factory->withServiceAccount($_ENV["FIREBASE_CREDENTIALS_JSON"]);
        $this->storage = $this->factory->createStorage();
    }

    /**
     * Get firebase factory
     * 
     * @return Factory
     */
    public function getFactory(): Factory
    {
        return $this->factory;
    }

    /**
     * Get firebase storage
     * 
     * @return Storage
     */
    public function getStorage(): Storage
    {
        return $this->storage;
    }

    /**
     * Get Storage Object Data
     * 
     * @param string $name
     * @return StorageObject
     */
    public function getObject(string $name): StorageObject
    {
        $bucket = $this->storage->getBucket();
        $object = $bucket->object($name);
        return $object;
    }

    /**
     * Upload File
     * 
     * @param string $name
     * @param string $source
     * @return array
     */
    public function uploadObject(string $name, string $source): array
    {
        $file = fopen($source, "r");
        if (!$file) throw new \Exception("Không thể đọc tệp tin");
        $bucket = $this->storage->getBucket();
        $object = $bucket->upload($file, ["name" => $name, "predefinedAcl" => "publicRead"]);
        fclose($file);
        $public_url = "https://storage.googleapis.com/" . $_ENV["FIREBASE_STORAGE_BUCKET"] . "/" . $name;
        return compact("object", "public_url");
    }

    /**
     * Delete Storage Object Data
     * 
     * @param string $name
     * @return bool
     */
    public function deleteObject(string $name): bool
    {
        try {
            $bucket = $this->storage->getBucket();
            $object = $bucket->object($name);
            $object->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
