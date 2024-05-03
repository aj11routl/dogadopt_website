<?php
require_once PROJECT_ROOT_PATH . "JWT.php";
use \Firebase\JWT\JWT;

class BaseController
{
    /*
    create new jwt token
    */
    public function generateToken($userId) {
        try {
            $payload = [
                'iat' => time(),
                'iss' => 'localhost',
                'exp' => time() + (15*60),
                'userId' => $userId
            ];

            $token = JWT::encode($payload, SECRET_KEY, 'HS256');
            
            return $token;
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
* __call magic method.
*/

    public function __call($name, $arguments)
    {
        $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
    }

/**
* Get URI elements.
*
* @return array
*/
    
    protected function getUriSegments()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode( '/', $uri );
        return $uri;
    }

/**
* Get querystring params.
*
* @return array
*/
    protected function getQueryStringParams()
    {
        $query = [];
        parse_str($_SERVER['QUERY_STRING'], $query);
        return $query;
    }
    
/**
* Send API output.
*
* @param mixed $data
* @param string $httpHeader
*/  
    protected function sendOutput($data, $httpHeaders=array())
    {
        header_remove('Set-Cookie');
        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }
        echo $data;
        exit;
    }
}