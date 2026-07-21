<?php

declare(strict_types=1);

namespace VioletSun\MAX\Methods;

use VioletSun\MAX\Client;
use VioletSun\MAX\Enums\UploadTypeEnum;
use VioletSun\MAX\Exceptions\MessageException;
use VioletSun\MAX\Objects\AbstractObject;
use VioletSun\MAX\Objects\FileUploads;

/**
 * Class Get.
 *
 * @mixin Client
 */
trait Uploads
{
    /**
     * Getting download link
     *
     * @param UploadTypeEnum $type
     * @param string $store
     * @return AbstractObject
     *
     * @throws MessageException
     * @link https://dev.max.ru/docs-api/methods/POST/uploads
     */
    public function uploads(UploadTypeEnum $type, string $store): AbstractObject
    {
        $response_uploads = AbstractObject::fromArray($this->client->post("uploads", [], ['type' => $type->value]));
        if ($response_uploads->url) {
            $parse = parse_url($response_uploads->url);
            parse_str($parse['query'], $query);
            $path = 'https://' . $parse['host'] . $parse['path'];
            $response = FileUploads::fromArray($this->client->multipart(
                uri: $path,
                query: $query,
                multipart: [
                    [
                        'name'     => basename($store),
                        'contents' => fopen($store, 'r'),
                    ]
                ]
            ));
            if ($response->token) {
                return AbstractObject::fromArray(['token' => $response->token]);
            }
            throw MessageException::uploads(AbstractObject::fromArray($response->toArray()));
        }
        throw MessageException::uploads($response_uploads);
    }
}
