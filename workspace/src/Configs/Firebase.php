<?php

namespace Src\Configs;

use Google\Cloud\Storage\StorageObject;
use Google\Cloud\Firestore\FirestoreClient;
use Kreait\Firebase\Contract\Firestore;
use Kreait\Firebase\Contract\Storage;
use Kreait\Firebase\Factory;

class Firebase
{
    // https://github.com/kreait/firebase-php/blob/7.x/docs/overview.rst
    private Factory $factory;

    // https://github.com/GoogleCloudPlatform/php-docs-samples/tree/main/storage
    private Storage $storage;

    // https://github.com/GoogleCloudPlatform/php-docs-samples/tree/main/firestore
    private Firestore $firestore;

    public function __construct()
    {
        $factory = new Factory();
        $this->factory = $factory->withServiceAccount(ROOT . $_ENV["FIREBASE_CREDENTIALS_JSON"]);
        $this->storage = $this->factory->createStorage();
        $this->firestore = $this->factory->createFirestore();
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
     * Get firebase firestore
     * 
     * @return Firestore
     */
    public function getFirestore(): Firestore
    {
        return $this->firestore;
    }

    /**
     * Get firebase firestore database
     * 
     * @return FirestoreClient
     */
    public function getDatabase(): FirestoreClient
    {
        return $this->firestore->database();
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
     * @param string $
     * @param bool $isNeedFClose
     * @return array
     */
    public function uploadObject(string $name, string $source, bool $isNeedFClose = true): array
    {
        $file = fopen($source, "r");
        if (!$file) throw new \Exception(trans("error_cannot_open_file"));
        $bucket = $this->storage->getBucket();
        $object = $bucket->upload($file, ["name" => $name, "predefinedAcl" => "publicRead"]);
        if ($isNeedFClose === true) fclose($file);
        $publicUrl = "https://storage.googleapis.com/" . $_ENV["FIREBASE_STORAGE_BUCKET"] . "/" . $name;
        return compact("object", "publicUrl");
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
            $publicBaseUrl = "https://storage.googleapis.com/" . $_ENV["FIREBASE_STORAGE_BUCKET"] . "/";
            if (str_starts_with($name, $publicBaseUrl)) $name = str_replace($publicBaseUrl, "", $name);
            $bucket = $this->storage->getBucket();
            $object = $bucket->object($name);
            $object->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
