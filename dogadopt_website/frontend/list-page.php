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
                    <img src="dogadopt_logo.jpg" id="logo">
                    <h2 style="float: left; align-content: center">DogAdopt.org</h2>
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
                        <h3black>Our dogs</h3black>
                        <p>Look through our list of dogs</p>
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
            
            if ($breeds_data != null) {
                foreach ($breeds_data as $o) {
                    array_push($breeds_list, $o['breed']);                                
                }
            }
            if ($colours_data != null) {
                foreach ($colours_data as $o) {
                    array_push($colours_list, $o['colour']);                                
                }
            }
            ?>
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
            </script>
            <script>
                function refreshValues() {

                    var select = document.getElementById("select-dropdown");
                    var options = [];
                    var e = document.getElementById("options-dropdown");
                    var text = e.options[e.selectedIndex].text;

                    switch (text) {
                        case "Breed":
                            options = <?php echo json_encode($breeds_list) ?>;
                            break;
                        case "Colour":
                            options = <?php echo json_encode($colours_list) ?>;
                            break;
                        case "Sex":
                            options = ["Male", "Female"];
                            break;
                    }

                    for (var i = 0; i <= select.length; i++) {
                        select.remove(select.i);
                    }

                    for (var i = 0; i < options.length; i++) {
                        var opt = options[i];
                        var el = document.createElement("option");
                        el.textContent = opt;
                        el.value = opt;
                        select.appendChild(el);
                    }
                }

            </script>
            <script>
                function createCards() {
                    const a = document.getElementById("options-dropdown");
                    var option_text = a.options[a.selectedIndex].text;
                    const b = document.getElementById("select-dropdown");
                    var selected_text = b.options[b.selectedIndex].text;
                    const cardContainer = document.getElementById('card-container');
                    cardContainer.innerHTML = "";

                    if (option_text != "" && selected_text != "") {
                        var dogs_list = [];

                        myarr = [];
                        $.ajax({
                            url: "get-list.php",
                            type: "post",
                            dataType: 'json',
                            async: true,
                            data: {
                                option: option_text,
                                selection: selected_text
                            },
                            success: function(result) {
                                result = result.slice(1, -1);
                                var index = 0;
                                var index2 = 0;

                                for (let i = 0; i <= result.length; i++) {
                                    var character = result[i];
                                    if (character == "{") {
                                        index = i;
                                    }
                                    if (character == "}") {
                                        index2 = i;
                                        if (index < i) {
                                            myarr.push(JSON.parse(result.substring(index, index2 + 1)));
                                        }
                                    }
                                }
                            }
                        }).then(function() {
                            try {
                                for (let i = 0; i <= myarr.length; i++) {
                                    var obj = myarr[i];
                                    var s = "";
                                    if (obj['sex'] == 1) {
                                        s = "Male";
                                    }
                                    if (obj['sex'] == 2) {
                                        s = "Female";
                                    }
                                    var card = createCard(obj['name'], obj['breed'], obj['colour'], s);
                                    cardContainer.appendChild(card);
                                    cardContainer.scrollIntoView({
                                        behavior: "smooth",
                                        block: "end",
                                        inline: "nearest"
                                    });
                                }
                            } catch {
                                var errorDisplay = createErrorDisplay();
                                cardContainer.appendChild(errorDisplay);
                            }
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

                function createErrorDisplay() {
                    const box = document.createElement('div');
                    const title = document.createElement('h2black');
                    title.textContent = "Sorry..."
                    box.appendChild(title);
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
                    <select class="form-select" id="select-dropdown" aria-label="Default select example">
                        <option label="Select.."></option>
                    </select>
                </div>
            </div>
            <button class="searchbutton" onclick="createCards()" id="searchbtn">Search</button>

        </div>
        <div class="list-section" id="card-container">
            <!--- displays list of dogs on search 'createCards()' -->
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
                            <li><a href="list-page.php">Our dogs list</a></li>
                            <li><a href="fun-facts.html">Dog facts</a></li>
                        </ul>
                    </div>
                    <div class="right">
                        <ul>
                            <li><a href="apply.php">Apply</a></li>
                            <li><a href="login.html">Login</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="right">
                <h3>DogAdopt 2024</h3>
                <ul>
                    <li><a href="admin.php">Admin operations<br>(does not require login)</a></li>
                </ul>
            </div>
        </div>
        <hr class="solid">
    </div>
</body>

</html>
