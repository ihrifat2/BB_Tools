<?php
error_reporting(0);
$result = array();
$result_html = '';
if (isset($_POST['domain']) && !empty($_POST['domain'])) {
    $domain_regex = '/[a-z\d][a-z\-\d\.]+[a-z\d]/i';
    if (preg_match($domain_regex, $_POST['domain'])) {
        if ($url = parse_url($_POST['domain'])) { //compatible when user post an url instead of a domain
            if (isset($url['host'])) {
                $result = dns_get_record($url['host'], DNS_A + DNS_AAAA + DNS_CNAME);
            } else if (isset($url['path'])) {
                $result = dns_get_record($url['path'], DNS_A + DNS_AAAA + DNS_CNAME);
            }
        }
    }
    if (empty($result)) {
        $result_html = '<hr>Nothing found or Domain Invalid';
    } else {
        foreach($result as $r) {
            reset($r);
            $host = current($r);
            $type = next($r);
            $value = next($r);
            $result_html .= sprintf("<tr><td>%s</td><td>%s</td><td>%s</td></tr>\n", $host, $type, $value);
        }
        $result_html = "<hr>\n<table class='table table-hover table-bordered'>\n<tr><th>Cname</th><th>Class</th><th>TTL</th></tr>\n$result_html</table>\n";
    }
}
?><!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Raw Dns Lookup</title>
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
            <h1>Raw Dns Lookup</h1>
            <div class="row justify-content-md-center">
                <form class="form-inline" method="post">
                    <!-- <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">Domain</span>
                        </div>
                        <input type="text" class="form-control" id="domain" aria-describedby="basic-addon3" name="domain" value="<?=empty($_POST['domain'])?'':$_POST['domain']?>">
                        <button type="submit" class="btn btn-primary form-control">Dig</button>
                    </div> -->
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="inputDomain" class="mr-2">Domain</label>
                        <input type="text" class="form-control" id="domain" name="domain" value="<?=empty($_POST['domain'])?'':$_POST['domain']?>">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Dig</button>
                </form>
            </div>
            <center>
                <?=$result_html?$result_html:''?>
            </center>
            <hr/>
            <p>Server Location:
                <?php
                    $geo = json_decode(file_get_contents("http://freegeoip.net/json/".$_POST['domain']));
                    echo $geo->country_name;
                    echo "<br>IP : " . $geo->ip;
                ?>
                <br/>
                <span>Powered by <a href="http://weibo.com/horsley" title="Developer：horsley" target="_blank">Horsley</a></span>
            </p>
        </section>
    </main>
</body>
</html>