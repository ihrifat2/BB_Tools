<!DOCTYPE html>
<html>
<body>

	<form action="" method="post" enctype="multipart/form-data">
	    Select image to upload:
	    <input type="file" name="fileToUpload" id="fileToUpload">
	    <input type="submit" value="Upload Image" name="submit">
	</form>

</body>
</html>
<?php

if(isset($_POST["submit"])) {
	$target_dir = "uploads/";
	$txtfilename = $_FILES["fileToUpload"]["name"];
	$target_file = $target_dir . basename($txtfilename);
	$data = array();
	$txtdata = array();
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if($imageFileType != "txt") {
	    echo "Sorry, only txt files are allowed.";
		echo "<br>";
	} else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			$file = fopen($target_file, "r") or die("Unable to open file!");
			while(!feof($file)) {
			  	$data[] = fgets($file);
			  	ksort($data);
			  	$data = array_unique($data);
			  	$data = array_values($data);
			}
			fclose($file);
			$arrlength = count($data);
			for($x = 0; $x < $arrlength; $x++) {
			    if ($data[$x] != NULL || $data[$x] != '') {
			    	echo $data[$x] . "<br>";
			    }
			}
			//echo "<br>";
	        echo "The file ". basename( $txtfilename). " has been uploaded.";
	    } else {
	    	echo "<br>";
	        echo "Sorry, there was an error uploading your file.";
	    }
	}
}

?>