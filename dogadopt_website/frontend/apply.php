<!DOCTYPE html>
<html>

<head>
    <title>Rehoming and Rescue | DogAdopt</title>
    <link rel="stylesheet" href="index.css">
</head>

<?php  
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch,CURLOPT_URL,
                "http://localhost/dogadopt_website/backend/my_backend/index.php/dog/list");
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
                        #curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.A.B.C Safari/525.13");
    $dogs_data = curl_exec($ch);
            
    $dogs_data = json_decode($dogs_data, true);
    $dogs_list = array();
            
    if ($dogs_data != null) {
        foreach ($dogs_data as $o) {
            array_push($dogs_list, $o);                                
        }
    }
?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
</script>
<script>
    // triggers on page load
    document.addEventListener("DOMContentLoaded", function() {
        checkTokenValid();
        refreshValues();
        refreshApplications();
    });

    function refreshValues() {
        var options = <?php echo json_encode($dogs_list) ?>;
        var select = document.getElementById("dog-list-dropdown");

        for (var i = 0; i < options.length; i++) {
            var dog = options[i];
            var opt = dog['name'] + " (" + dog['breed'] + ")";
            var el = document.createElement("option");
            el.textContent = opt;
            el.value = dog['dog_id'];
            select.appendChild(el);
        }
    }

    function scrollToApplicationForm() {
        formSection = document.getElementById("formsection");
        formSection.scrollIntoView({
            behavior: "smooth",
            block: "end",
            inline: "nearest"
        });
        localStorage.setItem('token', "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3MTQ3NzU4NzYsImlzcyI6ImxvY2FsaG9zdCIsImV4cCI6MTcxNDc3Njc3NiwidXNlcklkIjoxfQ.-8eL5zwbNbxJ_Nze9FqnqznHK7dfRTZbdabgoZSUGac");
    }

    function checkTokenValid() {
        currentToken = localStorage.getItem('token');
        currentUserId = localStorage.getItem('userid');

        // if token doesn't exist force login
        if (currentToken == null || currentToken == '' || currentUserId == 0) {
            localStorage.setItem('nextPage', 'apply.php');
            alert("Please login to make an application");
            localStorage.setItem('token', '');
            localStorage.setItem('userid', 0);
            location.replace('login.html');
        } else {
            // verify with php
            $.ajax({
                url: "verify-token.php",
                type: "post",
                dataType: 'json',
                async: true,
                data: {
                    token: currentToken,
                },
                success: function(result) {
                    obj = JSON.parse(result);
                }
            }).then(function() {
                // if token invalid force login
                if (!obj || obj.valid == false) {
                    localStorage.setItem('nextPage', 'apply.php');
                    alert("Please login to make an application");
                    localStorage.setItem('token', '');
                    localStorage.setItem('userid', 0);
                    location.replace('login.html');
                }
            });
        }
    }

    function submitApplication() {
        const userId = localStorage.getItem('userid');

        var dogSelect = document.getElementById('dog-list-dropdown');
        var dogId = dogSelect.value;

        if (userId != 0 && userId != null) {
            $.ajax({
                url: "post-application.php",
                type: "post",
                dataType: 'json',
                async: true,
                data: {
                    userid: userId,
                    dogid: dogId
                },
                success: function(result) {
                    obj = JSON.parse(result);
                    // if successful refresh applications
                    if (obj['success'] == true) {
                        refreshApplications();
                    }
                }
            });
        }
    }

    function refreshApplications() {
        const userId = localStorage.getItem('userid');

        if (userId != 0 && userId != null) {
            $.ajax({
                url: "get-applications.php",
                type: "post",
                dataType: 'json',
                async: true,
                data: {
                    userid: userId
                },
                success: function(result) {
                    displayCards(JSON.parse(result));
                }
            });
        }
    }

    function displayCards(appsArray) {
        const cardContainer = document.getElementById('card-container');
        cardContainer.innerHTML = "<h3black>Your applications</h3black>";
        for (let i = 0; i <= appsArray.length; i++) {
            var app = appsArray[i];
            var sex = "Unknown/Unapplicable";
            switch (app['sex']) {
                case 1:
                    sex = "Male";
                case 2:
                    sex = "Female";
                default:
                    sex = "Unknown/Unapplicable";
            }
            var card = createCard(app['name'], app['breed'], app['colour'], app['sex']);
            cardContainer.appendChild(card);
            cardContainer.scrollIntoView({
                behavior: "smooth",
                block: "start",
                inline: "nearest"
            });
        }
    }

    function createCard(title, breedname, colourname, sex) {
        const card = document.createElement('div');
        const cardTitleBox = document.createElement('div');
        const cardContentBox = document.createElement('div');
        card.appendChild(cardTitleBox);
        card.appendChild(cardContentBox);

        card.classList.add('list-card');
        cardTitleBox.classList.add('list-card-title');
        cardContentBox.classList.add('list-card-content');

        const cardTitle = document.createElement('h2');
        cardTitle.textContent = title;

        const cardBreed = document.createElement('p');
        cardBreed.textContent = "Breed: " + breedname;
        const cardColour = document.createElement('p');
        cardColour.textContent = "Coat: " + colourname;
        const cardSex = document.createElement('p');
        cardSex.textContent = "Sex: " + sex;

        cardTitleBox.appendChild(cardTitle);
        cardContentBox.appendChild(cardBreed);
        cardContentBox.appendChild(cardColour);
        cardContentBox.appendChild(cardSex);

        return card;
    }

</script>

<body>
    <div class="header">
        <div id="header-wrapper">
            <a href="index.html">
                <div id="logo-box">
                    <img src="dogadopt_logo.jpg" id="logo">
                    <h2 style="float: left; align-content: center">WebsiteName.org</h2>
                </div>
            </a>
            <div id="topnav-box">
                <div class="topnav">
                    <div class="nav-button" href="login.html">
                        Login
                    </div>
                    <a href="index.html" class="active">Home</a>
                    <a href="list-page.php">Our dogs</a>
                    <a href="apply.php">Apply</a>
                    <a href="fun-facts.html">Fun</a>
                </div>
            </div>
        </div>
    </div>
    <div class="contentyellow">
        <div class="banner">
            <div class="left">
                <div class="bannersection">
                    <div>
                        <h3black>Apply to adopt!</h3black>

                        <p>You can start the application process here.</p>
                        <p>Remember that this doesn't guarantee you a specific dog, though we can match you with a pet that would be best for you.</p>
                    </div>
                    <div class="yellow-button" onclick="scrollToApplicationForm()">Begin applying</div>
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
        <div class="section2" id="formsection">
            <div class="center-section">
                <h3black>Apply to adopt</h3black>
                <p>Choose your preferences below to help us match you with dogs. Otherwise choose 'No preference'.</p>
                <form name="applyForm" class="spaced-form">
                    <label>Dog</label><br>
                    <select class="form-select" id="dog-list-dropdown" aria-label="Default select example">

                    </select>
                    <br><br>
                    <input type="button" id="submit" name="submit" value="Submit" onclick="submitApplication()">
                </form>
                <p id="errorText"></p>
            </div>
        </div>
        <div class="list-section" id="card-container">
            <!--- displays list of applications -->
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
                        <div class="nav-button" onclick="location.href = 'list-page.php';">
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
                        <div class="nav-button" onclick="location.href = 'fun-facts.html';">
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
                            <li><a href="list-page.html">Our dogs list</a></li>
                            <li><a href="fun-facts.html">Dog facts</a></li>
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
