$(document).ready(function() {


    $.get("/data.json", function(data, status) {
        console.log("Data: " + data + "\nStatus: " + status);
        $('#temperature-status').html(data.temp);
        $('#weather-status').html(data.weather_status);

        //we want just three buses to appear (can be adjusted to more)
        for (i = 0; i < 3; i++) {
            let obj = data.departures_skyttens[i];
            $("#SkyttensGata-list").append(`<li><span class="bus-number" >${obj.bus}</span> <span class="bus-time">${obj.time}</span></li>`);
        }
        for (i = 0; i < 3; i++) {
            let obj = data.departures_brandbgergen[i];
            $("#BrandbergenCentrum-list").append(`<li><span class="bus-number" >${obj.bus}</span> <span class="bus-time">${obj.time}</span></li>`);
        }
    });




});