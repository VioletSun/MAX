<?php

namespace App\Services\Max;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use VioletSun\MAX\Objects\Update;

class MaxService
{
    private Request $request;

    public function __construct() {}

    public function setRequest(Request $request): static
    {
        $this->request = $request;
        return $this;
    }

    public function checkWebhook(): static
    {
        // dump($this->request);
        return $this;
    }

    public function handle(): JsonResponse
    {
        $update = Update::fromArray($this->request->all());
        // dump($update);
        return response()->json(['status' => true]);
    }
}
