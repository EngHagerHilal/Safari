<?php


try {
    $phar = new PharData('vendor_tar');
    $phar->extractTo('./');
    echo ('File extracted');
} catch (Exception $e) {
}
echo ('OK!');
