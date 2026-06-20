<?php

declare(strict_types=1);

namespace VioletSun\MAX\Objects\Attachment\Payloads;

use VioletSun\MAX\Objects\Common\User;
use VioletSun\MAX\Support\BaseObject;

/**
 * @property string $vcf_info
 * @property string $hash
 * @property User $max_info
 */
final class ContactPayload extends BaseObject
{
    public static function fromArray(array $data): static
    {
        return new self([
            'vcf_info' => $data['vcf_info'] ?? null,
            'hash' => $data['hash'] ?? null,
            'max_info' => isset($data['max_info']) ? User::fromArray($data['max_info']) : null,
        ]);
    }

    public function maxInfo()
    {
        return $this->get('max_info');
    }

    public function vcfInfo()
    {
        return $this->get('vcf_info');
    }
}
