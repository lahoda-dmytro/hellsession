<?php

namespace classes;

class Cache {
    private static ?Cache $instance = null;
    private string $cacheDir;
    private int $defaultTtl;

    private function __construct() {
        $this->cacheDir = __DIR__ . '/../cache/';
        $this->defaultTtl = 3600;
        
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0777, true);
        }
    }

    public static function getInstance(): Cache {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function get(string $key) {
        $filename = $this->getCacheFilename($key);
        if (!file_exists($filename)) {
            return null;
        }

        $data = file_get_contents($filename);
        $cache = unserialize($data);

        if ($cache['expires'] < time()) {
            unlink($filename);
            return null;
        }

        return $cache['data'];
    }

    public function set(string $key, $value, ?int $ttl = null): void {
        $filename = $this->getCacheFilename($key);
        $ttl = $ttl ?? $this->defaultTtl;

        $cache = [
            'data' => $value,
            'expires' => time() + $ttl
        ];

        file_put_contents($filename, serialize($cache));
    }

    public function delete(string $key): void {
        $filename = $this->getCacheFilename($key);
        if (file_exists($filename)) {
            unlink($filename);
        }
    }

    public function clear(): void {
        $files = glob($this->cacheDir . '*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    private function getCacheFilename(string $key): string {
        return $this->cacheDir . md5($key) . '.cache';
    }
} 