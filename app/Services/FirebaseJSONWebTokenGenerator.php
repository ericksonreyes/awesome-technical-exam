<?php


namespace App\Services;

use Firebase\JWT\JWT;

/**
 * Class FirebaseJSONWebTokenGenerator
 * @package App\Repository
 */
class FirebaseJSONWebTokenGenerator extends FirebaseJSONWebTokenHandler implements JSONWebTokenGeneratorInterface
{
    /**
     * FirebaseJSONWebTokenGenerator constructor.
     * @param string $secretKey
     */
    public function __construct(string $secretKey)
    {
        parent::__construct($secretKey);
    }

    /**
     * @param array $payload
     * @return string
     */
    public function generate(array $payload): string
    {
        return JWT::encode($payload, $this->secretKey, $this->encryptionMethod);
    }


}