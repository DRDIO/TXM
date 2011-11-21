<?php define("ROOT", TRUE);

include_once("../includes/header_ajax.php");

$success = "";
$error = "";
$uid = "gi" . $SITE["user"]["id"] . ".gif";
$filename = "";
    
if(isset($_FILES["icon"]) === TRUE)
{    
    $success = "0";
    $type_prefix = array("gif", "jpg", "png");
    $save = $SITE["level"] . "media/temp/" . $uid;
    $filename = $_FILES["icon"]["name"];
    
    $attributes = getimagesize($_FILES["icon"]["tmp_name"]);
    $width = intval($attributes[0]);
    $height = intval($attributes[1]);
    $type = intval($attributes[2]);
    
    if($type >= 1 && $type <= 3)
    {
        if($type === 1) 
        {
            $source = imagecreatefromgif($_FILES["icon"]["tmp_name"]);
        }
        else if($type === 2) 
        {
            $source = imagecreatefromjpeg($_FILES["icon"]["tmp_name"]);
        }
        else
        {
            $source = imagecreatefrompng($_FILES["icon"]["tmp_name"]);
        }
    
        if($height == 0)
        {
            $height = $input['file_height'] * $width / $input['file_width'];
        }
        
        $divisor = min($width, $height);
            
        $destination = imagecreatetruecolor(50, 50);
                
        imagecopyresampled($destination, $source, 0, 0, floor(($width - $divisor) / 2), floor(($height - $divisor) / 2), 50, 50, $divisor, $divisor);
        imagegif($destination, $save);        
        chmod($save, 0644);
        imagedestroy($source);
        imagedestroy($destination);
        
        $success = "1";
    }
    else
    {
        $error = "Icon must be (.GIF, .JPG, .PNG).";
    }
}

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <body style="background: none; margin: 0px; padding: 0px; overflow: hidden;">
    <form id="upload-icon-form" action="" method="post" enctype="multipart/form-data">
      <input type="file" id="upload-icon-file" name="icon" onchange="upload();" style="font: 12px Arial; width: 200px; padding: 1px; height: 21px;" />
    </form>
    
    <script type="text/javascript" language="javascript1.2">
            var form, file, up, iframe, status, uid, image, temp;
            var success = "<?php echo $success; ?>";
            
      function upload()
      {
                parent.icon_status = 2; 
                status.innerHTML = "Uploading " + file.value.substring(file.value.lastIndexOf('\\') + 1) + "...";
                form.submit();
      };
            
            window.onload = function()
            {
                up = parent.document;
                iframe = up.getElementById("upload-icon-iframe");
                status = up.getElementById("upload-icon-status");
                uid = up.getElementById("upload-icon-uid");
                image = up.getElementById("upload-icon-image");
                temp = up.getElementById("icon_temp");
                form = document.getElementById("upload-icon-form");
                file = document.getElementById("upload-icon-file");

                if(success == "")
                {
                    if(temp.value != "")
                    {
                        success = "1";
                    }
                }
                else
                {
                    temp.value = "<?php echo $filename; ?>";
                }
                                
                if(success == "0")
                {
                    parent.icon_status = 0; 
                    status.innerHTML = "Cannot upload icon. Try again.<br /><?php echo $error; ?>";
                }
                else if(success == "1")
                {
                    parent.icon_status = 1; 
                    iframe.style.display = "none";
                    status.innerHTML = "<strong>" + temp.value + "</strong><br />Game icon uploaded! <a href=\"\" onclick=\"parent.icon_status = 0; return show_iframe('icon');\">Update?</a>";
                    image.src = "<?php echo $SITE["fauxlvl"] . "media/temp/" . $uid . "?r=" . time(); ?>";
                };
            }; 
    </script>
  </body>
</html>