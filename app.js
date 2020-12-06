$(document).ready(function() {
    $.get("/traffic-weather-info/data.php", function(data, status) {
        $('#temperature-status').html(Math.round(data.temp));
        $(".weather-status-container").append(`<p>${data.weather_description}</p>`);
        // document.write(data.weather_description);
        //$('#weather-status').attr("src", "https://openweathermap.org/img/wn/" + data.weather_icon + "@4x.png");

        for (let i = 0; i < data.departures_skyttens.length; i++) {
            let obj = data.departures_skyttens[i];
            $("#SkyttensGata-list").append(`<li><span class="bus-number" >${obj.bus}:&nbsp; &nbsp; &nbsp;</span> <span class="bus-time">${obj.time}</span></li>`);
        }
        for (let i = 0; i < data.departures_brandbergen.length; i++) {
            let obj = data.departures_brandbergen[i];
            $("#BrandbergenCentrum-list").append(`<li><span class="bus-number" >${obj.bus}:&nbsp; &nbsp; &nbsp;</span> <span class="bus-time">${obj.time}</span></li>`);
        }
    });

    //change background image according to date
    // var date = new Date();
    // var month = date.getMonth();
    // if (month >= 2 && month <= 4) {
    //     $('body').css('background-image', "url('img/spring.jpg')");
    // }
    // if (month >= 5 && month <= 7) {
    //     $('body').css('background-image', "url('img/summer.jpg')");
    // }
    // if (month >= 8 && month <= 10) {
    //     $('body').css('background-image', "url('img/fall.jpg')");
    // }



    //----------change color according to time-----------//

    var time = (new Date()).getHours();


    if (time < 16 && time >= 8) {
        $('body').css("background-color", "rgb(60, 120, 200)")
        $('.weather-image img').attr("src", "img/morning/Cloudy.png")
            // $('body').css("color", "black")
            // $('.bus-data-container').css("background-color", "rgb(190, 200, 221)");
    };
    //----------change temp from C to F -----------//

    $('#FahrTemp').on('click', function() {

        var tempC = $('#temperature-status').text();
        var tempF = Math.round((tempC * 9 / 5) + 32);
        $('.temperature-status-container').append($('<h1>')
            .addClass('temperature-header')
            // .add ID #temperature-Fahr
            .text(tempF));
        $('#temperature-status').hide();
    });

    //----------assign today's date ------------------//

    var WeekDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    var Months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
    let Today = new Date();
    var fulldate = WeekDays[Today.getDay()] + " " + Today.getDate() + " " + Months[Today.getMonth()] + " " + Today.getFullYear();

    $("#weather-date").text(fulldate);

    //----------modify date in the forecast-----------//

    const day1 = new Date();
    const day2 = new Date();
    const day3 = new Date();
    const day4 = new Date();
    const day5 = new Date();
    const day6 = new Date();
    const day7 = new Date();

    day1.setDate(new Date().getDate() + 1);
    day2.setDate(new Date().getDate() + 2);
    day3.setDate(new Date().getDate() + 3);
    day4.setDate(new Date().getDate() + 4);
    day5.setDate(new Date().getDate() + 5);
    day6.setDate(new Date().getDate() + 6);
    day7.setDate(new Date().getDate() + 7);

    $("#day1-forecast").text(WeekDays[day1.getDay()]);
    $('#day2-forecast').text(WeekDays[day2.getDay()]);
    $('#day3-forecast').text(WeekDays[day3.getDay()]);
    $('#day4-forecast').text(WeekDays[day4.getDay()]);
    $('#day5-forecast').text(WeekDays[day5.getDay()]);
    $('#day6-forecast').text(WeekDays[day6.getDay()]);
    $('#day7-forecast').text(WeekDays[day7.getDay()]);


});