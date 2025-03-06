<?php

namespace SummerNoteIU;

class SummerNoteIU
{
    public static function imageUpload($image,$dir)
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
                $image_url = $dir. DIRECTORY_SEPARATOR . time() . $item . '.png';
                if(!is_dir($dir)){
                    mkdir($dir);
                }
                file_put_contents($image_url, $imgeData);
                $image->removeAttribute('src');
                $image->setAttribute('src', $image_url);
            }
        }
        $res = $dom->saveHTML();
        return $res;
    }
}