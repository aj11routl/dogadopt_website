<?php
require_once "./constants.php";
use \Firebase\JWT\JWT;

class MainController extends BaseController
{
    // validate token parameter against current timestamp
    public function userVerifyTokenAction()
    {
        $strErrorDesc = '';
        $strErrorHeader = null;
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        
        # get passed token
        $current_token = $arrQueryStringParams['token'];
        try {
            # check if passed token is expired
            $token_valid = $this->verifyToken($current_token);
        } catch (Error $e) {
            $strErrorDesc = $e->getMessage(). MESSAGE_SORRY;
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        }
        
        if (!$strErrorDesc) {
            $this->sendOutput(json_encode(array('valid' => $token_valid)),
                              array('Content-Type: application/json',  'HTTP/1.1 200 OK'));
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
    // login endpoint - take username and password, return jwt token
    public function userLoginAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        $user = '';
        
        if (strtoupper($requestMethod) == 'POST') {
            try {
                $mainModel = new MainModel();
                $email = "";
                $password = "";
                if (isset($arrQueryStringParams['email']) && $arrQueryStringParams['email'] && isset($arrQueryStringParams['password']) && $arrQueryStringParams['password']) {
                    $email = $arrQueryStringParams['email'];
                    $password = $arrQueryStringParams['password'];
                    
                    $user = $mainModel->getUserByEmail($email);
                    
                    if (!$user) {
                        $strErrorDesc = 'User with email not found';
                        $strErrorHeader = 'HTTP/1.1 404 Not found';
                        $errorCode = CODE_NOT_FOUND;
                    } else {
                        #check password matches 
                        
                        # there should never be more than one user with the same email.
                        # registration should not allow it.
                        $user = $user[0];
                        # validate password against hashed password from database
                        # ''' !!! REMOVE PART OF THIS IF STATEMENT WHEN REGISTER IS MADE WITH HASHING !!! '''
                        if (password_verify($password, $user['password']) != true and $password != $user['password']) {
                            $strErrorDesc = DESC_INCORRECT_PASSWORD;
                            $strErrorHeader = 'HTTP/1.1 401 Unauthorized';
                            $errorCode = CODE_UNAUTHORIZED;
                        } else {
                            # call generate token function
                            $userId = $user['user_id'];
                            $token = $this->generateToken($userId);
                            if ($token == null) {
                                $strErrorDesc = $e->getMessage(). MESSAGE_SORRY;
                                $errorCode = CODE_INTERNAL_ERROR;
                            } 
                        }
                    }
                } else {
                    $strErrorDesc = 'Parameters not supported';
                    $strErrorHeader = 'HTTP/1.1 422 Unprocessable entity';
                    $errorCode = CODE_UNPROCESSABLE_ENTITY;
                }
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage(). MESSAGE_SORRY;
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                $errorCode = CODE_INTERNAL_ERROR;
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
            $errorCode = CODE_UNPROCESSABLE_ENTITY;
        }
        
        // send output with token
        if (!$strErrorDesc) {
            $this->sendOutput(json_encode(array('success' => "Logged in successfully", 'token' => $token, 'userid' => $userId)),
                array('Content-Type: application/json',  'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc, 'errorCode' => $errorCode)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
    
    public function userListAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();                

        if (strtoupper($requestMethod) == 'GET') {
            try {
                $mainModel = new MainModel();
                $intLimit = 10;

                if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
                    $intLimit = $arrQueryStringParams['limit'];                
                }
                $arrUsers = $mainModel->getAllUsers($intLimit);
                $responseData = json_encode($arrUsers);
                
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json',  'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
    
    public function useridAction()
    {
         $strErrorDesc = '';
         $requestMethod = $_SERVER["REQUEST_METHOD"];
         $arrQueryStringParams = $this->getQueryStringParams();
         
         if (strtoupper($requestMethod) == 'GET') {
            try {
                $mainModel = new MainModel();
                $userid = 0;

                if (isset($arrQueryStringParams['userid']) && $arrQueryStringParams['userid']) {
                    $userid = $arrQueryStringParams['userid'];
                }
                $arrUsers = $mainModel->getUserById($userid);
                $responseData = json_encode($arrUsers);
                
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
}