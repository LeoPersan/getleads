<?php

require_once('CSV.php');

require_once('Shop.php');

class Market {
    public function __construct($data, $options = [])
    {
        if (is_file($data)) {
            $class = strtoupper(pathinfo($data)['extension']);
            $data = $class::read($data, $this->getDefaultOptions($options));
        }

        if (!is_iterable($data))
            throw new Exception("Cannot read data. Data can be CSV or Iterable Object", 1);

        foreach ($data as $shop) {
            $this->shops[] = new Shop($shop);
        }
        $this->total_shops = count($this->shops);
        $this->shop_mean = $this->getMean();
        $this->setDistances();
    }

    public function getDefaultOptions($options)
    {
        return $options;
    }

    public function getMatches(Market $market)
    {
        foreach ($market as &$shop) {
            $distance = $this->shop_mean->getDistance($shop);
            $finded_shops = $this->countShopsBetweenMeanUntilDistance($distance);
            $shop->probability = $finded_shops/$this->total_shops;
        }
        return $market;
    }

    public function countShopsBetweenMeanUntilDistance($distance)
    {
        # code...
    }

    public function setDistances()
    {
        foreach ($this->shops as &$shop) {
            foreach ($shop as $key => $value) {
                switch (gettype($value)) {
                    case 'integer':
                    case 'double':
                        $mean[$key] = isset($mean[$key]) ? $mean[$key]+$value : $value;
                        break;
                    case 'boolean':
                    case 'string':
                        $mean[$key][$value]++;
                        break;
                }
            }
        }
    }

    public function getMean()
    {
        $mean = [];
        foreach ($this->shops as $shop) {
            foreach ($shop as $key => $value) {
                switch (gettype($value)) {
                    case 'integer':
                    case 'double':
                        $mean[$key] = isset($mean[$key]) ? $mean[$key]+$value : $value;
                        break;
                    case 'boolean':
                    case 'string':
                        $mean[$key][$value]++;
                        break;
                }
            }
        }
        foreach ($mean as $key => $value) {
            switch (gettype($value)) {
                case 'integer':
                case 'double':
                    $mean[$key] /= $this->total_shops;
                    break;
                case 'array':
                    $mean[$key] = array_search(max($mean[$key]),$mean[$key]);
                    break;
            }
        }
        return new Shop($mean);
    }

    public function print()
    {
        return $this->shops;
    }
}