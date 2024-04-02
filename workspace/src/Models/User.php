<?php

namespace Src\Models;

class User extends Model
{
    public string $id;
    public string $username;
    public string $password;
    public string $name;

    public function __construct(
        string $id,
        string $username,
        string $password,
        string $name,
        int $createdAt,
        int $updatedAt
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->name = $name;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * Create user model from array data
     * 
     * @param $source
     * @return User
     */
    public static function fromArray(array $source): User
    {
        return new User(
            $source["id"],
            $source["username"],
            $source["password"],
            $source["name"],
            $source["createdAt"],
            $source["updatedAt"]
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
