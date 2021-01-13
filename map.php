<html>
    <head>
        <meta charset="UTF-8">
        <meta name = "viewport" content = "width = device-width, initial-scale = 1">
        <link href="boostrap/bootstrap-3.3.7-dist/css/bootstrap.css" rel="stylesheet">
        <link href="boostrap/bootstrap-3.3.7-dist/css/bootstrap-theme.css" rel="stylesheet">
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC_jmFmMSkp7C5AJdFmjMPR9zdusZESqkA&callback=initMap"></script>
        <link type = "text/javascript" href="/boostrap/bootstrap-3.3.7-dist/js/bootstrap.js">
        <script src="javaScripts.js"></script>
        <link rel="stylesheet" type="text/css" href="style.css"/>
        <title>❆Covid-19❆</title>
    </head>
    <body onload="initMap()">
        <div class="queries_form" style="width: 90%;margin: auto;">
            <h1 class="title_table center-text">Map of Records</h1>
            <div style="width: 100%;margin: auto;text-align: center;" >
                <a style="width: 7%;margin-top: 1%;margin-bottom: 1%" href="index.php" class="btn btn-primary">New Query</a>
            </div>

            <div id="map"></div>
            <?php
            $host = "localhost:27017";
            $userdb = "covid-19"; // this is the database
            $database = $userdb . ".covid_record";   // this is the database with collection 
            $manager = new MongoDB\Driver\Manager("mongodb://{$host}/{$userdb}");

            $filter = [];

            // array with the dataset columns
            $option = [
                'projection' => [
                    'Country_Region' => '$Country_Region',
                    'Lat' => '$Lat',
                    'Long_' => '$Long_',
                    'Confirmed' => '$Confirmed',
                    'Deaths' => '$Deaths',
                    'Recovered' => '$Recovered',
                    'Active' => '$Active',
                    '_id' => 0 // means don't show the _id field in the results
                ],
            ];


            if ($manager) {
                $query = new MongoDB\Driver\Query($filter, $option);
                $cursor = $manager->executeQuery($database, $query);

                // show start of table with headers  
                echo "<table  id='dataTable' border='2' style='display:none;  > <tr>";
                echo "
                <th>Country_Region</th>
                                    <th>Confirmed</th>
                                    <th>Deaths</th>
                                    <th>Recovered</th>
                                    <th>Active</th>
                                    <th>Lat</th>
                                    <th>Long</th>";
                echo "</tr>";

                // show records in table for each row
                foreach ($cursor as $r) { // this gives an stdclass for each records
                    $result = json_decode(json_encode($r), true); // convert stdClass object to array!
                    echo "<tr>";
                    echo "<td>" . $result['Country_Region'] . "</td>";
                    echo "<td>" . $result['Confirmed'] . "</td>";
                    echo "<td>" . $result['Deaths'] . "</td>";
                    echo "<td>" . $result['Recovered'] . "</td>";
                    echo "<td>" . $result['Active'] . "</td>";
                    echo "<td>" . $result['Lat'] . "</td>";
                    echo "<td>" . $result['Long_'] . "</td>";
                    echo "</tr>";
                }
                echo "<table>";
            }
            ?>
        </div>
    </body>  
</html>

