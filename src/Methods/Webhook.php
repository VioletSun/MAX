<?php

declare(strict_types=1);

namespace VioletSun\MAX\Methods;

use VioletSun\MAX\Client;
use VioletSun\MAX\Facades\MAX;
use VioletSun\MAX\Objects\AbstractObject;
use VioletSun\MAX\Objects\Subscription;

/**
 * Class Get.
 *
 * @mixin Client
 */
trait Webhook
{
    /**
     * Receive all subscriptions via Webhook
     *
     * @return AbstractObject<Subscription>
     *
     * @link https://dev.max.ru/docs-api/methods/GET/subscriptions
     */
    public function subscriptions(): AbstractObject
    {
        $response = AbstractObject::fromArray($this->client->get("subscriptions"));
        $subscriptions = [];
        foreach ($response->subscriptions ?? [] as $subscription) {
            $subscriptions[] = Subscription::fromArray($subscription);
        }
        return AbstractObject::fromArray($subscriptions);
    }

    /**
     * Subscribe to updates about new events via Webhook
     *
     * @param string $url
     * @param array|null $update_types - UpdateTypeEnum[]
     * @param string|null $secret
     * @return AbstractObject
     *
     * @link https://dev.max.ru/docs-api/methods/POST/subscriptions
     */
    public function subscriptionSet(string $url, ?array $update_types = null, ?string $secret = null): AbstractObject
    {
        $data = [];
        if (str_starts_with($url, "http://")) {
            $url = str_replace("http://", "https://", $url);
        } elseif (!str_starts_with($url, "https://")) {
            $url = "https://" . $url;
        }
        $data['url'] = $url;

        if (!empty($update_types)) {
            $data['update_types'] = $update_types;
        }

        if (!empty($secret)) {
            $data['secret'] = $secret;
        }

        return AbstractObject::fromArray($this->client->post("subscriptions", $data));
    }

    /**
     * Subscribe to updates about new events via Webhook from Settings
     *
     * @link https://dev.max.ru/docs-api/methods/POST/subscriptions
     */
    public function subscriptionInitSetting(): AbstractObject
    {
        $config = app()['config']['max']['webhook'];
        $url = $config['url'] ?? null;
        // if (empty($url)) {
        // TODO: $url = route('api.max.webhook');
        // } else
        if (str_starts_with($url, "http://")) {
            $url = str_replace("http://", "https://", $url);
        } elseif (!str_starts_with($url, "https://")) {
            $url = "https://" . $url;
        }

        $update_types = $config['update_types'] ?? null;
        if (!empty($update_types)) {
            $update_types = explode(',', $update_types);
        }

        $secret = $config['secret'] ?? null;
        return MAX::subscriptionSet($url, $update_types, $secret);
    }

    /**
     * Unsubscribing from updates about new events via Webhook
     *
     * @param string|null $url
     * @return AbstractObject
     *
     * @link https://dev.max.ru/docs-api/methods/DELETE/subscriptions
     */
    public function subscriptionDelete(?string $url): AbstractObject
    {
        return AbstractObject::fromArray($this->client->delete("subscriptions", ['url' => $url]));
    }
}
