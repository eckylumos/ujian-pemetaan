<?php

class LRUCache {
    private $capacity;
    private $cache = [];
    private $order = [];

    public function __construct($capacity) {
        $this->capacity = $capacity;
    }

    public function get($key) {
        if (!array_key_exists($key, $this->cache)) {
            return -1;
        }
        // Pindahkan key ke posisi terakhir (terbaru)
        $this->moveToRecent($key);
        return $this->cache[$key];
    }

    public function put($key, $value) {
        if (array_key_exists($key, $this->cache)) {
            $this->cache[$key] = $value;
            $this->moveToRecent($key);
        } else {
            if (count($this->cache) >= $this->capacity) {
                // Hapus key tertua
                $oldestKey = array_shift($this->order);
                unset($this->cache[$oldestKey]);
            }
            $this->cache[$key] = $value;
            $this->order[] = $key;
        }
    }

    private function moveToRecent($key) {
        $pos = array_search($key, $this->order);
        if ($pos !== false) {
            unset($this->order[$pos]);
        }
        $this->order[] = $key;
        $this->order = array_values($this->order); // reset index array
    }
}

// --- CONTOH PENGGUNAAN ---
$cache = new LRUCache(2);

$cache->put(1, 1); // null
$cache->put(2, 2); // null
var_dump($cache->get(1)); // int(1)
$cache->put(3, 3); // null (evict key 2)
var_dump($cache->get(2)); // int(-1)
$cache->put(4, 4); // null (evict key 1)
var_dump($cache->get(1)); // int(-1)
var_dump($cache->get(3)); // int(3)
var_dump($cache->get(4)); // int(4)
