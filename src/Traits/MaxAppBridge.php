<?php

namespace VioletSun\MAX\Traits;

trait MaxAppBridge
{
    private function initUserData(string $key, $default = null)
    {
        $request = $this->request ?? null;
        $initData = $request?->input('init_data', []) ?? [];
        return  $initData['user'][$key] ?? $default;
    }

    private function inputData(string $key, $default = null)
    {
        $request = $this->request ?? null;
        $data = $request?->input('data', []) ?? [];
        return  $data[$key] ?? $default;
    }
}
