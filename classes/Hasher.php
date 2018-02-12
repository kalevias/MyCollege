<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/6/2018
 * Time: 3:06 PM
 */

class Hasher
{

    /**
     * Generates a new salted hash for a given string.
     *
     * @param string $password
     * @return string[]
     */
    public static function cryptographicHash(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Generates a new random hash based on SHA-256.
     *
     * @return string
     */
    public static function randomHash(): string
    {
        return hash("sha256", self::randomSalt());
    }

    /**
     * Generates a new random salt based on a cryptographically securely generated random string of bytes.
     *
     * @return string
     */
    public static function randomSalt(): string
    {
        try {
            return random_bytes(16);
        } catch (Exception $e) {
            return substr(hash("sha256", rand()), 0, 16);
        }
    }

    /**
     * Verifies that a salted $string is equivalent to $hash.
     *
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public static function verifyCryptographicHash(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    /**
     * Verifies that $string hashed is equivalent to $hash via the SHA256 hashing algorithm.
     *
     * @param string $string
     * @param string $hash
     * @return bool
     */
    public static function verifyHash(string $string, string $hash): bool
    {
        return hash("sha256", $string) == $hash;
    }
}