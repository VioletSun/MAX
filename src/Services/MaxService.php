<?php

namespace VioletSun\MAX\Services;

use VioletSun\MAX\Objects\Update;

class MaxService
{
    private Update $update;
    public function __construct() {}

    public function setUpdate(Update $update): static
    {
        $this->update = $update;
        return $this;
    }

    public function handle(): void
    {
        dump($this->update);
    }
}
