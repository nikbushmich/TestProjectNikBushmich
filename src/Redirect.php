<?php

class Redirect
{
    public static function to(string $location = null) :void
    {
        if($location) {
            if(is_numeric($location)) {
                switch ($location) {
                    case 404:
                        header('HTTP/1.0 404 Not Found.');
                        include __DIR__. '/../templates/404.view.php';
                        exit;
                    break;
                }
            }
            header('Location: /../' . $location);
        }
    }
}
