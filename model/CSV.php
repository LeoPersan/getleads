<?php

class CSV {
    public static function read($path, $options = [])
    {
        $options = self::getDefaultOptions($options);
        $lines = file($path);
        $titles = $options['is_titled'] ? $lines[0] : range(0,count($lines[0]));
        $data = [];
        foreach ($lines as $line) {

            $data[] = array_combine($titles, $line);
        }
        return $data;
    }
    public static function getDefaultOptions($options)
    {
        return array_merge(
            [
                'is_titled'=>true
            ],
            $options);
    }
}