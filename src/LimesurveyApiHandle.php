<?php

namespace LaravelLimesurveyApi\Handle;

use org\jsonrpcphp\JsonRPCClient;

/**
 * Class LimesurveyApiHandle
 *
 * @package LaravelLimesurveyApi\Handle
 */
class LimesurveyApiHandle
{
    protected $jsonRPCClient;

    protected $session_key;

    /**
     * LimesurveyApiHandle constructor.
     */
    public function __construct ()
    {
        $this->get_jsonRPCClient();

        $this->get_session_key();
    }

    private function get_jsonRPCClient ()
    {
        $this->jsonRPCClient = new JsonRPCClient( config( 'jsonRPC.url' ) );
    }

    private function get_session_key ()
    {
        $this->session_key = $this->jsonRPCClient->get_session_key( config( 'jsonRPC.username' ), config( 'jsonRPC.password' ) );
    }

    /**
     * 获取所有问卷列表
     *
     * @return mixed
     */
    public function list_surveys ()
    {
        return $this->jsonRPCClient->list_surveys( $this->session_key );
    }

    /**
     * 获取所有用户列表
     *
     * @return mixed
     */
    public function list_users ()
    {
        return $this->jsonRPCClient->list_users( $this->session_key );
    }
}
