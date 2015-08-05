<!DOCTYPE html>

<?php
    
    // loads the variable $varName from the url
    // if no url input is found it checks for a cookie with the same name
    // if no such cookie is found it uses the $defaultValue
    // store the value in a cookie named $varName with a default lifetime of 30 days
    // returns the result
    function loadVariable($varName, $defaultValue, $cookieLifetime = 2592000) {
        $varValue = $_GET[$varName]; // fetches the variable from the url
        if (!is_numeric($varValue)) { // the fetched input is not numeric or not valid
            if (isset($_COOKIE[$varName])) { // a cookie with the same name is found
                $varValue = $_COOKIE[$varName]; // use the cookie
            } else { // no cookie is found
                $varValue = $defaultValue; // use the default value
            }
        }
        setcookie($varName, $varValue, time() + $cookieLifetime); // sets a cookie
        return $varValue; // returns the result
    }
    
    // initilize all variables
    $distance = loadVariable("distance", 60);
    $tension  = loadVariable("tension",  10);
    $mass     = loadVariable("mass",    100);
    $sag      = loadVariable("sag",     1.5);
    $angle    = loadVariable("angle",   5.6);

    ?>

<html>
    <head>
        <title>Slackline Tension</title>
        <link rel="manifest" href="manifest.json">
        <link rel="stylesheet" type="text/css" href="style.css" />
    </head>
    <body>
        <br>
        <table id="input">
            <form>
                <tr>
                    <td><label for="tension">tension:</label></td>
                    <td><input id="tension" name="tension" type="number" step="0.1"
                               value = <?php echo "\"" . $tension ."\"" ?></td>
                    <td>kN</td>
                </tr>
                <tr>
                    <td><label for="distance">distance:</label></td>
                    <td><input id="distance" name="distance" type="number" step="1"
                               value = <?php echo "\"" . $distance ."\"" ?></td>
                    <td>m</td>
                </tr>
                <tr>
                    <td><label for="mass">mass:</label></td>
                    <td><input id="mass" name="mass" type="number" step="1"
                               value = <?php echo "\"" . $mass ."\"" ?></td>
                    <td>kg</td>
                </tr>
                <tr>
                    <td></td>
                    <td><button>calculate sag</button></td>
                    <td></td>
                </tr>
                <tr>
                    <td>sag:</td>
                    <td><?php
                        $calculatedSag = tan(asin((9.81*$mass)/(2000*$tension))) * $distance/2;
                        echo number_format($calculatedSag, 2);
                        ?></td>
                    <td>m</td>
                </tr>
            </form>
            <tr><td><br></td></tr>
            <form>
                <tr>
                    <td><label for="sag">sag:</label></td>
                    <td><input id="sag" name="sag" type="number" step="0.01"
                               value = <?php echo "\"" . $sag ."\"" ?></td>
                    <td>m</td>
                </tr>
                <tr>
                    <td><label for="distance">distance:</label></td>
                    <td><input id="distance" name="distance" type="number" step="1"
                               value = <?php echo "\"" . $distance ."\"" ?></td>
                    <td>m</td>
                </tr>
                <tr>
                    <td><label for="mass">mass:</label></td>
                    <td><input id="mass" name="mass" type="number" step="1"
                               value = <?php echo "\"" . $mass ."\"" ?></td>
                    <td>kg</td>
                </tr>
                <tr>
                    <td></td>
                    <td><button>calculate tension</button></td>
                    <td></td>
                </tr>
                <tr>
                    <td>tension:</td>
                    <td><?php
                        $calculatedTension = ( 9.81 * $mass ) / ( 2000 * sin(atan((2*$sag)/$distance)) );
                        echo number_format($calculatedTension, 1);
                        ?></td>
                    <td>kN</td>
                </tr>
            </form>
            <tr><td><br></td></tr>
            <form>
                <tr>
                    <td><label for="angle">angle:</label></td>
                    <td><input id="angle" name="angle" type="number" step="0.1"
                               value = <?php echo "\"" . $angle ."\"" ?></td>
                    <td>&deg;</td>
                </tr>
                <tr>
                    <td><label for="mass">mass:</label></td>
                    <td><input id="mass" name="mass" type="number" step="1"
                               value = <?php echo "\"" . $mass ."\"" ?></td>
                    <td>kg</td>
                </tr>
                <tr>
                    <td></td>
                    <td><button>calculate tension</button></td>
                    <td></td>
                </tr>
                <tr>
                    <td>tension:</td>
                    <td><?php
                        $calculatedTension = 9.81 * $mass / ( 2000 * sin( pi() * $angle / 360 ) );
                        echo number_format($calculatedTension, 1);
                        ?></td>
                    <td>kN</td>
                </tr>
            </form>
        </table>
    </body>
</html>