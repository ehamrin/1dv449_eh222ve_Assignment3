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
        header('Cache-Control: public, max-age=' . self::$cache_life * 60 . ',must-revalidate');
        header('Expires: ' . gmdate('D, d M Y H:i:s', time()+ (self::$cache_life * 60)) . ' GMT');
        header('Last-modified: '.gmdate('D, d M Y H:i:s',$_SERVER['REQUEST_TIME']).' GMT');
        header_remove('Pragma');

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

            return $this->loadFromDisk();

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

                    $last_modified_time = filemtime(self::$cacheDir . $file);
                    $etag = md5_file(self::$cacheDir . $file);

                    header("Last-Modified: ".gmdate("D, d M Y H:i:s", $last_modified_time)." GMT");
                    header("Etag: $etag");

                    if (@strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $last_modified_time ||
                        @trim($_SERVER['HTTP_IF_NONE_MATCH']) == $etag) {
                        header("HTTP/1.1 304 Not Modified");
                        exit;
                    }

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