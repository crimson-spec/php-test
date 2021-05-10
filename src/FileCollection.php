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
     * collection filePath
     * @var string
     */
    protected $filePath = 'archive.txt';

     /**
     * Constructor
     */
    public function __construct()
    {
        $this->archive = fopen($this->filePath, 'w+');
    }
    
    /**
     * {@inheritDoc}
     */
    public function get(string $index, $defaultValue = null)
    {
        if (!$this->has($index)) {
            return $defaultValue;
        }
        $value = $this->explodeAndFindStringByIndex($index);

        return $value[1];
    }

    /**
     * {@inheritDoc}
     */
    public function set(string $index, $value, int $time = 60)
    {
        if (is_array($value)) {
            $value = implode($value) ;
        }

        $registerTime = time() + $time;

        $register = $index.'&'.$value.'&'.$registerTime.'/';

        fwrite($this->archive, $register);
    }

    /**
     * {@inheritDoc}
     */
    public function has(string $index)
    {
        if ($dataExploded = $this->explodeAndFindStringByIndex($index)) {
            if ($dataExploded[2] > time()) {
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
        $archive = explode('/', file_get_contents($this->filePath), -1);

        return count($archive);
    }

    /**
     * {@inheritDoc}
     */
    public function clean()
    {
        fopen($this->filePath, 'w+');
    }

    /**
     * method explode the content from archive and return data by index
     * @return string|false
     */
    protected function explodeAndFindStringByIndex(string $index)
    {
        $archive = explode('/', file_get_contents($this->filePath), -1);
        foreach ($archive as $data) {
            $dataExploded = explode('&', $data) ;
            if ($dataExploded[0] == $index) {
                return $dataExploded;
            }
        }

        return false;
    }
}
