<?php

namespace App\Services\Max;

use Illuminate\Http\Request;
use Illuminate\View\View;
use VioletSun\MAX\Objects\Update;

class MaxAppService
{
    private Request $request;

    public function __construct() {}

    public function checkApp(Request $request): static
    {
        // check MAX server
        // else Error
        $this->request = $request;
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
}
