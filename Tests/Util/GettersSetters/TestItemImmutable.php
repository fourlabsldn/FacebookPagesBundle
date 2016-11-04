<?php

namespace FL\FacebookPagesBundle\Tests\Util\GettersSetters;

class TestItemImmutable{
    /**
     * @var string
     */
    private $getter;

    /**
     * @var string
     */
    private $setter;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @param string $getter
     * @param string $setter
     * @param $value
     */
    public function __construct(string $getter, string $setter, $value)
    {
        $this->getter = $getter;
        $this->setter = $setter;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getGetter(): string
    {
        return $this->getter;
    }

    /**
     * @return string
     */
    public function getSetter(): string
    {
        return $this->setter;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}