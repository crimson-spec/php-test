<?php

namespace Live\Collection;

/**
 * Memory collection
 *
 * @package Live\Collection
 */
class MemoryCollection implements CollectionInterface
{
    /**
     * Collection data
     *
     * @var array
     */
    protected $data;

    /**
     * Collection table
     *
     * @var array
     */
    protected $table;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->data = [];
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $index, $defaultValue = null)
    {
        if (!$this->has($index)) {
            return $defaultValue;
        }

        return $this->data[$index];
    }

    /**
     * {@inheritDoc}
     */
    public function set(string $index, $value, int $time = 60)
    {
        $registerTime = time() + $time;
        $this->table[$index] = $registerTime;
        $this->data[$index] = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function has(string $index)
    {
        if (array_key_exists($index, $this->data)){
            if ($this->table[$index] > time()){
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function count(): int
    {
        return count($this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function clean()
    {
        $this->data = [];
    }
}
