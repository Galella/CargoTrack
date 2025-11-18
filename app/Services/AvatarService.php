<?php

namespace App\Services;

class AvatarService
{
    /**
     * Generate initials from name or email
     * 
     * @param string $nameOrEmail
     * @return string
     */
    public static function getInitials(string $nameOrEmail): string
    {
        // If it's an email, extract the name part before @
        if (strpos($nameOrEmail, '@') !== false) {
            $nameOrEmail = explode('@', $nameOrEmail)[0];
        }
        
        // Split by spaces or other common separators
        $words = preg_split('/[\s\-_]+/', trim($nameOrEmail));
        
        // Take first letter of first 2 words
        $initials = '';
        $count = 0;
        
        foreach ($words as $word) {
            if ($count >= 2) break;
            
            $firstChar = mb_substr(trim($word), 0, 1, 'UTF-8');
            if (!empty($firstChar)) {
                $initials .= mb_strtoupper($firstChar, 'UTF-8');
                $count++;
            }
        }
        
        // Fallback to single character if no initials could be extracted
        if (empty($initials) && !empty($nameOrEmail)) {
            $initials = mb_substr(trim($nameOrEmail), 0, 1, 'UTF-8');
            $initials = mb_strtoupper($initials, 'UTF-8');
        }
        
        return $initials ?: 'U'; // Default to 'U' for user
    }
    
    /**
     * Generate background color based on string hash
     * 
     * @param string $nameOrEmail
     * @return string
     */
    public static function getBackgroundColor(string $nameOrEmail): string
    {
        // Create a hash from the name to ensure consistent colors
        $hash = md5(strtolower(trim($nameOrEmail)));
        
        // Convert hash to HSL for more pleasant colors
        $hue = hexdec(substr($hash, 0, 2)) % 360;
        
        // Fixed saturation and lightness for consistent pleasant colors
        return "hsl({$hue}, 70%, 45%)";
    }
}