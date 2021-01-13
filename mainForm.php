<html>
    <head>
        <meta charset="UTF-8">
        <meta name = "viewport" content = "width = device-width, initial-scale = 1">
        <link href="boostrap/bootstrap-3.3.7-dist/css/bootstrap.css" rel="stylesheet">
        <link href="boostrap/bootstrap-3.3.7-dist/css/bootstrap-theme.css" rel="stylesheet">
        <link type = "text/javascript" href="/boostrap/bootstrap-3.3.7-dist/js/bootstrap.js">
        <script src="javaScripts.js"></script>
        <link rel="stylesheet" type="text/css" href="style.css"/>
        <title>❆Covid-19❆</title>
    </head>
    <body>
        <div class="queries_form" style="width: 90%;margin: auto;"><!-- Introduction Div to show Title and New Query-->
            <h1 class="title_table center-text">Table of Records</h1>
            <div style="width: 20%;margin: auto;text-align: center;" >
                <a style="width: 100%;margin-top: 1%;margin-bottom: 5%" href="index.php" class="btn btn-primary">New Query</a>
            </div>

            <?php
            /**
             * Check if the Total Checkboxes have been clicked or not
             * If yes - call display totals function
             * i not - call function to display regular list of records
             */
            if (!empty($_POST['total_confirmed']) || !empty($_POST['total_recovered']) | !empty($_POST['total_deaths']) | !empty($_POST['total_active'])) {
                displayTotals();
            } elseif (!empty($_POST['max_confirmed']) || !empty($_POST['max_recovered']) | !empty($_POST['max_deaths']) | !empty($_POST['max_active'])) {
                displayMax();
            } else {
                displayRecords();
            }

            /**
             * Function that displays the regular list of records based on:
             * - countries selected, 1 or 2
             * - Sort By, Order
             * - Conditions 1 or 2 (Equal, Less than, Greater than)
             */
            function displayRecords() {

                // if the order (ascending radio) is checked 
                if (!empty($_POST['order'])) { // "order" is the name of the (radio) in html
                    if ($_POST['order'] === 'ascending') { // "ascending" is the value of the (radio) in html
                        $order = 1; // 1 for ascending
                    }
                    if ($_POST['order'] === 'descending') {
                        $order = -1; // -1 for descending
                    }
                } else {
                    $order = null; // if no order checked do nothing
                }

                // if the (radio) for 'less than' is not checked
                if (empty($_POST['lessthan1'])) {
                    $less_than = 10000000;  // set the default number for less 
                } else {
                    $less_than = (int) $_POST['lessthan1']; // take the inserted value
                }

                // if the (radio) for greater than is not checked
                if (empty($_POST['greaterthan1'])) {
                    $greater_than = 0;  // set the default number for greater than 
                } else {
                    $greater_than = (int) $_POST['greaterthan1']; // take the inserted value
                }

                /**
                 * when is the choice from "where" condition 1 or condition 2 are selected, the according 
                 * columns will appear automatically by default
                 */
                $columns_clicked = $_POST['columns'];
                if (!in_array($_POST['condition1'], $columns_clicked)) {
                    array_push($columns_clicked, $_POST['condition1']); // show the column
                }
                // second condtion only appears if the second equal is filled
                if (!empty($_POST['equal2'])) {
                    if (!in_array($_POST['condition2'], $columns_clicked)) {
                        array_push($columns_clicked, $_POST['condition2']); // show the column
                    }
                }

                // create equal variables to store the equals values inserted
                $equal1 = (double) $_POST['equal1']; // take the inserted value as double number
                $equal2 = (double) $_POST['equal2']; // take the inserted value as double number

                if (empty($_POST["equal1"])) { // if not equal provided
                    if (!empty($_POST["country"])) {   // if there is a country (input box)  selected
                        if (!empty($_POST['second_country'])) { // if there is a second country selected
                            $filter = [
                                '$or' => [// make an 'or' statement to host both countries if second country is slected
                                    [
                                        '$and' => [// use "$and" to combine multiple conditions
                                            [
                                                $_POST['condition1'] => [
                                                    '$lte' => (int) $less_than // condition of less than or equel
                                                ]
                                            ],
                                            [
                                                $_POST['condition1'] => [
                                                    '$gte' => (int) $greater_than // condition of greather than or equel
                                                ]
                                            ],
                                            [
                                                'Country_Region' => $_POST['country'] // condition of country 
                                            ]
                                        ]
                                    ], [
                                        '$and' => [
                                            [
                                                $_POST['condition1'] => [
                                                    '$lte' => (int) $less_than // condition of less than
                                                ]
                                            ],
                                            [
                                                $_POST['condition1'] => [
                                                    '$gte' => (int) $greater_than // condition of greather than
                                                ]
                                            ],
                                            [
                                                'Country_Region' => $_POST['second_country'] // condition of second country 
                                            ]
                                        ]
                                    ]
                                ]
                            ];
                        } else { // if no second country
                            $filter = [
                                // use "$and" to combine multiple conditions
                                '$and' => [
                                    [
                                        $_POST['condition1'] => [
                                            '$lte' => (int) $less_than // condition of less than
                                        ]
                                    ],
                                    [
                                        $_POST['condition1'] => [
                                            '$gte' => (int) $greater_than // condition of greather than
                                        ]
                                    ],
                                    [
                                        'Country_Region' => $_POST['country'] // condition of country 
                                    ]
                                ]
                            ];
                        }
                    } else { // if the country (input box) is not selected then apply less_than and greater_than condtions
                        $filter = [
                            '$and' => [
                                [
                                    $_POST['condition1'] => [
                                        '$lte' => (int) $less_than
                                    ]
                                ],
                                [
                                    $_POST['condition1'] => [
                                        '$gte' => (int) $greater_than
                                    ]
                                ],
                            ]
                        ];
                    }
                } else { // if equal is provided
                    if (empty($_POST["equal2"])) { // if second equal is not provided
                        if (!empty($_POST["country"])) {   // if there is a country (input box)  selected
                            if (!empty($_POST['second_country'])) { // if htere is a second country selected
                                $filter = [
                                    '$or' => [// make an 'or' statement to host both countries if second country is slected
                                        [
                                            '$and' => [// use "$and" to combine multiple conditions
                                                [
                                                    $_POST['condition1'] => [
                                                        '$eq' => (double) $equal1 // condition for equality
                                                    ]
                                                ],
                                                [
                                                    'Country_Region' => $_POST['country'] // condition of country 
                                                ]
                                            ]
                                        ], [
                                            '$and' => [
                                                [
                                                    $_POST['condition1'] => [
                                                        '$eq' => (double) $equal1 // condition for equality
                                                    ]
                                                ],
                                                [
                                                    'Country_Region' => $_POST['second_country'] // condition of second country 
                                                ]
                                            ]
                                        ]
                                    ]
                                ];
                            } else { // if no second country selected
                                $filter = [
                                    // use "$and" to combine multiple conditions
                                    '$and' => [
                                        [
                                            $_POST['condition1'] => [
                                                '$eq' => (double) $equal1 // condition for equality
                                            ]
                                        ],
                                        [
                                            'Country_Region' => $_POST['country'] // condition of country 
                                        ]
                                    ]
                                ];
                            }
                        } else { // if the country (input box) is not selected then apply less_than and greater_than condtions
                            $filter = [
                                '$and' => [
                                    [
                                        $_POST['condition1'] => [
                                            '$eq' => (double) $equal1 // condition for equality
                                        ]
                                    ],
                                ]
                            ];
                        }
                    } else {  // if both equal_1 and equal_2 are provided
                        if (!empty($_POST["country"])) {   // if there is a country (input box)  selected
                            if (!empty($_POST['second_country'])) { // if htere is a second country selected
                                $filter = [
                                    '$or' => [// make an 'or' statement to host both countries if second country is slected
                                        [
                                            '$and' => [// use "$and" to combine multiple conditions
                                                [
                                                    $_POST['condition1'] => [
                                                        '$eq' => (double) $equal1 // condition for equality
                                                    ]
                                                ],
                                                [
                                                    'Country_Region' => $_POST['country'] // condition of country 
                                                ]
                                            ]
                                        ], [
                                            '$and' => [
                                                [
                                                    $_POST['condition1'] => [
                                                        '$eq' => (double) $equal1 // condition for equality
                                                    ]
                                                ],
                                                [
                                                    'Country_Region' => $_POST['second_country'] // condition of second country 
                                                ]
                                            ]
                                        ], [
                                            '$and' => [
                                                [
                                                    $_POST['condition2'] => [
                                                        '$eq' => (double) $equal2 // condition for equality
                                                    ]
                                                ],
                                                [
                                                    'Country_Region' => $_POST['second_country'] // condition of second country 
                                                ]
                                            ]
                                        ], [
                                            '$and' => [
                                                [
                                                    $_POST['condition2'] => [
                                                        '$eq' => (double) $equal2 // condition for equality
                                                    ]
                                                ],
                                                [
                                                    'Country_Region' => $_POST['second_country'] // condition of second country 
                                                ]
                                            ]
                                        ]
                                    ]
                                ];
                            } else { // if  second country is not provided
                                $filter = [
                                    // use "$and" to combine multiple conditions
                                    '$or' => [
                                        [
                                            '$and' => [
                                                [
                                                    $_POST['condition1'] => [
                                                        '$eq' => (double) $equal1 // condition for equality
                                                    ]
                                                ],
                                                [
                                                    'Country_Region' => $_POST['country'] // condition of country 
                                                ]
                                            ]
                                        ], [
                                            '$and' => [
                                                [
                                                    $_POST['condition2'] => [
                                                        '$eq' => (double) $equal2 // condition for equality
                                                    ]
                                                ],
                                                [
                                                    'Country_Region' => $_POST['country'] // condition of country 
                                                ]
                                            ]
                                        ]
                                    ]
                                ];
                            }
                        } else { // if no countries are selected
                            $filter = [
                                '$and' => [// just find recods that serve both conditions
                                    [
                                        '$and' => [
                                            [
                                                $_POST['condition1'] => [
                                                    '$eq' => (double) $equal1 // condition for equality
                                                ]
                                            ],
                                        ]
                                    ],
                                    [
                                        '$and' => [
                                            [
                                                $_POST['condition2'] => [
                                                    '$eq' => (double) $equal2 // condition for equality
                                                ]
                                            ],
                                        ]
                                    ]
                                ]
                            ];
                        }
                    }
                }

                // if no order (ascending or descending) is provided
                if ($order == null) {
                    $option = [
                        'projection' => [
                            'Country_Region' => '$Country_Region',
                            'Admin2' => 'Admin2',
                            'FIPS' => '$FIPS',
                            'Province_State' => '$Province_State',
                            'Lat' => '$Lat',
                            'Long_' => '$Long_',
                            'Confirmed' => '$Confirmed',
                            'Deaths' => '$Deaths',
                            'Recovered' => '$Recovered',
                            'Active' => '$Active',
                            'Last_Update' => '$Last_Update',
                            'FIPS' => '$FIPS',
                            'Incidence_Rate' => '$Incidence_Rate',
                            'Case_Fatality_Ratio' => '$Case_Fatality_Ratio',
                            'COUNT(Confirmed)' => '$COUNT(Confirmed)',
                            '_id' => 0 // means don't show the _id field in the results
                        ],
                        'limit' => $_POST['limit'],
                    ];
                } else { // if sort and order are provided
                    // array with the dataset columns
                    $option = [
                        'projection' => [
                            'Country_Region' => '$Country_Region',
                            'Admin2' => 'Admin2',
                            'FIPS' => '$FIPS',
                            'Province_State' => '$Province_State',
                            'Lat' => '$Lat',
                            'Long_' => '$Long_',
                            'Confirmed' => '$Confirmed',
                            'Deaths' => '$Deaths',
                            'Recovered' => '$Recovered',
                            'Active' => '$Active',
                            'Last_Update' => '$Last_Update',
                            'FIPS' => '$FIPS',
                            'Incidence_Rate' => '$Incidence_Rate',
                            'Case_Fatality_Ratio' => '$Case_Fatality_Ratio',
                            'COUNT(Confirmed)' => '$COUNT(Confirmed)',
                            '_id' => 0 // means don't show the _id field in the results
                        ],
                        'limit' => $_POST['limit'],
                        'sort' => [$_POST['sort_by'] => $order]
                    ];
                }
                $host = "localhost:27017";
                $userdb = "covid-19"; // this is the database
                $database = $userdb . ".covid_record";   // this is the database with collection 
                $manager = new MongoDB\Driver\Manager("mongodb://{$host}/{$userdb}");
                if ($manager) {
                    $query = new MongoDB\Driver\Query($filter, $option);
                    $cursor = $manager->executeQuery($database, $query);

                    // show start of table with headers  
                    echo "<table class = 'table' border='2' style='width: 100%; border: 5px solid black; background: #9fbedf'; >";
                    echo "<thead class='thead-light'> <tr>";
                    if (!empty($columns_clicked)) {
                        foreach ($columns_clicked as $column) {
                            echo "<th>" . $column . "</th>";
                        }
                    } else {
                        echo "  <th>Country_Region</th>
                                    <th>Province_State</th>
                                    <th>Confirmed</th>
                                    <th>Deaths</th>
                                    <th>Recovered</th>
                                    <th>Active</th>
                                    <th>FIPS</th>
                                    <th>Lat</th>
                                    <th>Long</th>";
                    }
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    // show records in table for each row
                    foreach ($cursor as $r) { // this gives an stdclass for each records
                        $result = json_decode(json_encode($r), true); // convert stdClass object to array!
                        echo "<tr>";
                        if (!empty($columns_clicked)) {
                            foreach ($columns_clicked as $column) {
                                echo "<td>" . $result[$column] . "</td>";
                            }
                        } else {
                            echo "<td>" . $result['Country_Region'] . "</td>";
                            echo "<td>" . $result['Province_State'] . "</td>";
                            echo "<td>" . $result['Confirmed'] . "</td>";
                            echo "<td>" . $result['Deaths'] . "</td>";
                            echo "<td>" . $result['Recovered'] . "</td>";
                            echo "<td>" . $result['Active'] . "</td>";
                            echo "<td>" . $result['FIPS'] . "</td>";
                            echo "<td>" . $result['Lat'] . "</td>";
                            echo "<td>" . $result['Long_'] . "</td>";
                        }
                        echo "</tr>";
                        echo "</tbody>";
                    }
                    echo "<table>";
                }
            }

            /**
             * Function to show Totals(selected) of Country (selected)
             * Sums all the records rom the country provided and displays 
             * the sum while also showing the count of records
             */
            function displayTotals() {
                $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017/covid-19");
                if ($manager) {
                    // create a filter that aggregates the records (sum)
                    $filter = ['aggregate' => 'covid_record', 'cursor' => new stdClass,
                        'pipeline' => [
                            ['$match' => ['Country_Region' => $_POST["country"]]], // country selected
                            ['$group' => [
                                    '_id' => '$Country_Region',
                                    'Total_Confirmed' => ['$sum' => '$Confirmed'],
                                    'Total_Deaths' => ['$sum' => '$Deaths'],
                                    'Total_Recovered' => ['$sum' => '$Recovered'],
                                    'count' => ['$sum' => 1],]]],];

                    $command = new MongoDB\Driver\Command($filter);
                    $cursor = $manager->executeCommand('covid-19', $command);

                    echo "<table class = 'table' border='2' style='width: 100%; border: 5px solid black; background: #9fbedf'; >";
                    echo "<thead class='thead-light'> <tr>";
                    echo '<th>Country Region</th>';
                    echo '<th>Count</th>';
                    // if statements to check if the total checkbox is selected
                    if (!empty($_POST["total_confirmed"])) {
                        echo '<th>Total Confirmed</th>';
                    }
                    if (!empty($_POST["total_deaths"])) {
                        echo '<th>Total Deaths</th>';
                    }
                    if (!empty($_POST["total_recovered"])) {
                        echo '<th>Total Recovered</th>';
                    }
                    if (!empty($_POST["total_active"])) {
                        echo '<th>Total Active</th>';
                    }
                    echo '</tr>';
                    echo "</thead>";
                    echo "<tbody>";

                    echo '<tr>';
                    // for for each record
                    foreach ($cursor as $c) {
                        echo '<td>' . $c->_id . '</td>';
                        echo '<td>' . $c->count . '</td>';
                        // if statements to check if the total checkbox is selected
                        if (!empty($_POST["total_confirmed"])) {
                            echo '<td>' . $c->Total_Confirmed . '</td>';
                        }
                        if (!empty($_POST["total_deaths"])) {
                            echo '<td>' . $c->Total_Deaths . '</td>';
                        }
                        if (!empty($_POST["total_recovered"])) {
                            echo '<td>' . $c->Total_Recovered . '</td>';
                        }
                        if (!empty($_POST["total_active"])) {
                            echo '<td>' . $c->Total_Confirmed . '</td>';
                        }
                    }
                    echo '</tr>';
                    echo "</tbody>";
                    echo '</table>';
                }
            }

            /**
             * Function to show Totals(selected) of Country (selected)
             * Sums all the records rom the country provided and displays 
             * the sum while also showing the count of records
             */
            function displayMax() {
                $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017/covid-19");
                if (!empty($_POST['limit'])) {
                    $limit = (int) $_POST['limit'];
                } else {
                    $limit = 3000;
                }

                echo "<table class = 'table' border='2' style='width: 100%; border: 5px solid black; background: #9fbedf'; >";
                echo "<thead class='thead-light'> <tr>";
                echo '<th>Country Region</th>';
                echo '<th>Count</th>';
                // if statements to check if the total checkbox is selected
                if (!empty($_POST["max_confirmed"])) {
                    echo '<th>Highest Confirmed</th>';
                }
                if (!empty($_POST["max_deaths"])) {
                    echo '<th>Highest Deaths</th>';
                }
                if (!empty($_POST["max_recovered"])) {
                    echo '<th>Highest Recovered</th>';
                }
                if (!empty($_POST["max_active"])) {
                    echo '<th>Highest Active</th>';
                }
                echo '</tr>';
                echo "</thead>";
                echo "<tbody>";


                if (!empty($_POST['country'])) { // if country selected then show max of only the selected country
                    if ($manager) {
                        // create a filter that aggregates the records (sum)
                        $filter = ['aggregate' => 'covid_record', 'cursor' => new stdClass,
                            'pipeline' => [
                            ['$match' => ['Country_Region' => $_POST["country"]]], // country selected
                                ['$group' => [
                                        '_id' => '$Country_Region',
                                        'Max_Confirmed' => ['$max' => '$Confirmed'],
                                        'Max_Deaths' => ['$max' => '$Deaths'],
                                        'Max_Recovered' => ['$max' => '$Recovered'],
                                        'count' => ['$sum' => 1],]],
                                ['$sort' => ['Max_Confirmed' => -1]],
                                ['$limit' => $limit],
                            ], 'cursor' => new stdClass()
                        ];

                        $command = new MongoDB\Driver\Command($filter);
                        $cursor = $manager->executeCommand('covid-19', $command);
                        // for for each record
                        foreach ($cursor as $c) {
                            echo '<tr>';
                            echo '<td>' . $c->_id . '</td>';
                            echo '<td>' . $c->count . '</td>';
                            // if statements to check if the total checkbox is selected
                            if (!empty($_POST["max_confirmed"])) {
                                echo '<td>' . $c->Max_Confirmed . '</td>';
                            }
                            if (!empty($_POST["max_deaths"])) {
                                echo '<td>' . $c->Max_Deaths . '</td>';
                            }
                            if (!empty($_POST["max_recovered"])) {
                                echo '<td>' . $c->Max_Recovered . '</td>';
                            }
                            if (!empty($_POST["max_active"])) {
                                echo '<td>' . $c->Max_Confirmed . '</td>';
                            }
                            echo '</tr>';
                        }
                    }
                } else { // if country not selected then show max for all countries
                    if ($manager) {
                        // create a filter that aggregates the records (sum)
                        $filter = ['aggregate' => 'covid_record', 'cursor' => new stdClass,
                            'pipeline' => [
                                ['$group' => [
                                        '_id' => '$Country_Region',
                                        'Max_Confirmed' => ['$max' => '$Confirmed'],
                                        'Max_Deaths' => ['$max' => '$Deaths'],
                                        'Max_Recovered' => ['$max' => '$Recovered'],
                                        'count' => ['$sum' => 1],]],
                                ['$sort' => ['Max_Confirmed' => -1]],
                                ['$limit' => $limit],
                            ], 'cursor' => new stdClass()
                        ];

                        $command = new MongoDB\Driver\Command($filter);
                        $cursor = $manager->executeCommand('covid-19', $command);
                        // for for each record
                        foreach ($cursor as $c) {
                            echo '<tr>';
                            echo '<td>' . $c->_id . '</td>';
                            echo '<td>' . $c->count . '</td>';
                            // if statements to check if the max checkbox is selected
                            if (!empty($_POST["max_confirmed"])) {
                                echo '<td>' . $c->Max_Confirmed . '</td>';
                            }
                            if (!empty($_POST["max_deaths"])) {
                                echo '<td>' . $c->Max_Deaths . '</td>';
                            }
                            if (!empty($_POST["max_recovered"])) {
                                echo '<td>' . $c->Max_Recovered . '</td>';
                            }
                            if (!empty($_POST["max_active"])) {
                                echo '<td>' . $c->Max_Confirmed . '</td>';
                            }
                            echo '</tr>';
                        }
                    }
                }
                echo "</tbody>";
                echo '</table>';
            }
            ?>
        </div>
    </body>  
</html>

