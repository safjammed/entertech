<?php
function env(string $varname, $default = false){
    return $_ENV[$varname] ?? $default;
}