<?php

namespace App\Config;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use DateTimeImmutable;

class JwtConfig
{
    private static $instance;
    private $config_path;
    private $user_id;

    public function __construct()
    {
        $this->config_path = require __DIR__ . '/config.php';
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new JwtConfig();
        }
        return self::$instance;
    }

    public function encode($user_id)
    {
        $secret_key = $this->config_path['jwt']['secret_key'];
        $secret = $this->config_path['jwt']['secret_key'];
        $issuedAt = new DateTimeImmutable();
        $expire     = $issuedAt->modify('+15 minutes')->getTimestamp();
        $server_name = 'localhost';

        $data = [
            'iat' => $issuedAt->getTimestamp(),
            'iss' => $server_name,
            'nbf' => $issuedAt->getTimestamp(),
            'exp' => $expire,
            'user_id' => $user_id,
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

        if ($token->iss !== $server_name || $token->nbf > $now->getTimestamp() || $token->exp < $now->getTimestamp()) {
            header('HTTP/1.1 401 Unauthorized');
            exit;
        }

        $this->user_id = $token->user_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }
}
