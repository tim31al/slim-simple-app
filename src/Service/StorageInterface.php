<?php

namespace App\Service;

interface StorageInterface
{
    /**
     * Returns true if and only if storage is empty
     *
     * @return bool
     */
    public function isEmpty();

    /**
     * Returns the contents of storage
     * @param string|null $key
     */
    public function read($key = null);

    /**
     * Writes $contents to storage
     *
     * @param $key
     * @param $value
     */
    public function write($key, $value);

    /**
     * Clears contents from storage
     *
     */
    public function clear();
}
