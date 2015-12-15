<?php


namespace controller;


class ApiController
{
    public static $cacheDir = APP_ROOT . 'cache' . DIRECTORY_SEPARATOR;

    private static $cache_life = 5; //Minutes

    private $messages = array();

    public function Traffic(){
        $cache_dir = self::$cacheDir . 'SR' . DIRECTORY_SEPARATOR;
        $cached_files = get_dir($cache_dir);

        if(count($cached_files)){
            foreach($cached_files as $file){
                preg_match('/^sr-(.*).json/', $file, $matches);

                if(strtotime($matches[1]) >= (strtotime('-' . self::$cache_life  . ' minutes', time()))){
                    $content = file_get_contents($cache_dir . $file);
                }
            }
        }

        if(!isset($content)){
            try{
                $this->loadFromURL('http://api.sr.se/api/v2/traffic/messages?format=json&pagination=false&sort=createddate&indent=true');

                usort($this->messages, function($a, $b){
                    /* @var $a \model\Message */
                    /* @var $b \model\Message */
                    if ($a->getCreated() == $b->getCreated()) {
                        return 0;
                    }

                    return ($a->getCreated() < $b->getCreated()) ? -1 : 1;
                });

                $content = json_encode($this->messages);
                file_put_contents($cache_dir . 'sr-' . date('Y-m-d H:i:s') . '.json', $content);

            }catch(\Throwable $e){
                throw $e;
            }
        }

        header('Content-Type: application/json');
        header('Cache-Control: max-age=' . self::$cache_life * 60);
        return $content;
    }

    private function loadFromURL($url){
        $content = file_get_contents($url);
        $json = json_decode($content);

        foreach($json->messages as $message){
            $this->messages[] = (new \model\Message())->loadFromJSON($message);
        }
    }

    public function Index(){
        return 'hej';
    }
}