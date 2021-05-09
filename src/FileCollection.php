<?php
namespace Live\Collection;

/**
 * FileCollection
 * @package Live\Collection
 */
class FileCollection implements CollectionInterface
{
    /**
     * collection archive
     * @var string
     */
    protected $archive;

    /**
     * collection registerTime
     * @var int
     */
    protected $registerTime;

     /**
     * Constructor
     */
    public function __construct()
    {
        if (!file_exists('archive.txt')){
            $this->archive = fopen('archive.txt','w+');
            $this->archive = file_get_contents('archive.txt');
        }else{
            $this->archive = file_get_contents('archive.txt');
        }
        
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
    public function set(string $index, $value)
    {
        $this->data[$index] = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function has(string $index)
    {
        return array_key_exists($index, $this->data);
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