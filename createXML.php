<?php
$link = mysqli_connect("cis.gvsu.edu", "greenerj", "greenerj1234", "greenerj");

if(mysqli_connect_errno()){
    echo mysqli_connect_error();
    exit();
}

$results = mysqli_query($link, "SELECT uName
    FROM Users
    WHERE loggedOn='1'")
or die(mysqli_error($link));

if($results->num_rows == 0)
    echo "no data";

/*Creating XML*/
$xmlData = "<?xml version='1.0'?>";
$xmlData = $xmlData."<?xml-stylesheet type='text/xsl' href='onlinePlayersStyle.xsl'?>";
$xmlData = $xmlData."<!DOCTYPE users SYSTEM 'users.dtd'>";
$xmlData = $xmlData."<users>";
while($row = mysqli_fetch_assoc($results))
{
    $xmlData = $xmlData."<user>";
        $xmlData = $xmlData."<username>";
        $xmlData = $xmlData.$row['uName'];
        $xmlData = $xmlData."</username>";
    $xmlData = $xmlData."</user>";
}
$xmlData = $xmlData."</users>";

/*Creating xHTML*/
$xml = new DOMDocument();
$xml->loadXML($xmlData);
$xsl = new DOMDocument();
$xsl->load('onlinePlayersStyle.xsl');
$proc = new XSLTProcessor();
$proc->importStylesheet($xsl);
echo $proc->transformToXml($xml);

