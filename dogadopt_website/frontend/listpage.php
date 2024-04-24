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
        <?php  
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch,CURLOPT_URL,
                        "http://localhost/dogadopt_website/backend/my_backend/index.php/dog/breed/list");
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
                                #curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.A.B.C Safari/525.13");
            $breeds_data = curl_exec($ch);
            curl_setopt($ch,CURLOPT_URL,
                        "http://localhost/dogadopt_website/backend/my_backend/index.php/dog/colour/list");
            $colours_data = curl_exec($ch);
            curl_close($ch);
            $breeds_data = json_decode($breeds_data, true);
            $colours_data = json_decode($colours_data, true);
            
            $breeds_list = array();
            $colours_list = array();
            foreach ($breeds_data as $o) {
                array_push($breeds_list, $o['breed']);                                
            }
            foreach ($colours_data as $o) {
                array_push($colours_list, $o['colour']);                                
            }
            ?> 
            <script>
                function refreshValues(){
                    
                    var select = document.getElementById("select-dropdown");
                    var options = [];
                        
                    var e = document.getElementById("options-dropdown");
                    
                    var value = e.value;
                    var text = e.options[e.selectedIndex].text;
                    
                    switch (text) {
                        case "Breed":
                            options=<?php echo json_encode($breeds_list) ?>;
                            break;
                        case "Colour":
                            options=<?php echo json_encode($colours_list) ?>;
                            break;
                        case "Sex":
                            options=["Male", "Female"];
                            break;
                    }
                    
                    for (var i = 0; i <= select.length; i++) {
                        select.remove(select.i);
                    }
                    
                    for(var i = 0; i < options.length; i++) {
                        var opt = options[i];
                        var el = document.createElement("option");
                        el.textContent = opt;
                        el.value = opt;
                        select.appendChild(el);
                    }
                }
                
                function searchDogs(){
                    
                }
            </script>
            <h3black>Search the database</h3black>
            <div class="wrapper" id="listform-wrapper">
                <div>
                    <label>Search by</label>
                    <select class="form-select" id="options-dropdown" onChange="refreshValues()" aria-label="Default select example">
                      <option selected>Search by...</option>
                      <option value="1">Breed</option>
                      <option value="2">Sex</option>
                      <option value="3">Colour</option>
                    </select>
                    <label>Search for</label>
                    <select class="form-select" id="select-dropdown" onchange="showDogs" aria-label="Default select example">
                        <option label="Select.."></option>
                    </select>
                </div>
            </div>
            <button class="optionbutton">Search</button>
        </div>
        <div class="section1">
            <div class="card" id="cardfill">
                <div class="cardimage" style="background-image: url(schnauzer-cardimage.jpg);">
                </div>
                <div class="cardcontent">
                    <div class="top">
                        <h3black>See our dogs</h3black>
                        <p class="textgrey">See if any of our dogs or pups are right for you</p>
                    </div>
                    <div class="bottom">
                        <div class="nav-button">
                            See list
                        </div>
                    </div>
                </div>
            </div>
            <div class="card" id="cardfill">
                <div class="cardimage" style="background-image: url(cardimage.jpg);">
                </div>
                <div class="cardcontent">
                    <div class="top">
                        <h3black>Fun facts</h3black>
                        <p class="textgrey">Play a game and generate some fun facts about dogs!</p>
                    </div>
                    <div class="bottom">
                        <div class="nav-button">
                            Play now
                        </div>
                    </div>
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