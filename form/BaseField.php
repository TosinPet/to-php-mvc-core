<?php

namespace App\core\form;

use App\core\model;

abstract class BaseField
{
    public model $model;
    public string $attribute;

    public function __construct(model $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }

   abstract public function renderInput(): string;

   public function __toString()
    {
        return sprintf('
            <div class="form-group">
                <label>%s</label>
                %s
                <div class="invalid-feedback">
                    %s
                </div>
            </div>
        ',
            $this->model->getlabel($this->attribute),
            $this->renderInput(),
            $this->model->getFirstError($this->attribute)
        );
    }

}