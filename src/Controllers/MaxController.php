<?php

namespace VioletSun\MAX\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use VioletSun\MAX\Objects\Update;
use App\Services\Max\MaxAppService;
use App\Services\Max\MaxService;

class MaxController extends Controller
{
    public function webhook(Request $request, MaxService $maxService): JsonResponse
    {
        return $maxService
            ->setRequest($request)
            ->checkWebhook()
            ->handle();
    }

    public function index(Request $request, MaxAppService $maxAppService): View
    {
        return $maxAppService
            ->setRequest($request)
            ->checkApp()
            ->view();
    }

    public function action(Request $request, MaxAppService $maxAppService): JsonResponse
    {
        return $maxAppService
            ->setRequest($request)
            ->action();
    }
}
