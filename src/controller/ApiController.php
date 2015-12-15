<?php


namespace controller;


class ApiController
{
    public static $cacheDir = APP_ROOT . 'cache' . DIRECTORY_SEPARATOR  . 'SR' . DIRECTORY_SEPARATOR;

    private static $cache_life = 5; //Minutes

    private $messages = array();

    public function Traffic(){
        $content = $this->loadFromDisk() ?? $this->getFromAPI('http://api.sr.se/api/v2/traffic/messages?format=json&pagination=false&sort=createddate&indent=true');

        header('Content-Type: application/json');
        header('Cache-Control: max-age=' . self::$cache_life * 60);
        header("Pragma: public");
        header('Expires: ' . gmdate('D, d M Y H:i:s', time()+ (self::$cache_life * 60)) . ' GMT');

        return $content;
    }

    private function loadFromURL($url){
        $content = file_get_contents($url);
        $json = json_decode($content);

        foreach($json->messages as $message){
            $this->messages[] = (new \model\Message())->loadFromJSON($message);
        }
    }

    private function getFromAPI($url){
        try{
            $this->loadFromURL($url);

            usort($this->messages, function($a, $b){
                /* @var $a \model\Message */
                /* @var $b \model\Message */
                if ($a->getCreated() == $b->getCreated()) {
                    return 0;
                }

                return ($a->getCreated() < $b->getCreated()) ? -1 : 1;
            });

            $content = json_encode($this->messages);
            file_put_contents(self::$cacheDir . 'sr-' . date('Y-m-d H:i:s') . '.json', $content);

        }catch(\Throwable $e){
            throw $e;
        }
    }

    private function loadFromDisk(){
        $cached_files = get_dir(self::$cacheDir);

        if(count($cached_files)){
            foreach($cached_files as $file){
                preg_match('/^sr-(.*).json/', $file, $matches);

                if(strtotime($matches[1]) >= (strtotime('-' . self::$cache_life  . ' minutes', time()))){
                    return file_get_contents(self::$cacheDir . $file);
                }
            }
        }

        return null;
    }
    public function Index(){
        return 'hej, du är ny här va?';
    }
}