$(document).ready(function() {
    $.get("/data.php", function(data, status) {
        $('#temperature-status').html(Math.round(data.temp));

        $('#weather-status').attr("src", "https://openweathermap.org/img/wn/"+data.weather_icon+"@4x.png");

        //we want just three buses to appear (can be adjusted to more)
        for (i = 0; i < 3; i++) {
            let obj = data.departures_skyttens[i];
            $("#SkyttensGata-list").append(`<li><span class="bus-number" >${obj.bus}</span> <span class="bus-time">${obj.time}</span></li>`);
        }
        for (i = 0; i < 3; i++) {
            let obj = data.departures_brandbergen[i];
            $("#BrandbergenCentrum-list").append(`<li><span class="bus-number" >${obj.bus}</span> <span class="bus-time">${obj.time}</span></li>`);
        }
    });

    var date = new Date();
    var month = date.getMonth();
    if (month >= 2 && month <= 4) {
        $('body').css('background-image', "url('img/spring.jpg')");
    }
    if (month >= 5 && month <= 7) {
        $('body').css('background-image', "url('img/summer.jpg')");
    }
    if (month >= 8 && month <= 10) {
        $('body').css('background-image', "url('img/fall.jpg')");
    }

});
