$(document).on('ready', function () {

    var $range = $(".js-range-slider");
    var $result = $(".js-result");

    var values = [0, 100, 200, 300, 999];
    var values_p = ["12AM", "8AM", "4PM", "8PM", "12AM"];

    $range.ionRangeSlider({
        type: "double",
        grid: true,
        values: values,
        prettify: function (n) {
            var ind = values.indexOf(n);
            return values_p[ind];
        },
        onStart: function (data) {
            $result.text(data.from_value);
        },
        onChange: function (data) {
            $result.text(data.from_value);
        }
    });

    // slider end
    $(".center").slick({
        dots: true,
        infinite: true,
        centerMode: true,
        slidesToShow: 5,
        slidesToScroll: 3
    });
    $(".lazy").slick({
        lazyLoad: 'ondemand', // ondemand progressive anticipated
        infinite: true
    });
});