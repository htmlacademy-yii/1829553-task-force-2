<?php

namespace Mar4hk0\Fakers;

class Item
{
    private string $type;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @param string $type
     * @param mixed $value
     */
    public function __construct(string $type, $value)
    {
        $this->type = $type;
        if (is_null($value)) {
            $value = ContentFakeFactory::generate($type);
        }
        $this->value = $value;
    }

    public function render()
    {
        switch ($this->type) {
            case 'string':
            case 'varchar':
            case 'email':
            case 'text':
            case 'date':
                $result = "'" . $this->value . "'";
                break;
            case 'int':
            case 'float':
                $result = $this->value;
                break;
            default: $result = $this->value;
        }
        return $result;
    }

}
