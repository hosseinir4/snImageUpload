<?php

namespace SummerNoteIU;

class SummerNoteIU
{
    public static function imageUpload($image,$dir,$url)
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
                $image_dir = $dir. DIRECTORY_SEPARATOR . $image_name;
                $image_url = $url.'/'.$image_name;
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