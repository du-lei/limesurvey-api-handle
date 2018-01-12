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
        $url = 'http://test.bbooks.org/index.php?r=admin/remotecontrol';
        $username = 'admin';
        $password = 'admin888';

        $this->limesurveyApiHandle = new \LaravelLimesurveyApi\Handle\LimesurveyApiHandle( $url, $username, $password );
    }

    /**
     * @return mixed
     */
    public function testLimesurveyApiHandleSurveyLists ()
    {
        $list_surveys = $this->limesurveyApiHandle->list_surveys();
        $status = false;

        if ( $list_surveys )
            $status = true;

        $this->assertTrue( $status );
    }

    /**
     * @return mixed
     */
    public function testLimesurveyApiHandleUserLists ()
    {
        $list_users = $this->limesurveyApiHandle->list_users();
        $status = false;

        if ( $list_users )
            $status = true;

        $this->assertTrue( $status );
    }
}
