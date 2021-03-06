<?php

App::uses('Dictionary', "Collections");
App::uses('SelectItem', "View/Controls");

class SelectList
{

    /**
     * The Collection of arrays or objects to handle
     * @var Collection <Object>
     */
    private $list;

    /**
     * The collection of SelectItem
     * @var Collection <SelectItem>
     */
    private $items = array();

    /**
     * The field that's gonna be the value on the SelectItem
     * @var string 
     */
    private $value;

    /**
     * The field that's gonna be the text on the SelectItem
     * @var string 
     */
    private $display;

    public function __construct($list, $value, $display)
    {
        $this->list = new Dictionary();
        
        foreach ($list as $key => $val) {
            $this->list->Add($key, $val);
        }
        
        $this->value = $value;
        $this->display = $display;
    }

    public function getItems()
    {
        if (empty($this->items)) {
            $this->items = new Collection();
            foreach ($this->list as $item => $value) {
                if (is_object($value)) {
                    $this->items->Add(new SelectItem($value->{$this->display}, $value->{$this->value}));
                } else {
                    $this->items->Add(new SelectItem($value, $item));
                }
            }
        }
        return $this->items;
    }

    public function setItems($items)
    {
        $this->list = $items;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getDisplay()
    {
        return $this->display;
    }

    public function setDisplay($display)
    {
        $this->display = $display;
    }

}