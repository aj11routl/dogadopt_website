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
    document.addEventListener("DOMContentLoaded", function() {
        var dogs = <?php echo json_encode($dogs_list) ?>;
        refreshValues();
    });

    function refreshValues() {
        var options = <?php echo json_encode($dogs_list) ?>;
        var select = document.getElementById("dog-list-dropdown");
        var select2 = document.getElementById("dog-list-dropdown-2");

        for (var i = 0; i < options.length; i++) {
            var dog = options[i];

            var opt = dog['name'] + " (" + dog['breed'] + ")";
            var el = document.createElement("option");
            el.textContent = opt;
            el.value = dog['dog_id'];
            select.appendChild(el);

            var el2 = document.createElement("option");
            el2.textContent = opt;
            el2.value = dog['dog_id'];
            select2.appendChild(el2);
        }
    }

    function deleteDog() {

        var dogSelect = document.getElementById('dog-list-dropdown');
        var dogId = dogSelect.value;
        const el = document.getElementById('delete-message');

        $.ajax({
            url: "delete-dog.php",
            type: "post",
            dataType: 'json',
            async: true,
            data: {
                dogid: dogId
            },
            success: function(result) {
                refreshValues();
            }
        });
    }

    function populateText() {
        var breed = document.getElementById('breed');
        var colour = document.getElementById('colour');
        var select = document.getElementById('dog-list-dropdown-2');
        
        var dogs = <?php echo json_encode($dogs_list) ?>;
        
        for (var i = 0; i < dogs.length; i++) {
            var dog = dogs[i];
            if (dog['dog_id'] == select.value) {
                breed.value=dog['breed'];
                colour.value=dog['colour'];
            }
        }
    }
    
    function updateDog() {
        var breed = document.getElementById('breed');
        var colour = document.getElementById('colour');
        var select = document.getElementById('dog-list-dropdown-2');
        var dogId = select.value;
        console.log(dogId);
        
        $.ajax({
            url: "update-dog.php",
            type: "post",
            dataType: 'json',
            async: true,
            data: {
                dogid: dogId,
                breed: breed,
                colour: colour
            },
            success: function(result) {
                console.log(result);
                location.reload();
            }
        });
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
                    <div class="nav-button" onclick="location.href = 'apply.php';">
                        Apply
                    </div>
                    <a href="index.html" class="active">Home</a>
                    <a href="list-page.php">Our dogs</a>
                    <a href="">Info</a>
                    <a href="fun-facts.html">Fun</a>
                    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                        <i class="fa fa-bars"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="wrapper">
            <div class="left">
                <div class="wrapper">
                    <div class="left">
                        <form name="deleteForm" class="spaced-form">
                            <h3black>1. Delete dog</h3black>
                            <br>
                            <p>Delete record from table 'dogs'</p>
                            <p>This will cascade delete any related records in the 'applications' table.</p>
                            <label>Dog:</label>
                            <select id="dog-list-dropdown" aria-label="Default select example">

                            </select>
                            <br><br>
                            <input type="button" id="submit" name="delete" value="Delete" onclick="deleteDog()">
                            <br>
                        </form>
                    </div>
                    <div class="right">
                    </div>
                </div>
            </div>
            <div class="right">
                <div class="wrapper">
                    <div class="left">
                        <form name="updateForm" class="spaced-form">
                            <h3black>2. Update dog</h3black>
                            <br>
                            <p>Update record from table 'dogs'</p>
                            <p>Update the colour and/or breed.</p>
                            <label>Dog:</label>
                            <select id="dog-list-dropdown-2" aria-label="Default select example" onchange="populateText()">

                            </select><br><br>
                            <label for="breed">Breed:</label>
                            <input type="text" id="breed" name="breed"><br><br>
                            <label for="colour">Colour:</label>
                            <input type="text" id="colour" name="colour"><br><br>
                            <input type="button" id="update" name="update" value="Update" onclick="updateDog()">
                            <br>
                        </form>
                    </div>
                    <div class="right">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


</html>
