<?php


namespace Github\Application;


use Github\Domain\Repository\UserRepository;

/**
 * Class UserAuthenticationAwareHandler
 * @package Github\Application
 */
abstract class UserAuthenticationAwareHandler
{

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var UserPasswordEncryptionServiceInterface
     */
    protected $passwordEncryptionService;

    /**
     * UserAuthenticationAwareHandler constructor.
     * @param UserRepository $userRepository
     * @param UserPasswordEncryptionServiceInterface $passwordEncryptionService
     */
    public function __construct(
        UserRepository $userRepository,
        UserPasswordEncryptionServiceInterface $passwordEncryptionService
    )
    {
        $this->userRepository = $userRepository;
        $this->passwordEncryptionService = $passwordEncryptionService;
    }
}