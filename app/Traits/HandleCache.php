<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait HandleCache
{
    public function getCache($key)
    {
        return Cache::get($key);
    }

    public function setCache($key, $value, $minutes = 60)
    {
        Cache::put($key, $value, $minutes);
    }

    public function hasCache($key)
    {
        return Cache::has($key);
    }

    public function clearCache($key)
    {
        Cache::forget($key);
    }
}
