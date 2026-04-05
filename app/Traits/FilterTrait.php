<?php

namespace App\Traits;

trait FilterTrait
{
    public function filter($query, $request)
    {
        foreach ($request as $key => $value) {
            if ($value) {
                $query->where($key, 'like', '%' . $value . '%');
            }
        }
    }
}
