<?php

namespace app\models;

class RefuseForm implements Modable
{

    public function getViewName(): string
    {
        return '//tasks/_form_refuse';
    }
}
