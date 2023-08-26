<?php

class RealPathChangeDetector
{
    private readonly string $originalRealPath;

    public function __construct(private readonly string $pathToCheck)
    {
        $originalRealPath = realpath($this->pathToCheck);

        if ($originalRealPath === false) {
            throw new \RuntimeException("Unable to find realpath for: $this->pathToCheck");
        }

        $this->originalRealPath = $originalRealPath;
    }

    public function pathHasChanged(): bool
    {
        clearstatcache(true, $this->pathToCheck);
        return realpath($this->pathToCheck) !== $this->originalRealPath;
    }
}
