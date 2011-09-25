<?php
ob_start();
session_start();
require_once(realpath('../config/app_tie.php'));
if (isset($_SESSION['user'])) {
    $username = $_SESSION['user'];
    User::retrieveOffers($user);
}

if (isset($_POST['edit'])) {
    if ($_POST['password'] == "") {
        // don't change $user->pass
    } else {
        $user->pass = sha1($_POST['password']);
    }
    $user->name    = $_POST['username'];
    $user->email   = $_POST['email'];
    $user->country = $_POST['country'];

    if (isset($_POST['city_ca'])) {
        $user->city = $_POST['city_ca'];
    } elseif (isset($_POST['city_us'])) {
        $user->city = $_POST['city_us'];
    }

    $newOffers = $_POST['offers'];

    if (array_diff($newOffers, $user->offers)) {
        $user->offers = $newOffers;
        // true => update the offers as well
        User::update($user, true);
    } else {
        User::update($user, false);
    }

} // end of edit

?>
<html>
<head>
<style type="text/css">

</style>

<script type="text/javascript">
window.onload = function() {
    var country = document.getElementById('country');
    getCountry(country);
}
<?php
$country = $user->country;
$city    = $user->city;
$offers  = $user->offers;
?>

var us_cities =
'<label for="city_us">City:</label>' +
'<select name="city_us" id="city_us">' +
"<option value=\"\" selected=\"selected\"><?php if ($country == 'us') print ucfirst($city) ?></option>" +
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
  '<option value="" selected="selected"><?php if ($country == 'ca') print ucfirst($city) ?></option>' +
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

<h1>Edit</h1>

<form action="<?php print $_SERVER['PHP_SELF'] . "?user={$user->name}" ?>" method="post">

<h3>Your Info</h3>
<label for="username">Username:</label>
<input type="text" name="username" id="username" value="<?php print $user->name ?>" /><br />

<label for="email">Email:</label>
<input type="text" name="email" id="email" value="<?php print $user->email ?>"/><br />

<label for="password">Password:</label>
<input type="password" name="password" id="password" /><br />

<label for="c_password">Confirm password:</label>
<input type="password" name="c_password" id="c_password" /><br />

<br />


<label for="country">Country:</label>
<select name="country" id="country" onChange="getCountry(this);">
    <?php
if ($user->country == 'ca') {
    print <<<HTML
    <option value="ca" selected="selected">Canada</option>\n
    <option value="us">United States</option>\n
HTML;
} elseif ($user->country == 'us') {
    print <<<HTML
    <option value="us" selected="selected">United States</option>\n
    <option value="ca">Canada</option>
HTML;

}
    ?>
</select>
<div id="cities_ca"></div>
<div id="cities_us"></div>
<br />
<br />

<div id="services">
<div id="offers_section">
<h3>Your Offers</h3>
<p>What kind of services are you offering?</p><br />
<input type="checkbox" name="offers[]" value="home_repair" <?php if (in_array('home_repair', $offers)) print " checked=\"checked\"" ?> />
Home Repair<br />
<input type="checkbox" name="offers[]" value="gardening" <?php if (in_array('gardening', $offers)) print " checked=\"checked\"" ?> />
Gardening<br />
<input type="checkbox" name="offers[]" value="carpooling_moving" <?php if (in_array('carpooling_moving', $offers)) print " checked=\"checked\"" ?> />
Carpooling/Moving<br />
<input type="checkbox" name="offers[]" value="teaching" <?php if (in_array('teaching', $offers)) print " checked=\"checked\"" ?>/>
Teaching<br />
<input type="checkbox" name="offers[]" value="care_giving" <?php if (in_array('care_giving', $offers)) print " checked=\"checked\"" ?>/>
Caregiving<br />
<input type="checkbox" name="offers[]" value="cooking" <?php if (in_array('cooking', $offers)) print " checked=\"checked\"" ?>/>
Cooking<br />
<input type="checkbox" name="offers[]" value="designing" <?php if (in_array('designing', $offers)) print " checked=\"checked\"" ?>/>
Designing<br />
<input type="checkbox" name="offers[]" value="accounting" <?php if (in_array('accounting', $offers)) print " checked=\"checked\"" ?>/>
Accounting<br />
<input type="checkbox" name="offers[]" value="dog_walking" <?php if (in_array('dog_walking', $offers)) print " checked=\"checked\"" ?>/>
Dog Walking<br />
</div>
<br />

<input type="submit" value="Edit" name="edit" />

</form>
</body>
</html>

