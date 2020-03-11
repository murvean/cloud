<?php

$url = "https://api.ibb.gov.tr/ispark/Park";

$data = $page = file_get_contents($url);

$js = json_decode($data,true);

$op = $_GET['op'];
if ($op == "listDistrict")
{
    $districtList = array();
    foreach($js as $row)
    {
        $district = $row['Ilce'];
        if (!in_array($district, $districtList))
        {
            $districtList[] = $district;
        }
    }
    
    sort($districtList);
    
    header("Content-Type: application/json");
    echo json_encode($districtList, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}

if ($op == "listPark")
{
    $districtName = $_GET['districtName'];
    
    $parkList = array();
    foreach($js as $row)
    {
        $park = $row;
        if ($park['Ilce'] == $districtName)
        {
            $parkList[] = $park;
        }
    }
    
    
    
    header("Content-Type: application/json");
    echo json_encode($parkList, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}

?>