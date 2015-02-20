<?php
namespace www\lescariatides\classes;

/**
 * Class Metas
 * @package classes
 */
class Metas implements \Iterator{

    /**
     * @var array
     */
    private $bag;

    /**
     * @var int
     */
    private $position;

    public function __construct()
    {
        $this->position = 0;
        $jsonParameters = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'parameters.json');
        $parameters = json_decode($jsonParameters);
        $this->bag = $parameters->metas;
    }

    /**
     * toArray
     *
     * @param $meta
     *
     * @return array
     */
    private function toArray($meta)
    {
        $output = array();
        foreach ($meta as $name => $value) {
            $output[$name] = $value;
        }

        return $output;
    }

    /**
     * getBag
     *
     *
     * @return array
     */
    public function getBag()
    {
        return $this->bag;
    }

    /**
     * getBagAsArray
     *
     *
     * @return array
     */
    public function getBagAsArray()
    {
        $output = array();
        $this->rewind();
        while($this->valid()) {
            array_push($output, $this->toArray($this->current()));
            $this->next();
        }

        return $output;
    }

    /**
     * getMetaAsHtml
     *
     *
     * @return string
     */
    public function getMetaAsHtml()
    {
        $output = "";
        $this->rewind();
        while($this->valid()) {
            $output .= "<meta ";
            foreach ($this->current() as $name => $value) {
                $output .= $name.' = "'.$value.'"';
            }
            $output .= " >";
            $this->next();
        }

        return $output;
    }

    /**
     * {@inheritdoc }
     */
    public function current()
    {
        return current($this->bag);
    }

    /**
     * {@inheritdoc }
     */
    public function next()
    {
        ++$this->position;
        next($this->bag);
    }

    /**
     * {@inheritdoc }
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * {@inheritdoc }
     */
    public function valid()
    {
        return isset($this->bag[$this->position]);
    }

    /**
     * {@inheritdoc }
     */
    public function rewind()
    {
        $this->position = 0;
        reset($this->bag);
    }
}
