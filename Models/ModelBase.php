<?php
namespace App\Models;

class ModelBase
{
    public function __construct()
    {
        $arguments = func_get_args();

        if (!empty($arguments)) {
            foreach ($arguments[0] as $key => $property) {
                if (property_exists($this, $key)) {
                    $this->{$key} = $property;
                }
            }
        }
    }
}
