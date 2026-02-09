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
        if (!$this->mosque) {
            return false;
        }

        return Cache::remember("tenant_{$this->id()}_feature_{$name}", 300, function () use ($name) {
            $mosque = $this->mosque->loadMissing(['plan.features', 'featureOverrides.feature']);

            $override = $mosque->featureOverrides
                ->firstWhere('feature.name', $name);

            if ($override) {
                return (bool) $override->enabled;
            }

            return $mosque->plan?->features?->contains('name', $name) ?? false;
        });
    }
}
