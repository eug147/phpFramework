<?php

function debug($data, $die = false)
{
    echo '<pre>' . print_r($data, 1) . '</pre>';
    if ($die) {
        die;
    }
}

function h($str)
{
    return htmlspecialchars($str);
}

function redirect($http = false)
{
    if ($http) {
        $redirect = $http;
    } else {
        $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;
    }
    header("Location: $redirect");
    die;
}

/**
 * @param string $key Key of GET array
 * @param string $type Values 'i', 'f', 's'
 * @return float|int|string
 */
function get($key, $type = 'i')
{
    $param = $key;
    $$param = $_GET[$param] ?? '';
    if ($type == 'i') {
        return (int)$$param;
    } elseif ($type == 'f') {
        return (float)$$param;
    } else {
        return trim($$param);
    }
}

function update_qty($row_qty, $min_qty)
{
    $quotient = intval($row_qty / $min_qty);
    $remainder = $row_qty % $min_qty;

    return $updated_qty =  $remainder == 0 ? $row_qty : ($quotient + 1) * $min_qty;
}

function post($key, $type = 's')
{
    $param = $key;
    $$param = $_POST[$param] ?? '';
    if ($type == 'i') {
        return (int)$$param;
    } elseif ($type == 'f') {
        return (float)$$param;
    } else {
        return trim($$param);
    }
}

function get_field_value($name)
{
    return isset($_SESSION['cart_form_data'][$name]) ? h($_SESSION['cart_form_data'][$name]) : '';
}

function get_feedback_content($feedback_name)
{
    if ( empty($feedback_name)) {
        $feedback_name = "otzivi-agrofirma";
    }
    // xml file path
    $path = WWW . "/assets/app_data/xml/" . $feedback_name . ".xml";

    $xmlfile = file_get_contents($path);
    $new = simplexml_load_string($xmlfile, "SimpleXMLElement", LIBXML_NOCDATA);
    $con = json_encode($new);
    $content = json_decode($con, true);

    return $content;
}
