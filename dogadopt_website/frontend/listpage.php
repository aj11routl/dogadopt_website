<!DOCTYPE html>
<html>
<head>
<title>Rehoming and Rescue | DogAdopt</title>
<link rel="stylesheet" href="index.css">
</head>

<body>
    <div class="header">
        <div id="header-wrapper">
            <a href="index.html">
                <div id="logo-box">
                    <div id="logo">
                    </div>
                    <h2 style="float: left; align-content: center">WebsiteName.org</h2>
                </div>
            </a>
            <div id="topnav-box">        
                <div class="topnav">
                    <div class="nav-button" href="">
                        Apply
                    </div>
                    <a href="#home" class="active">Home</a>
                    <a href="listpage.html">Our dogs</a>
                    <a href="#contact">Info</a>
                    <a href="#about">Fun</a>
                </div>
            </div>
        </div>
    </div>
    <div class="contentyellow">
        <div class="banner">
            <div class="left">
                <div class="bannersection">
                    <div>
                        <h3black>Our dogs</h3black>
                        <p>Look through our list of dogs and pups</p>
                        <br>
                        <?php  
                            $ch = curl_init();
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                curl_setopt($ch,CURLOPT_URL,
                                        "http://localhost/dogadopt_website/backend/my_backend/index.php/dog/breed/list");
                                curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
                                #curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.A.B.C Safari/525.13");
                                $data = curl_exec($ch);
                                curl_close($ch);
                            $data = json_decode($data, true);
                            $breeds_list = array();
                            foreach ($data as $o) {
                                array_push($breeds_list, $o['breed']);                                
                            }
                        foreach($breeds_list as $x) {
                            print("$x");
                        }
                        ?> 
                        
                    </div>   
                </div>
            </div>
            <div class="right">
                <div class="bannersection-right">
                    <div id="bannersection-text">
                        <h3>Helping dogs in need</h3>
                        <p>We believe all dogs deserve to live life to the fullest</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="section2">
            <h3black>Search the database</h3black>
            <hr>
            <div>
                <label>
                    Multi-select
                    <input mbsc-input id="my-input" data-dropdown="true" data-tags="true" />
                </label>
                <div class="wrapper">
                    <div class="optionbutton">Option 1</div>
                                        <div class="optionbutton">Option 1</div>

                </div>
                
                <div>
                    <select id="multiple-select" multiple>
                        <option value="1">Breed</option>
                        <option value="2">Colour</option>
                        <option value="3">Sex</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="wrapper">
            <div class="left">
                    <h3>Sitemap</h3>
                <div class="wrapper">
                    <div class="left">
                        <ul>
                            <li><a href="index.html">Home</a></li>
                            <li><a href="listpage.html">Our dogs list</a></li>
                            <li><a href="#facts">Dog facts</a></li>
                        </ul>
                    </div>
                    <div class="right">
                        <ul>
                            <li><a href="#apply">Apply</a></li>
                            <li><a href="#login">Login</a></li>
                            <li><a href="#register">Register</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!--<div class="vl"></div>-->
            <div class="right">
                <h3>DogAdopt 2024</h3>
            </div>
        </div>
        <hr class="solid">
    </div>
</body>

</html> 