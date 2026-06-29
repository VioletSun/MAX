<?php

namespace App\Services\Max;

use Illuminate\Http\Request;
use VioletSun\MAX\Objects\Update;

class MaxService
{
    private Update $update;

    public function __construct() {}

    public function checkWebhook(Request $request): static
    {
        // dump($request);
        return $this;
    }

    public function setUpdate(Update $update): static
    {
        $this->update = $update;
        return $this;
    }

    public function handle(): void
    {
        // dump($this->update);
    }
}
