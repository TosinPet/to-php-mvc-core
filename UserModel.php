<?php

namespace too\phpmvc;

use too\phpmvc\db\DbModel as DbDbModel;
use too\phpmvc\DbModel;

abstract class UserModel extends DbDbModel
{
    abstract public function getDisplayName(): string;
}