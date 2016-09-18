<?php
// You need to replace the PATH here!
define('PSR0_SRC', ROOT.'/core/libs');

set_include_path(PSR0_SRC . PATH_SEPARATOR . get_include_path());

function _autoload_psr0($className) {
    $fileParts = explode('\\', ltrim($className, '\\'));
    
    if (false !== strpos(end($fileParts), '_'))
        array_splice($fileParts, -1, 1, explode('_', current($fileParts)));

    $fileName = implode(DIRECTORY_SEPARATOR, $fileParts) . '.php';

    if (stream_resolve_include_path($fileName))
        require $fileName;
}
spl_autoload_register('_autoload_psr0');