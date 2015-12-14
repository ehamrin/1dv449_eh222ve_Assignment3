<?php

spl_autoload_register(function ($class) {
    $class = str_replace("\\", DIRECTORY_SEPARATOR, $class);
    $mvc = dirname((__DIR__)) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . $class . '.php';

    if (file_exists($mvc)) {
        require_once $mvc;
    }
});

function exception_handler(\Throwable $exception) {
    if(DEBUG == TRUE) {
        echo '<div class="error debugging">';
        echo '<b>Fatal error</b>:  Uncaught exception \'' . get_class($exception) . '\' with message ';
        echo $exception->getMessage() . '<br>';
        echo 'Stack trace:<pre>' . $exception->getTraceAsString() . '</pre>';
        echo 'thrown in <b>' . $exception->getFile() . '</b> on line <b>' . $exception->getLine() . '</b><br>';
        echo '</div>';
    }
}

set_exception_handler('exception_handler');

class Error_UserError extends Exception{};
class Error_UserWarning extends Exception{};
class Error_UserNotice extends Exception{};
class Error_Unknown extends Exception{};

function error_handler($errno, $errstr, $errfile, $errline) {
    if(DEBUG == TRUE){
        if (!(error_reporting() & $errno)) {
            // This error code is not included in error_reporting
            return false;
        }

        echo '<div class="error debugging error-report"><pre>';
        switch ($errno) {
            case E_USER_ERROR:
                echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
                echo "  Fatal error on line $errline in file $errfile";
                echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
                echo "Aborting...<br />\n";
                exit(1);
                break;

            case E_USER_WARNING:
                echo "<b>My WARNING</b> [$errno] $errstr\n\n  $errfile <strong>Line:</strong> $errline<br />\n";
                break;

            case E_USER_NOTICE:
                echo "<b>My NOTICE</b> [$errno] $errstr\n\n  $errfile <strong>Line:</strong> $errline<br />\n";
                break;

            default:
                echo "Unknown error type: [$errno] $errstr\n\n  $errfile <strong>Line:</strong> $errline<br />\n";
                break;
        }
        echo '</pre></div>';
    }
    /* Don't execute PHP internal error handler */
    return true;
}

set_error_handler('error_handler');

function debug($data){
    echo '<div class="info debugging"><pre>';
    var_dump($data);
    echo '</pre></div>';
}

function get_dir($dir){
    $files = scandir($dir);
    array_shift($files);
    array_shift($files);

    return $files;
}

