var $h = $(window).height();
$('.left-flex').height($h-50);

$(window).resize(function() {
    var $h = $(window).height();
    $('.left-flex').height($h-50);
})

$("li").click(function() {
    if($(this).children(".fa-angle-right").hasClass("down")){
        $(this).children(".fa-angle-right").removeClass("down")
        $(this).parent().children(".accordion").removeClass("active")
    }else{
        $(this).children(".fa-angle-right").addClass("down")
        $(this).parent().children(".accordion").addClass("active")
    }
})

$('.button').click(function() {
    window.location.href = "/dashboard.php?box=buy"
})