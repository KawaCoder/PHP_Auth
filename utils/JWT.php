<?php
namespace App\Utils;

require_once __DIR__ . '/../config/env.php';

class JWT
{
    private static $secret = JWT_SECRET;

    /**
     * Génère un JWT
     */
    public static function encode(array $payload, int $expirationSeconds = 3600): string
    {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload['iat'] = time();
        $payload['exp'] = time() + $expirationSeconds;
        $payloadJson = json_encode($payload);

        $base64UrlHeader = self::base64UrlEncode($header);
        $base64UrlPayload = self::base64UrlEncode($payloadJson);

        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, self::$secret, true);
        $base64UrlSignature = self::base64UrlEncode($signature);

        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }

    /**
     * Valide et décode un JWT. Retourne le payload si valide, false sinon.
     */
    public static function decode(string $jwt)
    {
        $parts = explode('.', $jwt);
        if (count($parts) !== 3) {
            return false;
        }

        list($header, $payload, $signatureInfo) = $parts;

        // Recalculer la signature
        $validSignature = hash_hmac('sha256', $header . "." . $payload, self::$secret, true);
        $validBase64UrlSignature = self::base64UrlEncode($validSignature);

        // Vérifier si la signature correspond
        if (!hash_equals($validBase64UrlSignature, $signatureInfo)) {
            return false; // Signature invalide
        }

        $decodedPayload = json_decode(self::base64UrlDecode($payload), true);

        // Vérifier l'expiration
        if (isset($decodedPayload['exp']) && time() > $decodedPayload['exp']) {
            return false; // Token expiré
        }

        return $decodedPayload;
    }

    private static function base64UrlEncode(string $data): string
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }

    private static function base64UrlDecode(string $data): string
    {
        $remainder = strlen($data) % 4;
        if ($remainder) {
            $data .= str_repeat('=', 4 - $remainder);
        }
        return base64_decode(str_replace(['-', '_'], ['+', '/'], $data));
    }
}
?>
