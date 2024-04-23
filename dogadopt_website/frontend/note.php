<?php  
                            $list = $response = file_get_contents('http://localhost/dogadopt_website/backend/my_backend/index.php/dog/breed');
                        
                            $list = json_decode($list, true);
                            $arr = array();
                            foreach($list as $x) {
                                $a = $x['breed'];
                                array_push($arr, $x['breed']);
                                print_r("$a");
                            }
                        ?> 
