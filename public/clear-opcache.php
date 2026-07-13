<?php
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "OPCACHE CLEARED SUCCESSFULLY!";
} else {
    echo "OPCACHE NOT ENABLED";
}
unlink(__FILE__);
