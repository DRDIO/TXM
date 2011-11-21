<?

if(isset($_POST['submit']))
{
    $avatar_input = array(
        'title'                => 'avatar',
        'user_id'            => 3,
        'method'            => !empty($_POST['avatar_remote_url']) ? 'remote' : (!empty($_FILES['avatar_local']['tmp_name']) ? 'local' : ''),
        'url'                    => $_POST['avatar_remote_url'],
        'temp_name'     => $_FILES['avatar_local']['tmp_name'],
        'temp_size'        => $_FILES['avatar_local']['size'],
        'temp_error'    => $_FILES['avatar_local']['error'],
    ); 
    
    image_receive($avatar_input, 100, 100, $error_cause);

    $photo_input = array(
        'title'                => 'photo',
        'user_id'            => 3,
        'method'            => !empty($_POST['photo_remote_url']) ? 'remote' : (!empty($_FILES['photo_local']['tmp_name']) ? 'local' : ''),
        'url'                    => $_POST['photo_remote_url'],
        'temp_name'     => $_FILES['photo_local']['tmp_name'],
        'temp_size'        => $_FILES['photo_local']['size'],
        'temp_error'    => $_FILES['photo_local']['error'],
    ); 
    
    image_receive($photo_input, 210, 0, $error_cause);
        
    echo "<IMG SRC='avatars/3.gif'><BR><IMG SRC='photos/3.gif'>";
}
else
{
    echo "
        <FORM NAME='form' enctype='multipart/form-data' action='' method='POST'>
            <INPUT TYPE='text' NAME='avatar_remote_url' SIZE='26'><BR>
            <INPUT TYPE='file' NAME='avatar_local' SIZE='26'><BR>
            
            <INPUT TYPE='text' NAME='photo_remote_url' SIZE='26'><BR>
            <INPUT TYPE='file' NAME='photo_local' SIZE='26'><BR>
            
            <INPUT TYPE='submit' NAME='submit' CLASS='admin' STYLE='font-weight: bold; width: 160px' VALUE='Update Screenshot'>
        </FORM>
    ";
}

