<?php

namespace FL\FacebookPagesBundle\Tests\Util\GettersSetters;

class TestTool
{
    /**
     * @var \SplObjectStorage
     */
    private $testItems;

    /**
     * @var string
     */
    private $latestError = '';

    public function __construct()
    {
        $this->testItems = new \SplObjectStorage();
    }

    /**
     * @param object $object
     * @throws \InvalidArgumentException
     *
     * @return bool
     */
    public function doGettersAndSettersWork($object): bool
    {
        if (!is_object($object)) {
            throw new \InvalidArgumentException();
        }

        /** @var TestItemImmutable $testItem */
        foreach ($this->testItems as $testItem) {
            call_user_func([$object, $testItem->getSetter()], $testItem->getValue());
            $setValueMatchesGetter = call_user_func([$object, $testItem->getGetter()]) === $testItem->getValue();
            if (! $setValueMatchesGetter) {
                $this->latestError = sprintf(
                    'A getter and setter pair, is not working. Object of class %s, getter of name %s, setter of name %s',
                    get_class($object),
                    $testItem->getGetter(),
                    $testItem->getSetter()
                );
                return false;
            }
        }
        return true;
    }

    /**
     * @return string
     */
    public function getLatestErrorMessage()
    {
        return $this->latestError;
    }

    /**
     * @param TestItemImmutable $testItem
     *
     * @return TestTool
     */
    public function addTestItem(TestItemImmutable $testItem): TestTool
    {
        if (!$this->containsSimilarTestItem($testItem)) {
            $this->testItems->attach($testItem);
        }

        return $this;
    }

    /**
     * @param TestItemImmutable $testItem
     *
     * @return TestTool
     */
    public function removeTestItem(TestItemImmutable $testItem): TestTool
    {
        foreach ($this->testItems as $similarItem) {
            // Do not change this to "===". Value object equality is asserted with "==".
            if ($testItem == $similarItem) {
                $this->testItems->detach($similarItem);
            }
        }
        return $this;
    }

    /**
     * @param TestItemImmutable $testItem
     * @return bool
     */
    private function containsSimilarTestItem(TestItemImmutable $testItem): bool
    {
        foreach ($this->testItems as $similarItem) {
            // Do not change this to "===". Value object equality is asserted with "==".
            if ($testItem == $similarItem) {
                return true;
            }
        }
        return false;
    }
}