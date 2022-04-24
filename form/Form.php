<?php

namespace too\phpmvc\form;

use too\phpmvc\model;

// // use too\phpmvc\model;

class Form
{
    public static function begin($action, $method)
    {
         echo sprintf('<form action="%s" method="%s">', $action, $method);
         return new Form();
    }

    public static function end()
    {
        echo '</form>';
    }

    public function field(model $model, $attribute)
    {
        return new InputField($model, $attribute);
    }
}