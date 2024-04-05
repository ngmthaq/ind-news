<?php

namespace Src\Models;

class User extends Model
{
    public string $id;
    public string $email;
    public string $password;
    public string $name;

    public function __construct(
        string $id,
        string $email,
        string $password,
        string $name,
        string $createdAt,
        string $updatedAt
    ) {
        $this->id = $id;
        $this->email = $email;
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
            $source["email"],
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
