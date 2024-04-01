<?php

namespace Src\Controllers;

use Src\Repos\IUserRepo;

class HomeController extends Controller
{
    protected IUserRepo $userRepo;

    public function __construct(IUserRepo $userRepo)
    {
        parent::__construct();
        $this->userRepo = $userRepo;
    }

    public function index()
    {
        $name = "Thang";
        $title = "Hello World";
        echo view("home.php", compact("name",  "title"));
    }
}
