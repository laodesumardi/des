<?php

namespace App\Helpers;

class ImageHelper
{
    /**
     * Get the correct images directory path
     * Works for both local development and Hostinger hosting
     * All images are stored in public/images/
     * 
     * @return string Full filesystem path to images directory
     */
    public static function getImagesPath()
    {
        // Primary: Use Laravel's public_path
        $laravelPath = public_path('images');
        
        // Create if doesn't exist with proper permissions
        if (!is_dir($laravelPath)) {
            @mkdir($laravelPath, 0755, true);
        }
        
        return $laravelPath;
    }
    
    /**
     * Get safe image URL for shared hosting
     * Handles case sensitivity and ensures forward slashes for URLs
     * 
     * @param string $subfolder Subfolder (berita, galeri, umkm, etc.)
     * @param string $filename Filename stored in database
     * @param string|null $fallback Fallback image URL if not found
     * @return string Image URL
     */
    public static function getImageUrl($subfolder, $filename, $fallback = null)
    {
        if (empty($filename)) {
            return $fallback ?? asset('images/default-placeholder.png');
        }
        
        // Normalize subfolder (remove leading/trailing slashes)
        $subfolder = trim($subfolder, '/');
        
        // Build path - use forward slash for URL, but check filesystem with DIRECTORY_SEPARATOR
        $urlPath = 'images/' . ($subfolder ? $subfolder . '/' : '') . $filename;
        $filePath = public_path($urlPath);
        
        // Check if file exists (case-sensitive check for Linux hosting)
        if (file_exists($filePath)) {
            // Add cache buster if file exists
            $mtime = @filemtime($filePath);
            return asset($urlPath) . ($mtime ? '?v=' . $mtime : '');
        }
        
        // Try case-insensitive search (for Windows compatibility during development)
        if (self::findFileCaseInsensitive($filePath)) {
            $mtime = @filemtime($filePath);
            return asset($urlPath) . ($mtime ? '?v=' . $mtime : '');
        }
        
        return $fallback ?? asset('images/default-placeholder.png');
    }
    
    /**
     * Find file with case-insensitive search (for development on Windows)
     * 
     * @param string $filePath Full path to file
     * @return bool|string Returns file path if found, false otherwise
     */
    private static function findFileCaseInsensitive($filePath)
    {
        if (file_exists($filePath)) {
            return $filePath;
        }
        
        $directory = dirname($filePath);
        $filename = basename($filePath);
        
        if (!is_dir($directory)) {
            return false;
        }
        
        // Scan directory for case-insensitive match
        $files = @scandir($directory);
        if ($files === false) {
            return false;
        }
        
        foreach ($files as $file) {
            if (strcasecmp($file, $filename) === 0) {
                return $directory . DIRECTORY_SEPARATOR . $file;
            }
        }
        
        return false;
    }
    
    /**
     * Check if image file exists
     * 
     * @param string $subfolder Subfolder (berita, galeri, umkm, etc.)
     * @param string $filename Filename
     * @return bool
     */
    public static function imageFileExists($subfolder, $filename)
    {
        if (empty($filename)) {
            return false;
        }
        
        $subfolder = trim($subfolder, '/');
        $urlPath = 'images/' . ($subfolder ? $subfolder . '/' : '') . $filename;
        $filePath = public_path($urlPath);
        
        return file_exists($filePath);
    }
    
    /**
     * Find an image file with various extensions in public/images/
     * Returns the asset URL if found, or fallback if not
     * 
     * @deprecated Use getImageUrl() instead
     */
    public static function findImage($baseName, $fallback = null)
    {
        $extensions = ['png', 'jpg', 'jpeg', 'webp', 'gif'];
        $imagesPath = public_path('images');
        
        foreach ($extensions as $ext) {
            $filePath = $imagesPath . DIRECTORY_SEPARATOR . $baseName . '.' . $ext;
            if (file_exists($filePath)) {
                return asset('images/' . $baseName . '.' . $ext) . '?v=' . filemtime($filePath);
            }
        }
        
        return $fallback;
    }
    
    /**
     * Find image and return array with url, filename, and exists flag
     * Used for admin preview
     */
    public static function findImageInfo($baseName, $fallback = null)
    {
        $extensions = ['png', 'jpg', 'jpeg', 'webp', 'gif'];
        $imagesPath = public_path('images');
        
        foreach ($extensions as $ext) {
            $filePath = $imagesPath . DIRECTORY_SEPARATOR . $baseName . '.' . $ext;
            if (file_exists($filePath)) {
                return [
                    'url' => asset('images/' . $baseName . '.' . $ext) . '?v=' . filemtime($filePath),
                    'filename' => $baseName . '.' . $ext,
                    'exists' => true,
                    'path' => $filePath
                ];
            }
        }
        
        return [
            'url' => $fallback,
            'filename' => $baseName . '.jpg',
            'exists' => false,
            'path' => null
        ];
    }
    
    /**
     * Check if an image exists in public/images/
     * 
     * @deprecated Use imageFileExists() instead
     */
    public static function imageExists($baseName)
    {
        $extensions = ['png', 'jpg', 'jpeg', 'webp', 'gif'];
        $imagesPath = public_path('images');
        
        foreach ($extensions as $ext) {
            if (file_exists($imagesPath . DIRECTORY_SEPARATOR . $baseName . '.' . $ext)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Get full image path for a given basename
     */
    public static function getFullPath($filename)
    {
        return public_path('images' . DIRECTORY_SEPARATOR . $filename);
    }
    
    /**
     * Delete old images with same basename but different extensions
     */
    public static function deleteOldImages($baseName)
    {
        $extensions = ['png', 'jpg', 'jpeg', 'webp', 'gif'];
        $imagesPath = public_path('images');
        
        foreach ($extensions as $ext) {
            $filePath = $imagesPath . DIRECTORY_SEPARATOR . $baseName . '.' . $ext;
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
        }
    }
    
    /**
     * Ensure directory exists with proper permissions
     * 
     * @param string $subfolder Subfolder name (berita, galeri, umkm, etc.)
     * @return string Full path to subfolder
     */
    public static function ensureSubfolderExists($subfolder)
    {
        $subfolder = trim($subfolder, '/');
        $fullPath = public_path('images/' . $subfolder);
        
        if (!is_dir($fullPath)) {
            @mkdir($fullPath, 0755, true);
        }
        
        return $fullPath;
    }
}
