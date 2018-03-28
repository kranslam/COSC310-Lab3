<!DOCTYPE html>
<html>

<p>Here are some results:</p>

<?php

$host = "localhost";
$database = "mfac";
$user = "mfac";
$password = "v9KdEMGL";

$connection = mysqli_connect($host, $user, $password, $database);

$error = mysqli_connect_error();
if($error != null)
{
  $output = "<p>Unable to connect to database!</p>";
  exit($output);
}
else
{
    //variable list
    $gender=(isset($_POST['gender']) ? $_POST['gender'] : null);
    $age=(isset($_POST['age']) ? $_POST['age'] : null);
    $providesServicesToDemographic16to18=0;
    $providesServiceToDemographic19=0;
    $providesServiceToDemographic55=0;
    $providesServiceToOtherDemographic=0;
    if($age=='under19'){
      $providesServicesToDemographic16to18=1;
    }
    elseif ($age=='over19') {
      $providesServiceToDemographic19=1;
    }
    elseif ($age=='Senior') {
      $providesServiceToDemographic55=1;
    }
    else {
      $providesServiceToOtherDemographic=1;
    }
    $suitablefor=(isset($_POST['group']) ? $_POST['group'] : null);
    $individual=0;
    $couples=0;
    $family=0;
    $othergroup=0;
    if($suitablefor=='individual'){
      $individual=1;
    }
    elseif ($suitablefor=='couples') {
      $couples=1;
    }
    elseif ($suitablefor=='family') {
      $family=1;
    }
    else {
      $othergroup=1;
    }
    $availableNow=(isset($_POST['availableNow']) ? 0 : 1);
    $BuildingType=(isset($_POST['BuildingType']) ? $_POST['BuildingType'] : null);
    $buildingdisability=(isset($_POST['buildingdisability']) ? 1 : 0);
    $unitdisability=(isset($_POST['unitdisability']) ? 1 : 0);
    $rgi=(isset($_POST['rgi']) ? 1 : 0);
    $cost=(isset($_POST['cost']) ? $_POST['cost'] : null);
    $PetFriendly=(isset($_POST['PetFriendly']) ? 1 : 0);
    $drugalcoholtolerance=(isset($_POST['zerodrugs']) ? 1 : 0);

    //query

    $sql = "SELECT  DISTINCT * FROM mfac WHERE unitsAreRGI=$rgi OR genderServed LIKE '%$gender%' OR
    residentsAreRequiredToAbstainFromAlcoholAndDrugs=$drugalcoholtolerance OR buuildingIsPetFriendly=$PetFriendly OR
    providesServicesToDemographic16to18=$providesServicesToDemographic16to18 OR
    providesServiceToDemographic19=$providesServiceToDemographic19 OR
    providesServiceToDemographic55=$providesServiceToDemographic55 OR
    providesServiceToOtherDemographic=$providesServiceToOtherDemographic OR
    primaryTargetResidentsAreIndividuals=$individual OR primaryTargetResidentsAreFamilies=$family OR monthlyCostOfStay LIKE '%$cost%'
    OR buildingType LIKE '%$BuildingType%' OR hasWaitingList=$availableNow ;";
    $results = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_assoc($results))
    {
      echo "<p>id is: ".$row['id']."<br>item owner name: ".$row['itemOwnerName']."<br>item owner email: ".
      $row['itemOwnerEmail']."<br>providesServiceToMales: ".
      $row["providesServiceToMales"]."<br>providesServiceToFemales: ".
      $row['providesServiceToFemales']."<br>providesServiceToTransgender: ".$row['providesServiceToTransgender'].
      "<br>providesServicesToDemographic16to18: ".$row['providesServicesToDemographic16to18'].
      "<br>providesServiceToDemographic19: ".$row['providesServiceToDemographic19'].
      "<br>providesServiceToDemographic55: ".$row['providesServiceToDemographic55'].
      "<br>providesServiceToOtherDemographic: ".$row['providesServiceToOtherDemographic'].
      "<br>primaryTargetResidentsAreIndividuals: ".$row['primaryTargetResidentsAreIndividuals'].
      "<br>primaryTargetResidentsAreFamilies: ".$row['primaryTargetResidentsAreFamilies'].
      "<br>availableNow: ".$row['hasWaitingList']."<br>buildingType: ".$row['buildingType'].
      "<br>buildingdisability: ".$row['buildingAccommodatedIndividualsWithDisabilites']."<br>unitdisability".$row['someUnitsAccommodateIndividualsWithDisabilities'].
      "<br>rgi".$row['unitsAreRGI']."<br>cost: ".$row['monthlyCostOfStay']."<br>petfriendly: ".$row['buuildingIsPetFriendly'].
      "<br>levelOfDrugsAndAlcoholTolerence: ".$row['residentsAreRequiredToAbstainFromAlcoholAndDrugs']."</p>";

    }
    mysqli_free_result($results);
    mysqli_close($connection);

}
?>
</html>
