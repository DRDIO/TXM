<?php define("ROOT", TRUE);

include_once("../includes/header_ajax.php");

$success = "";
$error = "";
$uid = "gs" . $SITE["user"]["id"] . ".swf";
$filename = "";
    
if(isset($_FILES["swf"]) === TRUE)
{    
    $success = "0";
    $type_prefix = array("gif", "jpg", "png");
    $save = $SITE["level"] . "media/temp/" . $uid;
    $filename = $_FILES["swf"]["name"];
    
    $attributes = getimagesize($_FILES["swf"]["tmp_name"]);
    $type = intval($attributes[2]);
    
    if($type === 4 || $type === 13)
    {
        if(filesize($_FILES["swf"]["tmp_name"]) <= 10240000)
        {
            move_uploaded_file($_FILES["swf"]["tmp_name"], $save);
            chmod($save, 0644);
            $success = "1";
        }
        else
        {
            $error = "Game file must be under 8 MB.";
        }
    }
    else
    {
        $error = "Game file must be (.SWF).";
    }
}

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <body style="background: none; margin: 0px; padding: 0px; overflow: hidden;">
    <form id="upload-swf-form" action="" method="post" enctype="multipart/form-data">
      <input type="file" id="upload-swf-file" name="swf" onchange="upload();" style="font: 12px Arial; width: 200px; padding: 1px; height: 21px;" />
    </form>
    
    <script type="text/javascript" language="javascript1.2">
            var form, file, up, iframe, status, uid, image, temp;
            var success = "<?php echo $success; ?>";
            
      function upload()
      {
                parent.file_status = 2;
                status.innerHTML = "Uploading " + file.value.substring(file.value.lastIndexOf('\\') + 1) + "...";
                form.submit();
      };
            
            window.onload = function()
            {
                up = parent.document;
                iframe = up.getElementById("upload-swf-iframe");
                status = up.getElementById("upload-swf-status");
                uid = up.getElementById("upload-swf-uid");
                image = up.getElementById("upload-swf-image");
                temp = up.getElementById("file_temp");
                form = document.getElementById("upload-swf-form");
                file = document.getElementById("upload-swf-file");
                
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
                    parent.file_status = 0;
                    status.innerHTML = "Cannot upload file. Try again.</a><br /><?php echo $error; ?>";
                }
                else if(success == "1")
                {
                    parent.file_status = 1;
                    iframe.style.display = "none";
                    status.innerHTML = "<strong>" + temp.value + "</strong><br />Game file uploaded! <a href=\"\" onclick=\"parent.file_status = 0; return show_iframe('swf');\">Update?</a>";
                    image.src = "<?php echo $SITE["fauxlvl"] . "media/assets/movies-swf.gif?r=" . time(); ?>";
                };
            }; 
    </script>
  </body>
</html>