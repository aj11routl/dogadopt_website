<?php
require_once "./constants.php";
use \Firebase\JWT\JWT;

class ApplicationController extends BaseController
{
    public function applicationCreateAction() {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        
        if (strtoupper($requestMethod) == 'POST') {
            try {
                $model = new MainModel();
                if ($arrQueryStringParams['userid'] && 
                    $arrQueryStringParams['dogid'] &&
                    isset($arrQueryStringParams['userid']) && 
                    isset($arrQueryStringParams['dogid'])
                   ) 
                {

                    $userId = $arrQueryStringParams['userid'];
                    $dogId = $arrQueryStringParams['dogid'];
                
                    // insert data
                    $success = $model->insertApplication($userId, $dogId);
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
    
    public function applicationListAction() {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $model = new MainModel();
                if (isset($arrQueryStringParams['userid']) && $arrQueryStringParams['userid']) 
                {
                    $userId = $arrQueryStringParams['userid'];
                
                    // get data
                    $arrApps = $model->getAllApplications($userId);
                    $responseData = json_encode($arrApps);
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
