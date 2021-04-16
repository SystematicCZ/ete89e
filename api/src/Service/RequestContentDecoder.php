<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

class RequestContentDecoder
{
    public function decodeIfJson(Request $request): array
    {
        $value = $request->getContent();

        if (is_string($value)) {
            try {
                return json_decode($value, true, 512, JSON_THROW_ON_ERROR);
            } catch (\JsonException $e) {
                throw new \Exception('No JSON content');
            }
        }

        throw new \Exception('No JSON content');
    }
}
