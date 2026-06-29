<?php

namespace VioletSun\MAX\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use VioletSun\MAX\Objects\Update;
use VioletSun\MAX\Services\MaxAppService;
use VioletSun\MAX\Services\MaxService;

class MaxController extends Controller
{
    public function webhook(Request $request, MaxService $maxService): JsonResponse
    {
        $maxService
            ->checkWebhook($request)
            ->setUpdate(Update::fromArray($request->all()))
            ->handle();
        return response()->json(['status' => true]);
    }

    public function index(Request $request, MaxAppService $maxAppService): View
    {
        return view('max::index');
    }

    public function action(Request $request, MaxAppService $maxAppService)
    {
        //
    }
}
