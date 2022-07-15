var $h = $(window).height();
$('.left-flex').height($h-50);

$(window).resize(function() {
    var $h = $(window).height();
    $('.left-flex').height($h-50);
})

$("li").click(function() {
    if($(this).children(".fa-angle-right").hasClass("down")){
        $(this).children(".fa-angle-right").removeClass("down")
        if($(this).hasClass("hosting")){
            $(this).parent().children(".accordion[aria-label|=1]").removeClass("active")
        }else{
            $(this).parent().children(".accordion[aria-label|=2]").removeClass("active")
        }
    }else{
        $(this).children(".fa-angle-right").addClass("down")
        if($(this).hasClass("hosting")){
            $(this).parent().children(".accordion[aria-label|=1]").addClass("active")
        }else{
            $(this).parent().children(".accordion[aria-label|=2]").addClass("active")
        }
    }
})

$('.button').click(function() {
    window.location.href = "/dashboard.php?box=buy"
})