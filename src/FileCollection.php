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
        $this->archive = fopen($this->filePath,'w+');
        
    }
    
    /**
     * {@inheritDoc}
     */
    public function get(string $index, $defaultValue = null)
    {
        if (!$value = $this->has($index)) {
            return $defaultValue;
        }

        return $value;
    }

    /**
     * {@inheritDoc}
     */
    public function set(string $index, $value, int $time = 60)
    {
        $registerTime = time() + $time;

        $register = $index.'&'.$value.'&'.$registerTime.'/';

        fwrite($this->archive, $register);
    }

    /**
     * {@inheritDoc}
     */
    public function has(string $index)
    {
        $archive = explode('/', file_get_contents($this->filePath), -1);
        foreach ($archive as $data){
            $dataExploded = explode('&', $data);
            if ($dataExploded[0] == $index){
                if ($dataExploded[2] > time()){
                    return $dataExploded[1];
                } else {
                    return null;
                }
            }
        }
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

}