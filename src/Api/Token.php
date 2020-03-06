<?php

namespace Sharetribe\Sdk\Api;

class Token
{

    protected $accessToken;

    protected $tokenType;

    protected $expiresIn;

    protected $scope;

    protected $refreshToken;

    protected $expire;

    public function __construct($array)
    {
        $this->accessToken = $array['access_token'];
        $this->tokenType = $array['token_type'];
        $this->expiresIn = $array['expires_in'];
        $this->scope = $array['scope'];
        $this->refreshToken = $array['refresh_token'];
        $this->expire = time() + $this->expiresIn;
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function getTokenType()
    {
        return $this->tokenType;
    }

    public function getExpiresIn()
    {
        return $this->expiresIn;
    }

    public function getScope()
    {
        return $this->scope;
    }

    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    public function isExpire()
    {
        return (time() > $this->expire);
    }
}
