<?php
require 'app/Mixin/AOP.php';
require 'app/Model/Person.php';
require 'app/Single/People.php';
require 'app/Controller/Index.php';

use Controller\Index as Index;

Index::render();

