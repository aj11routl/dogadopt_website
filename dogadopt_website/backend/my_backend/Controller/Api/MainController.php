<?php
require_once "./constants.php";
use \Firebase\JWT\JWT;

class MainController extends BaseController
{
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
                        }
                    }
                } else {
                    $strErrorDesc = 'Parameters not supported';
                    $strErrorHeader = 'HTTP/1.1 422 Unprocessable entity';
                }
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage(). MESSAGE_SORRY;
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        
        $token = $this->generateToken();
        print("$token");
        
        // send output with token
        if (!$strErrorDesc) {
            $this->sendOutput(json_encode(array('success' => "Logged in successfully", 'token' => 'asdf')),
                array('Content-Type: application/json',  'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
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
    
     public function dogidAction()
     {
         $strErrorDesc = '';
         $requestMethod = $_SERVER["REQUEST_METHOD"];
         $arrQueryStringParams = $this->getQueryStringParams();
         
         if (strtoupper($requestMethod) == 'GET') {
            try {
                $mainModel = new MainModel();
                $dogid = 0;

                if (isset($arrQueryStringParams['dogid']) && $arrQueryStringParams['dogid']) {
                    $dogid = $arrQueryStringParams['dogid'];
                }
                $arrUsers = $mainModel->getDogById($dogid);
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
    
    public function dogListAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
         
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $model = new MainModel();
                
                $arrDogs = $model->getAllDogs();
                $responseData = json_encode($arrDogs);
                
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
    
        public function dogColourAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $model = new MainModel();
                $colour = '';

                if (isset($arrQueryStringParams['dogcolour']) && $arrQueryStringParams['dogcolour']) {
                    $colour = $arrQueryStringParams['dogcolour'];
                }
                $arrDogs = $model->getDogsByColour($colour);
                $responseData = json_encode($arrDogs);
                
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
    
    public function dogColourListAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
         
        if (strtoupper($requestMethod) == 'GET') 
        {
            try {
                $model = new MainModel();
                
                $arrResponse = $model->getAllDogColours();
                $arrColours = [];
                foreach($arrResponse as $row) {
                    if (!in_array($row, $arrColours)) {
                        array_push($arrColours, $row);
                    }
                }      
                $responseData = json_encode($arrColours);
                
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
    
    public function dogBreedAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
         
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $model = new MainModel();
                $breed = '';
                if (isset($arrQueryStringParams['dogbreed']) && $arrQueryStringParams['dogbreed']) {
                    $breed = $arrQueryStringParams['dogbreed'];
                }
                $arrDogs = $model->getDogsByBreed($breed);
                $responseData = json_encode($arrDogs);
                
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
    
    public function dogBreedListAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
         
        if (strtoupper($requestMethod) == 'GET') 
        {
            try {
                $model = new MainModel();
                
                $arrResponse = $model->getAllDogBreeds();
                $arrBreeds = [];
                foreach($arrResponse as $row) {
                    if (!in_array($row, $arrBreeds)) {
                        array_push($arrBreeds, $row);
                    }
                }      
                $responseData = json_encode($arrBreeds);
                
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
    
    public function dogSexAction() 
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $model = new MainModel();
                
                $sex = 0;
                if (isset($arrQueryStringParams['sex']) && $arrQueryStringParams['sex']) {
                    $param = $arrQueryStringParams['sex'];
                    
                    if ($param == 'male') {
                        $sex = 1;
                    } elseif ($param == 'female') {
                        $sex = 2;
                    } else {
                        $strErrorDesc = 'Method not supported. Use "male" or "female" as parameter.';
                        $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
                    }
                }
                
                $arrDogs = $model->getDogsBySex($sex);
                $responseData = json_encode($arrDogs);
                
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