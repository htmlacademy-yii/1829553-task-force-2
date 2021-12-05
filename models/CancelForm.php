<?php

namespace app\models;

class CancelForm implements Modable
{

    public function getViewName(): string
    {
        return '//tasks/_form_refuse';
    }
}
