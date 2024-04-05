<?php

if (!file_exists("./prod.log")) touch("./prod.log");
exec("yarn build");
