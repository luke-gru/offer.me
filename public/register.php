<?php
ob_start();
require_once(realpath('../config/app_tie.php'));
?>

<?php
if (isset($_POST['register'])) {
    if (!empty($_POST['username']) && !empty($_POST['email']) &&
        !empty($_POST['password']) && !empty($_POST['c_password']) &&
        !empty($_POST['offers'])) {
            $name    = $_POST['username'];
            $email   = $_POST['email'];
            $pass    = $_POST['password'];
            $country = $_POST['country'];
            if (!empty($_POST['city_ca'])) {
                $city = $_POST['city_ca'];
            } elseif (!empty($_POST['city_us'])) {
                $city = $_POST['city_us'];
            }
            // bio
            if (!empty($_POST['bio'])) {
                $bio = addslashes($_POST['bio']);
            } else {
                $bio = $user->bio;
            }

            $offers  = $_POST['offers'];
            // example to do:
            // 1. make sure the name (NAME) in the HTML inputs matches the $_POST['NAME']
            // 2. pass the arguments to the new User in the right sequence

            $user = new User(NULL, $name, $country, $city, $email, $bio, $offers, $pass, NULL);
            // the id is retrieved into the user object by saving the user
            $result = $user->save();

            if ($result) {
                session_start();
                $_SESSION['user'] = $name;
                session_write_close();
                header("Location: users/profile.php?user={$name}");
            }

        }
}
?>
<html>
<head>
<style type="text/css">

div#offers_section {
float:left;
}

textarea.bio {
float:left;
position:relative;
left:30px;
}

h3.bio {
position:relative;
left:30px;
}

div#wants_section {
float:left;
margin-left:3em;
}

.clear {
    clear:both;
}

</style>

<script type="text/javascript">
window.onload = function() {
    var country = document.getElementById('country');
    getCountry(country);
}

var us_cities =
    '<label for="city_us">City:</label>' +
    '<select name="city_us" id="city_us">' +
    '<option value="" selected="selected">City</option>' +
    '<option value="new york">New York</option>' +
    '<option value="chicago">Chicago</option>' +
    '<option value="boston">Boston</option>' +
    '<option value="philadelphia">Philadelphia</option>' +
    '<option value="austin">Austin</option>' +
    '<option value="san francisco">San Francisco</option>' +
    '<option value="san diego">San Diego</option>' +
    '<option value="los angeles">Los Angeles</option>' +
    '</select>' +
    '<br />';

var ca_cities =
    '<label for="city_ca">City:</label>' +
    '<select name="city_ca" id="city_ca">' +
    '<option value="" selected="selected">City</option>' +
    '<option value="toronto">Toronto</option>' +
    '<option value="montreal">Montreal</option>' +
    '<option value="calgary">Calgary</option>' +
    '<option value="ottawa">Ottawa</option>' +
    '<option value="edmonton">Edmonton</option>' +
    '<option value="mississauga">Mississauga</option>' +
    '<option value="winnipeg">Winnipeg</option>' +
    '<option value="quebec city">Quebec City</option>' +
    '</select>' +
    '<br />';

function getCountry(obj) {
    var country = obj.value;
    if (country === 'us') {
        document.getElementById('cities_us').innerHTML = us_cities;
        document.getElementById('cities_ca').innerHTML = '';
    } else if (country === 'ca' || country === '') {
        document.getElementById('cities_ca').innerHTML = ca_cities
            document.getElementById('cities_us').innerHTML = '';
    }

}
</script>

</head>
<body>

<h1>Register</h1>

<form action="register.php" method="post">

<h3>Your Info</h3>
<label for="username">Username:</label>
<input type="text" name="username" id="username" /><br />

<label for="email">Email:</label>
<input type="text" name="email" id="email" /><br />

<label for="password">Password:</label>
<input type="password" name="password" id="password" /><br />

<label for="c_password">Confirm password:</label>
<input type="password" name="c_password" id="c_password" /><br />

<br />


<label for="country">Country:</label>
<select name="country" id="country" onChange="getCountry(this);">
    <option value="" selected="selected">Country</option>
    <option value="ca">Canada</option>
    <option value="us">United States</option>
</select>
<div id="cities_ca"></div>
<div id="cities_us"></div>
<br />
<br />

<div id="offers_section">
<h3>Your Offers</h3>
<p>What kind of services are you offering?</p><br />
<input type="checkbox" name="offers[]" value="home_repair" />
Home Repair<br />
<input type="checkbox" name="offers[]" value="gardening" />
Gardening<br />
<input type="checkbox" name="offers[]" value="carpooling_moving" />
Carpooling/Moving<br />
<input type="checkbox" name="offers[]" value="teaching" />
Teaching<br />
<input type="checkbox" name="offers[]" value="care_giving" />
Caregiving<br />
<input type="checkbox" name="offers[]" value="cooking" />
Cooking<br />
<input type="checkbox" name="offers[]" value="designing" />
Designing<br />
<input type="checkbox" name="offers[]" value="accounting" />
Accounting<br />
<input type="checkbox" name="offers[]" value="dog_walking" />
Dog Walking<br />
</div>

<h3 class="bio">Bio</h3>
<textarea class="bio" name="bio" rows="7" cols="40">
</textarea>

<br class="clear"/><br />

<input type="submit" value="Done" name="register" />
</form>
</body>
</html>

