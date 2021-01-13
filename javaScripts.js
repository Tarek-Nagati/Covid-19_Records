/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function initMap() {
    // map options such as zoom and center of the map, start point
    var option = {
        zoom: 4, // 1 = extra wide, 14 = zoomed in street level
        center: { // lat an long of starting point
            lat: parseFloat('47.1625'), 
            lng: parseFloat('19.5033')
        }
    }
    // new map object, get by id in html
    var map = new google.maps.Map(document.getElementById('map'), option);

    // get table to load data from map.php
    var myTab = document.getElementById('dataTable');

    // Loop through each row of the table after header 
    for (i = 1; i < myTab.rows.length; i++) {

        // Get the cells of the current row 
        var objCells = myTab.rows.item(i).cells;
        var country = "";
        var confirmed = "";
        var deaths = "";
        var recovered = "";
        var active = "";
        var lat = "";
        var long = "";
        //  Loop through each cell of the current row to read cell values 
        for (var j = 0; j < objCells.length; j++) {
            if (j === 0) {
                country = objCells.item(j).innerHTML;
            }
            if (j === 1) {
                confirmed = objCells.item(j).innerHTML;
            }
            if (j === 2) {
                deaths = objCells.item(j).innerHTML;
            }
            if (j === 3) {
                recovered = objCells.item(j).innerHTML;
            }
            if (j === 4) {
                active = objCells.item(j).innerHTML;
            }
            if (j === 5) {
                lat = objCells.item(j).innerHTML;
            }
            if (j === 6) {
                long = objCells.item(j).innerHTML;
            }
        }
        // set marker on map and set the window information
        addMarker({coords: {lat: parseFloat(lat), lng: parseFloat(long)}, // Long_ , Lat
            content: '<h1>' + country + '</h1>' +
                     '<h3>' + 'Confirmed: ' + confirmed + '</h3>' +
                     '<h3>' + 'Deaths: ' + deaths + '</h3>' +
                     '<h3>' + 'Recovered: ' + recovered + '</h3>' +
                     '<h3>' + 'Active: ' + active + '</h3>'
        });
    }

    /**
     * Function to add Marker on the Google Map
     * by providing the coordinates of the place and the information to display
     * inside the box when clicked
     * @param plots the coordinates(lat,long) for the place and the information to display
     */
    function addMarker(plots) {
        
        // create the marker object using the coordinates
        var marker = new google.maps.Marker({
            map: map,
            draggable: true,
            animation: google.maps.Animation.DROP,
            position: plots.coords
        });

        // if information about the place is provided, insert it into the box
        //and show it when clicked
        if (plots.content) {
            // add a infomation window on the marker
            var infowindow = new google.maps.InfoWindow({
                content: plots.content
            });
            // add a listener to the infomation window
            marker.addListener('click', function () {
                infowindow.open(map, marker);
            });
        }
    }

}

