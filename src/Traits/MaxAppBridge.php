<?php

namespace VioletSun\MAX\Traits;

use App\Models\Max\MaxUser;

trait MaxAppBridge
{
    private function initUserData(string $key, $default = null)
    {
        $request = $this->request ?? null;
        $initData = $request?->input('init_data', []) ?? [];
        if (is_string($initData)) {
            $initData = @json_decode($initData, true)   ;
        }
        return  $initData['user'][$key] ?? $default;
    }

    private function inputData(string $key, $default = null)
    {
        $request = $this->request ?? null;
        $data = $request?->input('data', []) ?? [];
        return  $data[$key] ?? $default;
    }

    public function maxUser(): ?MaxUser
    {
        if ($user_id = $this->initUserData('id')) {
            return MaxUser::query()->where('user_id', $user_id)->first();
        }
        return null;
    }
}
