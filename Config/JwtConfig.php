<?php

namespace App\Config;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use DateTimeImmutable;

class JwtConfig
{
    private $config_path;

    public function __construct()
    {
        $this->config_path = require __DIR__ . '/config.php';
    }

    public function encode()
    {
        $secret_key = $this->config_path['jwt']['secret_key'];
        $secret = $this->config_path['jwt']['secret_key'];
        $issuedAt = new DateTimeImmutable();
        $expire     = $issuedAt->modify('+15 minutes')->getTimestamp();
        $server_name = 'localhost';
        $username =  'username';

        $data = [
            'iat' => $issuedAt->getTimestamp(),
            'iss' => $server_name,
            'nbf' => $issuedAt->getTimestamp(),
            'exp' => $expire,
            'username' => $username,
        ];
        $jwt = JWT::encode($data, $secret, 'HS512');
        return $jwt;
    }

    public function decode($jwt)
    {
        $secret_key  = $this->config_path['jwt']['secret_key'];
        $token = JWT::decode($jwt, new Key($secret_key, 'HS512'));
        $now = new DateTimeImmutable();
        $server_name = 'localhost';

        if ($token->iss !== $server_name || $token->nbf > $now->getTimestamp() || $token->exp < $now->getTimestamp()) { // validate token
            header('HTTP/1.1 401 Unauthorized');
            exit;
        }
    }
}
