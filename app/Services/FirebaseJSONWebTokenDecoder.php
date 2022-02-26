<?php


namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * Class FirebaseJSONWebTokenDecoder
 * @package App\Repository
 */
class FirebaseJSONWebTokenDecoder extends FirebaseJSONWebTokenHandler implements JSONWebTokenDecoderInterface
{
    /**
     * FirebaseJSONWebTokenDecoder constructor.
     * @param string $secretKey
     */
    public function __construct(string $secretKey)
    {
        parent::__construct($secretKey);
    }

    /**
     * @param string $jwtString
     * @return array
     */
    public function decode(string $jwtString): array
    {
        return (array)JWT::decode($jwtString, new Key($this->secretKey, $this->encryptionMethod));
    }

}