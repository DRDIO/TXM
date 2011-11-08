<?

header("Content-type: image/gif");

$file = 'avatars/' . $u . '.gif';
$t = 1;

if (!file_exists($file)) 
{
    $file = 'randoms/1.png';
    $t = 3;
}

$base = imagecreatetruecolor(45, 45);
$image = ($t == 1) ? imagecreatefromgif($file) : imagecreatefrompng($file);
$cover = imagecreatefromgif('resample.gif');

list($width, $height) = getimagesize($file);                                         
imagecopyresampled($base, $image, 0, 0, 0, 0, 45, 45, $width, $height);
imagecopy($base, $cover, 0, 0, 0, 0, 45, 45);

imagegif($base);
imagedestroy($base);    

?>