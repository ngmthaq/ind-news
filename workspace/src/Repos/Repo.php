<?php

namespace Src\Repos;

abstract class Repo implements RepoInterface
{
    public function all(): array
    {
        return [];
    }

    public function first(): mixed
    {
        return "";
    }
}
