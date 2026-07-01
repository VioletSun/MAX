<?php

namespace App\Services\Max;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use VioletSun\MAX\Exceptions\WebhookException;
use VioletSun\MAX\Objects\Update;
use VioletSun\MAX\Objects\Updates;

class MaxService
{
    private Request $request;

    public function __construct() {}

    public function setRequest(Request $request): static
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @throws WebhookException
     */
    public function checkWebhook(): static
    {
        if (config('max.webhook.secret') !== $this->request->header('X-Max-Bot-Api-Secret')) {
            throw WebhookException::required();
        }
        return $this;
    }

    public function handle(): JsonResponse
    {
        Update::fromArray($this->request->all());
        // dump($update);
        return response()->json(['status' => true]);
    }
}
