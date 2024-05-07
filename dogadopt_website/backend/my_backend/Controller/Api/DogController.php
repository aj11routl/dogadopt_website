<?php
require_once "./constants.php";
use \Firebase\JWT\JWT;

class DogController extends BaseController
{
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
    
    // get all dogs
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
    
    public function dogUpdateAction() {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        
        if (strtoupper($requestMethod) == 'POST') {
            try {
                $model = new MainModel();
                if ($arrQueryStringParams['dogid'] && isset($arrQueryStringParams['dogid'])) 
                {

                    $dogId = $arrQueryStringParams['dogid'];
                    $breed = $arrQueryStringParams['breed'];
                    $colour = $arrQueryStringParams['colour'];
                
                    // insert data
                    $success = $model->updateDog($dogId, $breed, $colour);
                    if ($success == true) {
                        $responseData = json_encode(array('success' => true));
                    } else {
                        $strErrorDesc = 'Something went wrong! Please contact support.';
                        $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                    }
                }
                
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
    
    public function dogDeleteAction() {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        
        if (strtoupper($requestMethod) == 'DELETE') {
            try {
                $model = new MainModel();
                if (isset($arrQueryStringParams['dogid']) && $arrQueryStringParams['dogid']) {
                    
                    $dogId = $arrQueryStringParams['dogid'];
                
                    // insert data
                    $success = $model->deleteDog($dogId);
                    if ($success == true) {
                        $responseData = json_encode(array('success' => true));
                    } else {
                        $strErrorDesc = 'Something went wrong! Please contact support.';
                        $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                    }
                }
                
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
