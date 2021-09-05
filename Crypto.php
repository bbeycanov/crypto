<?php

class Crypto
{
    const SECRET_IV = 'aNdRgUkXn2r5u8x/A?D(G+KbPeShVmYq';
    const SECRET_KEY = 'z%C*F-J@NcRfUjXn2r5u8x/A?D(G+KbP';
    const ENCRYPT_METHOD = 'AES-256-CBC';

    /**
     * @var string $key
     */
    protected static string $key;

    /**
     * @var string $iv
     */
    protected static string $iv;

    /**
     * Crypto constructor.
     */
    public static function getInstance()
    {
        self::setIv();
        self::setKey();
    }

    /**
     * @param null $value
     * @return string
     */
    public static function encrypt($value = null): string
    {
        return base64_encode(openssl_encrypt($value,
            self::ENCRYPT_METHOD,
            self::getKey(),
            0,
            self::getIv()
        ));
    }

    /**
     * @param null $hash
     * @return false|string
     */
    public static function decrypt($hash = null)
    {
        return openssl_decrypt(
            base64_decode($hash),
            self::ENCRYPT_METHOD,
            self::getKey(),
            0, self::getIv()
        );
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return self::$key;
    }

    public static function setKey(): void
    {
        self::$key = hash('sha256', self::SECRET_KEY);
    }

    /**
     * @return string
     */
    public static function getIv(): string
    {
        return self::$iv;
    }

    public static function setIv(): void
    {
        self::$iv = substr(hash('sha256', self::SECRET_IV), 0, 16);
    }
}
