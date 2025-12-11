<?php

namespace App\Services;

use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;

class TwilioVideoService
{
    protected string $accountSid;
    protected string $apiKey;
    protected string $apiSecret;
    protected int $ttl;

    public function __construct()
    {
        $this->accountSid = getenv('TWILIO_ACCOUNT_SID') ?: '';
        $this->apiKey     = getenv('TWILIO_API_KEY') ?: '';
        $this->apiSecret  = getenv('TWILIO_API_SECRET') ?: '';
        $this->ttl        = 3600; // 1 hora
    }

    /**
     * Gera um JWT (Access Token) para Twilio Video.
     *
     * @param string $identity Nome/ID do utilizador (único)
     * @param string|null $room Nome da sala (se null, token é global)
     * @return string JWT
     */
    public function generateToken(string $identity, ?string $room = null): string
    {
        $token = new AccessToken(
            $this->accountSid,
            $this->apiKey,
            $this->apiSecret,
            $this->ttl,
            $identity
        );

        $videoGrant = new VideoGrant();
        if ($room) {
            $videoGrant->setRoom($room);
        }

        $token->addGrant($videoGrant);

        return $token->toJWT();
    }
}