<?php

declare(strict_types = 1);

namespace ThinkOut\Response;

class SignInData implements ResponseInterface, \Serializable
{
    private string $userId;
    private string $token;
    private string $refreshToken;

    public function __construct(string $userId, string $token, string $refreshToken)
    {
        $this->userId = $userId;
        $this->token = $token;
        $this->refreshToken = $refreshToken;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    /**
     * @return array{userId: string, token: string, refreshToken: string}
     */
    public function __serialize(): array
    {
        return [
            'userId' => $this->userId,
            'token' => $this->token,
            'refreshToken' => $this->refreshToken,
        ];
    }

    /**
     * @param array{userId: string, token: string, refreshToken: string} $data
     */
    public function __unserialize(array $data): void
    {
        $this->userId = $data['userId'];
        $this->token = $data['token'];
        $this->refreshToken = $data['refreshToken'];
    }

    public function serialize(): string
    {
        return serialize($this);
    }

    /**
     * @param string $data
     */
    public function unserialize($data): void
    {
        unserialize($data, ['allowed_classes' => [\get_class($this)]]);
    }
}
