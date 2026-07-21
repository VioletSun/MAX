<?php

declare(strict_types=1);

namespace App\Services\Max;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MaxAppService
{
    private Request $request;

    public function __construct() {}

    public function setRequest(Request $request): static
    {
        $this->request = $request;
        return $this;
    }

    public function view(?string $view_path = 'max::index', ?array $data = []): View
    {
        return view($view_path, $this->viewData($data));
    }

    public function viewData(?array $data = []): array
    {
        return [
            'requestDada' => $this->request->all(),
            'data' => $data,
        ];
    }

    public function checkAppToken(): bool
    {

    }

    public function action(): JsonResponse
    {
        if ($this->checkAppToken()) {
            return response()->json([
                'status' => true,
                'body' => '',
            ]);
        }
        return response()->json([
            'status' => false,
            'body' => '',
        ]);
    }
}
