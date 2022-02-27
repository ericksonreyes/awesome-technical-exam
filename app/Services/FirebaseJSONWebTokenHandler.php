<?php


namespace App\Services;

/**
 * Class FirebaseJSONWebTokenHandler
 * @package App\Repository
 */
abstract class FirebaseJSONWebTokenHandler
{
    /**
     * @var string
     */
    protected $secretKey;

    /**
     * @var string
     */
    protected $encryptionMethod = 'HS256';


    /**
     * FirebaseJSONWebTokenHandler constructor.
     * @param string $secretKey
     */
    public function __construct(string $secretKey)
    {
        $this->secretKey = trim($secretKey);
    }

    /**
     * @param string $encryptionMethod
     * @return FirebaseJSONWebTokenHandler
     */
    public function setEncryptionMethod(string $encryptionMethod): FirebaseJSONWebTokenHandler
    {
        $this->encryptionMethod = $encryptionMethod;
        return $this;
    }
}