<?php
global $tController;

echo '<br>' . __FILE__;

$tmp = $tController->getHelper('Session')->get();

echo '<pre>';
print_r($tmp);
echo '</pre>';