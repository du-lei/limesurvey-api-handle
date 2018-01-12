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
    protected $url;

    protected $username;

    protected $password;

    protected $jsonRPCClient;

    protected $session_key;

    /**
     * LimesurveyApiHandle constructor.
     *
     * @param $url
     * @param $username
     * @param $password
     */
    public function __construct ( $url, $username, $password )
    {
        $this->url = $url;

        $this->username = $username;

        $this->password = $password;

        $this->get_jsonRPCClient();

        $this->get_session_key();
    }

    private function get_jsonRPCClient ()
    {
        $this->jsonRPCClient = new JsonRPCClient( $this->url );
    }

    private function get_session_key ()
    {
        $this->session_key = $this->jsonRPCClient->get_session_key( $this->username, $this->password );
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
