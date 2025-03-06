<?php

namespace SummerNoteIU;

class SummerNoteIU
{
    public static function imageUpload($image,$folder)
    {
        $dom = new \DomDocument();
        @$dom->loadHtml('<meta http-equiv="Content-Type" content="text/html; charset=utf-8">' .$image);
        $imageFile = $dom->getElementsByTagName('img');

        foreach ($imageFile as $item => $image) {
            $data = $image->getAttribute('src');
            if(str_contains($data,'base64')) {
                list($type, $data) = explode(';', $data);
                list(, $data) = explode(',', $data);
                $imgeData = base64_decode($data);
                $image_name = time() . $item . '.png';
                $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                $url = $protocol . $_SERVER['HTTP_HOST'];
                $dir = $_SERVER['DOCUMENT_ROOT']. DIRECTORY_SEPARATOR .$folder;
                $image_dir = $dir. DIRECTORY_SEPARATOR . $image_name;
                $image_url = $url.DIRECTORY_SEPARATOR.$folder. DIRECTORY_SEPARATOR .$image_name;
                if(!is_dir($dir)){
                    mkdir($dir);
                }
                file_put_contents($image_dir, $imgeData);
                $image->removeAttribute('src');
                $image->setAttribute('src', $image_url);
            }
        }
        $res = $dom->saveHTML();
        return $res;
    }
}