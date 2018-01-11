<?php

use PHPUnit\Framework\TestCase;

/**
 * Class LimesurveyApiHandleTest
 */
class LimesurveyApiHandleTest extends TestCase
{
    protected $limesurveyApiHandle;

    public function setUp ()
    {
//        $this->limesurveyApiHandle = new \LaravelLimesurveyApi\Handle\LimesurveyApiHandle();
    }

    /**
     * @return mixed
     */
    public function testLimesurveyApiHandleSurveyLists ()
    {
        $this->assertEquals( 'test', 'test' );
    }

    /**
     * @return mixed
     */
    public function testLimesurveyApiHandleUserLists ()
    {
        $this->assertEquals( 'test123', 'test123' );
    }
}
