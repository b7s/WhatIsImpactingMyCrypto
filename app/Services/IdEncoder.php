<?php

declare(strict_types=1);

namespace App\Services;

class IdEncoder
{
    /**
     * Characters used for encoding (YouTube-style)
     * Contains 64 characters: uppercase/lowercase letters, numbers and some symbols
     */
    private const ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_';
    
    /**
     * Minimum length of the encoded string
     */
    private const MIN_LENGTH = 6;
    
    /**
     * Encode a numeric ID to a string
     *
     * @param int $id The ID to encode
     * @return string The encoded string
     */
    public static function encode(int $id): string
    {
        if ($id < 1) {
            throw new \InvalidArgumentException('ID must be a positive number');
        }
        
        // Add a small offset to make prediction harder
        $id = $id + 1000;
        
        $encoded = '';
        $base = strlen(self::ALPHABET);
        
        // Convert ID to base 64
        while ($id > 0) {
            $remainder = $id % $base;
            $encoded = self::ALPHABET[$remainder] . $encoded;
            $id = intdiv($id, $base);
        }
        
        // Ensure a minimum length for the string
        while (strlen($encoded) < self::MIN_LENGTH) {
            $encoded = self::ALPHABET[0] . $encoded;
        }
        
        // Shuffle the string to make it less predictable
        return self::shuffle($encoded);
    }
    
    /**
     * Decode a string to a numeric ID
     *
     * @param string $encoded The encoded string
     * @return int The decoded ID
     */
    public static function decode(string $encoded): int
    {
        // Restore the original order
        $encoded = self::unshuffle($encoded);
        
        $base = strlen(self::ALPHABET);
        $id = 0;
        
        // Remove leading zeros
        $encoded = ltrim($encoded, self::ALPHABET[0]);
        
        // Convert from base 64 to decimal
        for ($i = 0; $i < strlen($encoded); $i++) {
            $char = $encoded[$i];
            $position = strpos(self::ALPHABET, $char);
            
            if ($position === false) {
                throw new \InvalidArgumentException("Invalid character in string: $char");
            }
            
            $id = $id * $base + $position;
        }
        
        // Remove the offset
        return $id - 1000;
    }
    
    /**
     * Shuffle a string deterministically (always the same way for the same input)
     *
     * @param string $input The string to shuffle
     * @return string The shuffled string
     */
    private static function shuffle(string $input): string
    {
        $length = strlen($input);
        $output = str_repeat(' ', $length);
        
        for ($i = 0; $i < $length; $i++) {
            $position = ($i * 7) % $length; // Prime multiplier for better distribution
            $output[$position] = $input[$i];
        }
        
        return $output;
    }
    
    /**
     * Reverse the shuffling applied by the shuffle function
     *
     * @param string $input The shuffled string
     * @return string The original string
     */
    private static function unshuffle(string $input): string
    {
        $length = strlen($input);
        $output = str_repeat(' ', $length);
        
        for ($i = 0; $i < $length; $i++) {
            $position = ($i * 7) % $length; // Same prime multiplier used in shuffle
            $output[$i] = $input[$position];
        }
        
        return $output;
    }
} 