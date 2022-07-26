<?php

// Calculate the present day Date
$presentDate = date("mdY");
// Calculate the present day filename
$filename = "testLogs_". $presentDate. ".txt";
if (!file_exists($filename)) {
    // Calculate the yesterday Date
    $yesterdayDate = date("mdY", strtotime("yesterday"));
    // Calculate the yesterday filename
    $filename = "testLogs_". $yesterdayDate. ".txt";
}
if (!file_exists($filename)) {
    echo "The text file for present date and yesterday date are not exist.";
    die();
}

// Read current date file
$myfile = fopen($filename, "r") or die("Unable to open the file!");
// Read first line of the file to get all column names
$line = fgets($myfile);                                                                                 
// Convert the text into UTF-8
$line = mb_convert_encoding($line, 'UTF-8');
// Check if the first line is empty or not
if(trim($line) != "") {
    // Store all the column names into an Array.
    $columnNames = (explode("|",$line));
    // print_r($columnNames);
}
else {
    echo "First line of the text file <b>".$filename."</b> is blank.";
    die();
}

// Get required columns index
// Change the columnNames values as per your text file
$key = array_keys($columnNames,"Company Name",true);
$accountNameKey = $key[0];
$key = array_keys($columnNames,"Firstname",true);
$firstNameKey = $key[0];
$key = array_keys($columnNames,"Lastname",true);
$lastNameKey = $key[0];
$key = array_keys($columnNames,"Zip Code",true);
$postalCodeKey = $key[0];
$key = array_keys($columnNames,"Phone",true);
$phoneKey = $key[0];

// Initialize empty array with root "data"
$array = array( 'data' => array() );
$n = 0;

// Read data rows
while(!feof($myfile)) {
    $row = fgets($myfile);
    // Convert the text into UTF-8
    $row = mb_convert_encoding($row, 'UTF-8');
    // Check empty rows
    if(trim($row) != "") {
        // Store the row data into an Array.
        $rowDetail = (explode("|",$row));
        // Find respective column values
        $accountName = $rowDetail[$accountNameKey];
        $firstName = $rowDetail[$firstNameKey];
        $lastName = $rowDetail[$lastNameKey];
        $postalCode = $rowDetail[$postalCodeKey];
        $phone = $rowDetail[$phoneKey];

        $array['data'][$n]['Company Name'] = $accountName;
        $array['data'][$n]['Firstname'] = $firstName;
        $array['data'][$n]['Lastname'] = $lastName;
        $array['data'][$n]['Zip Code'] = $postalCode;
        $array['data'][$n]['Phone'] = $phone;
        $n++;
    }
}
echo(json_encode( $array ));

// Close the file.
fclose($myfile);
?>