function image_receive($input, $width, $height, &$error_cause)
{
    $type_prefix = array('gif', 'jpg', 'png');                                                             
    $error_list = array ('', 'exceeds the upload_max_filesize directive.', 'exceeds the MAX_FILE_SIZE directive.', 'was only partially uploaded.', 'was not uploaded.', '', 'is missing a temporary folder.');
    $file_save = $input['title'] . 's/' . $input['user_id'] . '.gif';
    
    // If bootleg is a remote image
    if($input['method'] === 'remote')
    {
        // Determine if link is a valid image resource
        if (preg_match('/([a-z0-9_.!~*()%\/?:@&+$,-]+?)\.(jpg|gif|jpeg|png)/i', $input['url'], $matches))
        {
            $input['url'] = $matches[0];
            
            if (preg_match('/^(http:\/\/)?([\w\-\.]+)\:?([0-9]*)\/(.*)$/', $matches[0], $url_ary))
            {
                if (empty($url_ary[4]))
                {
                    return 'You have provided an incomplete remote ' . $input['title'] . ' link.<BR>';
                }
                else
                {
                    // If link is valid then fsocket the image to download in chunks
                    $base_get = '/' . $url_ary[4];
                    $port = !empty($url_ary[3]) ? $url_ary[3] : 80;
            
                    if (!($fsock = @fsockopen($url_ary[2], $port, $errno, $errstr)))
                    {
                        return 'We are unable to connect to your remote ' . $input['title'] . '.<BR>';
                    }
                    else
                    {
                        @fputs($fsock, "GET $base_get HTTP/1.1\r\n");
                        @fputs($fsock, "HOST: " . $url_ary[2] . "\r\n");
                        @fputs($fsock, "Connection: close\r\n\r\n");
                
                        $avatar_data = '';
                        while(!@feof($fsock))
                        {
                            $avatar_data .= @fread($fsock, 8192);
                        }
                        @fclose($fsock);
            
                        if (!preg_match('/Content-Length\: ([0-9]+)[^\/ ][\s]+/i', $avatar_data, $file_data1) || !preg_match('/Content-Type\: image\/[x\-]*([a-z]+)[\s]+/i', $avatar_data, $file_data2))
                        {
                            return 'Your remote ' . $input['title'] . ' contains no data.<BR>';
                        }
                        else
                        {
                            // Save the remote bootleg into a temporary file similar to the _FILE routine
                            $avatar_filesize = $file_data1[1]; 
                            $avatar_filetype = $file_data2[1]; 
                    
                            if (!$error_cause && $avatar_filesize > 0)
                            {
                                $avatar_data = substr($avatar_data, strlen($avatar_data) - $avatar_filesize, $avatar_filesize);
                    
                                $tmp_filename = 'tmp/' . time() . rand(0, 1000);
                    
                                $fptr = fopen($tmp_filename, 'wb');
                                $bytes_written = fwrite($fptr, $avatar_data, $avatar_filesize);
                                fclose($fptr);
                                
                                if ($bytes_written != $avatar_filesize)
                                {
                                    unlink($tmp_filename);
                                    return 'Could not write ' . $input['title'] . ' file to local storage.<BR>';
                                }
                    
                                $input['file_temp']             = $tmp_filename;
                                $input['file_size']                = $avatar_filesize;
                                
                                $temp_size                                 = getimagesize($input['file_temp']);    
                                $input['file_width']             = intval($temp_size[0]);
                                $input['file_height']         = intval($temp_size[1]); 
                                $input['file_type']                = intval($temp_size[2]);
                            }
                            else
                            {
                                return 'Your remote ' . $input['title'] . ' is corrupt.<BR>';
                            }
                        }
                    }
                }
            }
        }
        else
        {
            return 'You have provided an invalid remote ' . $input['title'] . ' link.<BR>';
        }
    }
    else if($input['method'] === 'local')
    {
        if($input['temp_error'] == 0)     
        {
            $input['file_temp']             = !empty($input['temp_name']) ? $input['temp_name']                                  : '';
            $input['file_size']                = !empty($input['temp_size']) ? round($input['temp_name'] / 1024, 0) : 0;
            
            $temp_size                                 = getimagesize($input['file_temp']);    
            $input['file_width']             = intval($temp_size[0]);
            $input['file_height']         = intval($temp_size[1]); 
            $input['file_type']                = intval($temp_size[2]);
        }
        else
        {
            return 'File ' . $error_list[$input['temp_error']] . '<BR>';
        }
    }
    
    if($input['file_type'] > 3)
    {
        return 'The file must be a GIF, JPG, or PNG.<BR>';
    }
    
    // Begin saving either the avatars or the photos
    
    if($input['method'] === 'remote')
    {
        copy($input['file_temp'], $file_save);
        unlink($input['file_temp']);
    }
    else
    {
        move_uploaded_file($input['file_temp'], $file_save);
    }
    
    @chmod($file_save, 0644);
                
    if($input['file_type'] == 1) $image_user = imagecreatefromgif($file_save);
    else if($input['file_type'] == 2) $image_user = imagecreatefromjpeg($file_save);
    else if($input['file_type'] == 3) $image_user = imagecreatefrompng($file_save);

    if($height == 0)
    {
        $height = $input['file_height'] * $width / $input['file_width'];
    }
        
    $image_temp = imagecreatetruecolor($width    , $height);
    imagecopyresampled($image_temp, $image_user, 0, 0, 0, 0, $width, $height, $input['file_width'], $input['file_height']);
    imagegif($image_temp, $file_save);        
    imagedestroy($image_temp);
    imagedestroy($image_user);
            
    return true;
}
    
?>