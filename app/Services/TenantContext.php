<?php

namespace App\Services;

use App\Models\Mosque;
use Illuminate\Support\Facades\Cache;

class TenantContext
{
    protected ?Mosque $mosque = null;

    public function set(Mosque $mosque): void
    {
        $this->mosque = $mosque;
    }

    public function get(): ?Mosque
    {
        return $this->mosque;
    }

    public function id(): ?int
    {
        return $this->mosque?->id;
    }

    public function slug(): ?string
    {
        return $this->mosque?->slug;
    }

    public function feature(string $name): bool
    {
        if (!$this->mosque) return false;

        return Cache::remember("tenant_{$this->id()}_feature_{$name}", 3600, function () use ($name) {
            $features = $this->mosque->plan->features ?? [];
            return in_array($name, $features);
        });
    }
}
