<!Doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>CLickJacking Checker</title>
    <link href="../asset/bootstrap.min.css" rel="stylesheet">
    <link href="../asset/album.css" rel="stylesheet">
    <link rel="stylesheet" href="../asset/style.css">
</head>
<body>

    <main role="main">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
            <a class="navbar-brand" href="#">BBHelper</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                </ul>
            </div>
        </nav>
        <section class="jumbotron text-center mt-4">
            <div class="container">
                <h1 class="jumbotron-heading">Sub-Domains CLickJacking Checker</h1>
                <form method="post" enctype="multipart/form-data">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="fileToUpload">
                        <label class="custom-file-label">Choose file</label>
                        <button class="btn btn-outline-success mt-2" type="submit" name="btn-list">Submit</button>
                    </div>
                </form>
            </div>
        </section>
        <?php 
            $data = array();
            if (isset($_POST['btn-list'])) {
                $target_dir = "uploads/";
                $txtfilename = $_FILES["fileToUpload"]["name"];
                $target_file = $target_dir . basename($txtfilename);
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
                        }
                        $url = $data[0];
                        $dotCount = substr_count($url, '.');
                        $dotLoop = $dotCount - 1;
                        $domain = domainfinder($url, $dotCount, $dotLoop);
                        $domain = trim($domain);
                        $domain = $domain . ".txt";
                        fclose($file);
                        rename("uploads/".$txtfilename, "uploads/".$domain);
                        echo "<br>";
                        echo "The file ". basename($domain). " has been uploaded.";
                    } else {
                        echo "<br>";
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
            }
            function domainfinder($url, $count, $loop)
            {
                $domain = explode('.',$url,$count);
                return $domain[$loop];
            }
        ?>
        <div class="album py-5 bg-light">
            <div class="container-fluid">
                <div class="row">
                    <?php
                        $arrlength = count($data);
                        for($x = 0; $x < $arrlength; $x++) {
                            if ($data[$x] != NULL || $data[$x] != '') {
                                echo '<div class="col-sm-6 col-md-4 col-lg-3 mb-3">';
                                echo '<iframe src="http://'.$data[$x].'" width="300px" frameborder="1"></iframe>';
                                echo '<a href="http://'.$data[$x].'" target="_blank">go to</a>';
                                echo "<h6>" . $data[$x] . "</h6>";
                                echo '</div>';
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </main>
    <script src="../asset/bootstrap.min.js"></script>
</body>
</html>