<?php

namespace App\core;

use App\core\db\DbModel as DbDbModel;
use App\core\DbModel;

abstract class UserModel extends DbDbModel
{
    abstract public function getDisplayName(): string;
}