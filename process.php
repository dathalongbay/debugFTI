<?php
/**
 * Created by PhpStorm.
 * User: datdx2
 * Date: 9/13/2019
 * Time: 3:23 PM
 */

$data = file_get_contents("php://input");
echo "<pre> --- response";
echo "<pre>";
print_r($data);
echo "</pre>";
