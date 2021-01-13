<!DOCTYPE html>
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
        <div class="container container_main">
            <div class="row">
                <div class="col">
                    <h1 class="title center-text">Covid-19 Information</h1>
                </div>
            </div>
            <form action="mainForm.php" method="post"> <!-- form to host the columns checkboxs -->
                <div class="form-row" style="border-radius: 10px solid;"><!-- bootstrap rows and columns -->
                    <div class="form-group col-md-12">
                        <h5 style="font-weight: bold;font-size:14px;">Select Columns to Display</h5>
                        <div class="form-check form-check-inline">

                            <label class="form-check-label" for = "checkbox1">Country</label>
                            <input class="form-check-input" type = "checkbox" id = "checkbox1"  name = "columns[]" checked="true" value = "Country_Region"/>

                            <label style="margin-left:0.25%;" class="form-check-label" for = "checkbox11">FIPS</label>
                            <input class="form-check-input" type = "checkbox" id = "checkbox11"  name = "columns[]" value = "FIPS"/>

                            <label style="margin-left:0.25%;"class="form-check-label" for = "checkbox3">Admin</label>
                            <input class="form-check-input" type = "checkbox" id = "checkbox3"  name = "columns[]" value = "Admin2"/>

                            <label style="margin-left:0.25%;" class="form-check-label" for = "checkbox2">Province State</label>
                            <input class="form-check-input" type = "checkbox" id = "checkbox2"  name = "columns[]" value = "Province_State"/>

                            <label style="margin-left:0.25%;" class="form-check-label" for = "checkbox10">Last Update</label>
                            <input class="form-check-input" type = "checkbox" id = "checkbox10"  name = "columns[]" value = "Last_Update"/>

                            <label style="margin-left:0.25%;" class="form-check-label" for = "checkbox8">Lat</label>
                            <input class="form-check-input" type = "checkbox" id = "checkbox8"  name = "columns[]" value = "Lat"/>

                            <label style="margin-left:0.25%;" class="form-check-label" for = "checkbox9">Long</label>
                            <input class="form-check-input" type = "checkbox" id = "checkbox9"  name = "columns[]" value = "Long_"/>

                            <label style="margin-left:0.25%;" class="form-check-label" for = "checkbox4">Confirmed</label>
                            <input class="form-check-input" type = "checkbox" id = "checkbox4"  name = "columns[]" value = "Confirmed"/>

                            <label style="margin-left:0.25%;" class="form-check-label" for = "checkbox6">Deaths</label>
                            <input class="form-check-input" type = "checkbox" id = "checkbox6"  name = "columns[]" value = "Deaths"/>

                            <label style="margin-left:0.25%;" class="form-check-label" for = "checkbox5">Recovered</label>
                            <input class="form-check-input" type = "checkbox" id = "checkbox5"  name = "columns[]" value = "Recovered"/>

                            <label style="margin-left:0.25%;" class="form-check-label" for = "checkbox7">Active</label>
                            <input class="form-check-input" type = "checkbox" id = "checkbox7"  name = "columns[]" value = "Active"/>

                            <label style="margin-left:0.25%;" class="form-check-label" for = "checkbox12">Incidence Rate</label>
                            <input class="form-check-input" type = "checkbox" id = "checkbox12"  name = "columns[]" value = "Incidence_Rate"/>

                            <label class="form-check-label" for = "checkbox13">Case Fatality Ratio</label>
                            <input class="form-check-input" type = "checkbox" id = "checkbox13"  name = "columns[]" value = "Case_Fatality_Ratio"/>
                        </div>
                    </div>
                </div>
                <div class="form-row" > <!-- the user can specify a country to see the result, if no country entered all countries will be showing -->
                    <div class="form-group col-md-6">
                        <label for="country">Select a Country</label>
                        <input class="form-control" type="text" name="country" id="country" placeholder="All Countries by Default if not seleceted...">  
                    </div>
                    <div class="form-group col-md-6">
                        <label for="second_country">Second Country (Optional)</label>
                        <input class="form-control" type="text" name="second_country" id="second_country" placeholder="No second country by default..">
                    </div>
                </div>
                <div class="form-row"><!-- row with chechboxes for Total -->
                    <div class="form-group col-md-12">
                        <div class="form-check form-check-inline">
                            <div style="display:inline">
                                <label class="form-check-label" for = "total_confirmed">Total Confirmed</label>
                                <input class="form-check-input" type = "checkbox" id = "total_confirmed"  name = "total_confirmed" value = "Confirmed"/>
                            </div>

                            <div style="margin-left: 2.6%;display:inline">
                                <label class="form-check-label" for = "total_deaths">Total Deaths</label>
                                <input class="form-check-input" type = "checkbox" id = "total_deaths"  name = "total_deaths" value = "Deaths"/>                                
                            </div>

                            <div style="margin-left: 2.6%;display:inline">
                                <label class="form-check-label" for = "total_recovered">Total Recovered</label>
                                <input class="form-check-input" type = "checkbox" id = "total_recovered"  name = "total_recovered" value = "Recovered"/> 
                            </div>  

                            <div style="margin-left: 2.6%;display:inline">
                                <label class="form-check-label" for = "total_active">Total Active</label>
                                <input class="form-check-input" type = "checkbox" id = "total_active"  name = "total_active" value = "Active"/>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="form-row"><!-- row with chechboxes for Max -->
                    <div class="form-group col-md-12">
                        <div class="form-check form-check-inline">
                            <div style="display:inline">
                                <label class="form-check-label" for = "max_confirmed">Highest Confirmed</label>
                                <input class="form-check-input" type = "checkbox" id = "max_confirmed"  name = "max_confirmed" value = "Confirmed"/>
                            </div>

                            <div style="margin-left: 3%;display:inline">
                                <label class="form-check-label" for = "max_deaths">Highest Deaths</label>
                                <input class="form-check-input" type = "checkbox" id = "max_deaths"  name = "max_deaths" value = "Deaths"/>                                
                            </div>

                            <div style="margin-left: 3%;display:inline">
                                <label class="form-check-label" for = "max_recovered">Highest Recovered</label>
                                <input class="form-check-input" type = "checkbox" id = "max_recovered"  name = "max_recovered" value = "Recovered"/> 
                            </div>  

                            <div style="margin-left: 3%;display:inline">
                                <label class="form-check-label" for = "max_active">Highest Active</label>
                                <input class="form-check-input" type = "checkbox" id = "max_active"  name = "max_active" value = "Active"/>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="form-row"><!-- Input field for sorting(sort by) and choose order (ascending/descending) -->
                    <div class="form-group col-md-6">
                        <label for="sort_by">Choose Column To Sort By</label>
                        <select class="form-control" aria-labelledby="dropdownMenuButton" id="sort_by" name="sort_by">
                            <option value="Country_Region">Country Region</option>
                            <option value="Confirmed">Confirmed</option>
                            <option value="Deaths">Deaths</option>
                            <option value="Recovered">Recovered</option>
                            <option value="Active">Active</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3" style="padding-top: 2.5%;">
                        <label class="form-check-label" for="ascending">Ascending</label>
                        <input class="form-check-input" type="radio" id="ascending" name="order" value="ascending">
                    </div>
                    <div class="form-group col-md-3" style="padding-top: 2.5%;">
                        <label class="form-check-label" for="descending">Descending</label>
                        <input class="form-check-input" type="radio" id="descending" name="order" value="descending">
                    </div>
                </div>

                <div class="form-row"><!-- select column for Condition 1-->
                    <div class="form-group col-md-12">
                        <label for="condition1">Where (Condition 1):</label>
                        <select class="form-control" id="condition1" name="condition1">
                            <option value="Confirmed">Confirmed</option>
                            <option value="Deaths">Deaths</option>
                            <option value="Recovered">Recovered</option>
                            <option value="Active">Active</option>
                            <option value="Lat">Lat</option>
                            <option value="Long_">Long</option>
                        </select>  
                    </div>
                </div>
                
                <div class="form-row"><!-- Equal, Less, Greater Than fields for Condition 1 -->
                    <div class="form-group  col-md-4">
                        <label for="equal1">Equal</label>
                        <input class="form-control" type="text" id="equal1" name="equal1" placeholder="Insert a Number...">
                    </div>
                    <div class="form-group  col-md-4">
                        <label for="lessthan1">Less Than</label>
                        <input class="form-control" type="text" id="lessthan1" name="lessthan1" placeholder="Insert a Number...">
                    </div>
                    <div class="form-group  col-md-4">
                        <label for="greaterthan1">Greater Than</label>
                        <input class="form-control" type="text" id="greaterthan1" name="greaterthan1" placeholder="Insert a Number...">
                    </div>
                </div>

                <div class="form-row"><!-- select column for Condition 2-->
                    <div class="form-group col-md-12">
                        <label for="condition2">Where (Condition 2):</label>
                        <select class="form-control" id="condition1" name="condition2">
                            <option value="Confirmed">Confirmed</option>
                            <option value="Deaths">Deaths</option>
                            <option value="Recovered">Recovered</option>
                            <option value="Active">Active</option>
                            <option value="Lat">Lat</option>
                            <option value="Long_">Long</option>
                        </select>  
                    </div>
                </div>

                <div class="form-row"><!-- Condition 2 - Equal Statement-->
                    <div class="form-group col-md-8 ">
                        <label for="equal2">Equal</label>
                        <input class="form-control" type="text" id="equal2" name="equal2" placeholder="Insert a Number...">
                    </div>
                </div>

                <div class="form-row"><!-- Input field for limiting number of records to show-->
                    <div class="form-group col-md-8">
                        <label for="limit">Number of Records: Limit</label>
                        <input class="form-control" type="text" id="limit" name="limit" placeholder="Insert a Number...">
                    </div>
                </div>

                <div class="form-row"><!-- Buttons for submitting the query or showing the Map of Records-->
                    <div class="form-group col-md-12" style="width:100%;">
                        <div style="width: 50%;margin: auto;text-align: center;align-content: center;">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="map.php" class="btn btn-primary">Map</a> 
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </body>  
</html>