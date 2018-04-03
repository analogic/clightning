<?php

namespace CLightning;

use Symfony\Component\Serializer\Encoder\JsonEncoder;

class JsonRPCEncoder extends JsonEncoder
{
    public function decode($data, $format, array $context = array())
    {
        $result = parent::decode($data, $format, $context);

        if (isset($result['error'])) {
            throw new \RuntimeException(json_encode($result['error']));
        }

        return $result['result'];
    }
}