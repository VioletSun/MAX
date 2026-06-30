<?php

namespace App\Services\Max;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use VioletSun\MAX\Objects\Update;

class MaxAppService
{
    private Request $request;

    public function __construct() {}

    public function setRequest(Request $request): static
    {
        $this->request = $request;
        return $this;
    }

    public function checkApp(): static
    {
        // check MAX server secret
        // else Error
        return $this;
    }

    public function view(): View
    {
        return view('max::index', $this->viewData());
    }

    public function viewData(): array
    {
        return [
            'requestDada' => $this->request->all(),
        ];
    }

    public function action(): JsonResponse
    {
        return response()->json([
            'status' => true,
        ]);
    }
}
