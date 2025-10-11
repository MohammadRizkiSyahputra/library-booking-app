<?php

namespace App\Core\Services;

class CacheService
{
    private static ?\Redis $redis = null;

    private static function getRedis(): ?\Redis
    {
        if (self::$redis === null && extension_loaded('redis')) {
            try {
                self::$redis = new \Redis();
                self::$redis->connect('127.0.0.1', 6379);
            } catch (\Exception $e) {
                self::$redis = false;
            }
        }
        return self::$redis ?: null;
    }

    public static function set(string $key, mixed $value, int $ttl = 900): bool
    {
        $redis = self::getRedis();
        if ($redis) {
            return $redis->setex($key, $ttl, serialize($value));
        }

        $dir = \App\Core\App::$ROOT_DIR . '/storage/cache';
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }
        $file = $dir . '/' . md5($key) . '.cache';
        $data = ['value' => $value, 'expires' => time() + $ttl];
        return file_put_contents($file, serialize($data)) !== false;
    }

    public static function get(string $key): mixed
    {
        $redis = self::getRedis();
        if ($redis) {
            $value = $redis->get($key);
            return $value !== false ? unserialize($value) : null;
        }

        $dir = \App\Core\App::$ROOT_DIR . '/storage/cache';
        $file = $dir . '/' . md5($key) . '.cache';
        
        if (!file_exists($file)) {
            return null;
        }

        $data = unserialize(file_get_contents($file));
        
        if ($data['expires'] < time()) {
            unlink($file);
            return null;
        }

        return $data['value'];
    }

    public static function delete(string $key): bool
    {
        $redis = self::getRedis();
        if ($redis) {
            return $redis->del($key) > 0;
        }

        $dir = \App\Core\App::$ROOT_DIR . '/storage/cache';
        $file = $dir . '/' . md5($key) . '.cache';
        if (file_exists($file)) {
            return unlink($file);
        }
        return true;
    }

    public static function clear(): void
    {
        $redis = self::getRedis();
        if ($redis) {
            $redis->flushDB();
            return;
        }

        $dir = \App\Core\App::$ROOT_DIR . '/storage/cache';
        $files = glob($dir . '/*.cache');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
}
