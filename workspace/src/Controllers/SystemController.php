<?php

namespace Src\Controllers;

class SystemController extends Controller
{
    public function phpinfo()
    {
        echo phpinfo();
    }
}
