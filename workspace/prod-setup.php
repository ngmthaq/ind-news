<?php

if (!file_exists("./prod.log")) touch("./prod.log");
echo shell_exec("yarn build");
