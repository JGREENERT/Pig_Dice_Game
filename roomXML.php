<?php
$link = mysqli_connect("cis.gvsu.edu", "greenerj", "greenerj1234", "greenerj");

if(mysqli_connect_errno()){
    echo mysqli_connect_error();
    exit();
}

$results = mysqli_query($link, "SELECT id, ownerName
    FROM Rooms")
or die(mysqli_error($link));

if($results->num_rows == 0)
    echo "no data";

/*Creating XML*/
$xmlData = "<?xml version='1.0'?>";
$xmlData = $xmlData."<?xml-stylesheet type='text/xsl' href='openRoomsStyle.xsl'?>";
$xmlData = $xmlData."<!DOCTYPE rooms SYSTEM 'openRoomsDTD.dtd'>";
$xmlData = $xmlData."<rooms>";
while($row = mysqli_fetch_assoc($results))
{
    $xmlData = $xmlData."<room>";
    $xmlData = $xmlData."<owner>";
    $xmlData = $xmlData.$row['ownerName'];
    $xmlData = $xmlData."</owner>";
    $xmlData = $xmlData."<id>";
    $xmlData = $xmlData.$row['id'];
    $xmlData = $xmlData."</id>";
    $xmlData = $xmlData."</room>";
}
$xmlData = $xmlData."</rooms>";

/*Creating xHTML*/
$xml = new DOMDocument();
$xml->loadXML($xmlData);
$xsl = new DOMDocument();
$xsl->load('openRoomsStyle.xsl');
$proc = new XSLTProcessor();
$proc->importStylesheet($xsl);
echo $proc->transformToXml($xml);