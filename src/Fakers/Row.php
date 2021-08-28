<?php

namespace Mar4hk0\Fakers;

class Row
{
    private array $data;
    private array $requireColumns;

    private array $items;

    public function __construct(array $data, array $requireColumns)
    {
        $this->data = $data;
        $this->requireColumns = $requireColumns;
    }

    public function generateItems(): void
    {
        foreach ($this->requireColumns as $columnMySQL => $item) {
            $columnCSV = key($item);
            $type = $item[$columnCSV];
            $value = null;
            if (!empty($this->data[$columnMySQL])) {
                $value = $this->data[$columnMySQL];
            }
            if (!empty($this->data[$columnCSV])) {
                $value = $this->data[$columnCSV];
            }
            $this->items[] = new Item($type, $value);
        }
    }

    public function generateString(): string
    {
        $buf = [];
        foreach ($this->items as $item) {
            $buf[] = $item->render();
        }
        unset($this->items);
        return '(' . implode(', ', $buf) . ')';
    }
}
