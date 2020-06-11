<?php

class Shop {
    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->data[$key] = $value;
        }
    }

    public function getDistance(Shop $shop)
    {
        return [];
    }

    public function __toArray()
    {
        return $this->data;
    }
}