<?php

namespace Src\Models;

class User extends Model
{
    public const USER = 1;
    public const ADMIN = 2;
    public const MALE = 1;
    public const FEMALE = 2;

    public string $id;
    public string $email;
    public string $password;
    public string $name;
    public string $avatar;
    public string $dob;
    public int $gender;
    public int $role;
    public string|null $emailVerifiedAt;
    public string|null $deletedAt;

    public function __construct(
        string $id,
        string $email,
        string $password,
        string $name,
        string $avatar,
        string $dob,
        int $gender,
        int $role,
        string|null $emailVerifiedAt,
        string $createdAt,
        string $updatedAt,
        string|null $deletedAt,
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->avatar = $avatar;
        $this->dob = $dob;
        $this->gender = $gender;
        $this->role = $role;
        $this->emailVerifiedAt = $emailVerifiedAt;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->deletedAt = $deletedAt;
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
            $source["avatar"],
            $source["dob"],
            $source["gender"],
            $source["role"],
            $source["emailVerifiedAt"],
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
     * Check role admin
     * 
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ADMIN;
    }
}
