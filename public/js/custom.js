$('.dropdown-menu').click(function (e) {
    e.stopPropagation();
});
var customize_info = {};
var interval_run = 0;
var delayScroll = 0;
var auto_scroll_chapter = null;

var heightScroll = 0;
$('document').ready(function () {
    if(localStorage.getItem('customize_info')){
        customize_info = JSON.parse(localStorage.getItem('customize_info'));
        $("#body-id").css('background', customize_info['bg_color']);
        $("#bg-id").val(customize_info['bg_color']);

        if(customize_info['bg_color'] == '#232323') {
            $('#container-chapter').css('color', '#ebebeb');
        }else{
            $('#container-chapter').css('color','#3b3b3b');
        }

        $('#chapter-content').css('font-family',customize_info['font_family']);
        $('#font-id').val(customize_info['font_family']);

        $('#chapter-content').css('font-size',customize_info['font_size']);
        $('#size-id').val(customize_info['font_size']);
        $('#chapter-content').css('line-height',customize_info['line_height']);
        $('#height-id').val(customize_info['line_height']);
        $('#time-delay-id').val(customize_info['time_delay']);
        $('#height-scroll-id').val(customize_info['height_scroll']);
        if(customize_info['fluid_switch'] == 'fluid'){
            $("#container-chapter").removeClass("container");
            $("#container-chapter").addClass("container-fluid");
            $('#fluid-bg').prop('checked', true);
        }else{
            $("#container-chapter").removeClass("container-fluid");
            $("#container-chapter").addClass("container");
            $('#no-fluid-bg').prop('checked', true);
        }
        delayScroll = parseInt(customize_info['time_delay']);
        heightScroll = customize_info['height_scroll'];

        if(customize_info['auto_scroll'] == 'auto-scroll'){
            $('#auto-scroll-id').prop('checked', true);
        }else{
            $('#no-scroll-id').prop('checked', true);
        }
        if(customize_info['auto_scroll'] == 'auto-scroll' && interval_run == 0 && delayScroll!=0){
            auto_scroll_chapter = window.setInterval(scrollit, delayScroll);
            interval_run = 1;
        }
    }

    var currentChapterText = $("#chap-name").text();
    var currentChapterSlug = $("#chap-slug").text();
    var currentBookText = $("#book-name").text();
    var currentBookSlug = $("#book-slug").text();
    var local_info = {};
    if(localStorage.getItem('local_info')){
        local_info = JSON.parse(localStorage.getItem('local_info'));
    }
    local_info[currentBookSlug]= {
        'bookName' : currentBookText,
        'bookSlug' : currentBookSlug,
        'bookUrl' : '<a href="/' + currentBookSlug + '">' + currentBookText + '</a>',

        'chapterName' : currentChapterText,
        'chapterSlug': currentChapterSlug,
        'chapterUrl' : '<a href="/' + currentBookSlug + '/' + currentChapterSlug + '">' + currentChapterText + '</a>'
    }
    localStorage.setItem('local_info', JSON.stringify(local_info));
});

function customize(){
    var customize_info = {};
    if(localStorage.getItem('customize_info')){
        customize_info = JSON.parse(localStorage.getItem('customize_info'));
    }
    customize_info= {
        'bg_color' : $("#bg-id").val(),
        'font_family' : $('#font-id').val(),
        'font_size' : $('#size-id').val(),

        'line_height' : $('#height-id').val(),
        'fluid_switch': $('input:radio[name="fluid-switch"]:checked').val(),
        'auto_scroll' : $('input:radio[name="auto-scroll"]:checked').val(),
        'time_delay' : $('#time-delay-id').val(),
        'height_scroll' : $('#height-scroll-id').val()
    }
    localStorage.setItem('customize_info', JSON.stringify(customize_info));

    $("#body-id").css('background', customize_info['bg_color']);

    if(customize_info['bg_color'] == '#232323') {
        $('#container-chapter').css('color', '#ebebeb');
    }else{
        $('#container-chapter').css('color','#3b3b3b');
    }

    $('#chapter-content').css('font-family',customize_info['font_family']);
    $('#chapter-content').css('font-size',customize_info['font_size']);
    $('#chapter-content').css('line-height',customize_info['line_height']);
    if(customize_info['fluid_switch'] == 'fluid'){
        $("#container-chapter").removeClass("container");
        $("#container-chapter").addClass("container-fluid");
    }else{
        $("#container-chapter").removeClass("container-fluid");
        $("#container-chapter").addClass("container");
    }
    delayScroll = parseInt(customize_info['time_delay']);
    if(customize_info['auto_scroll'] == 'auto-scroll' && interval_run == 0 && delayScroll!=0){
        auto_scroll_chapter = window.setInterval(scrollit, delayScroll);
        interval_run = 1;
    }else{
        clearInterval(auto_scroll_chapter);
        interval_run = 0;
        $('#no-scroll-id').prop('checked', true);
    }
}

$("body").on("keydown", function(e){
    if(e.keyCode === 37 || e.keyCode === 65){
        if(!$("#prev-id").attr('disabled')){
            window.location.href = $("#prev-id").attr('href');
        }
    }
    if(e.keyCode === 39 || e.keyCode === 68){
        if(!$("#next-id").attr('disabled')){
            window.location.href = $("#next-id").attr('href');
        }
    }
});

function scrollit(){
    if(localStorage.getItem('customize_info')){
        customize_info = JSON.parse(localStorage.getItem('customize_info'));

        heightScroll = customize_info['height_scroll'];
        if(customize_info['auto_scroll'] == 'auto-scroll'){
            if(heightScroll!=0){
                $("#body-id").animate({scrollTop: ($("#body-id").scrollTop() + parseInt(heightScroll))}, 'slow');
            }else{
                $("#body-id").animate({scrollTop: $("#body-id").scrollTop() + 100}, 'slow');

            }
            interval_run = 1;
            $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() == $(document).height()) {
                    if(!$("#next-id").attr('disabled')){
                        setTimeout(function(){
                            window.location.href = $("#next-id").attr('href');
                        }, 5000);
                    }
                }
            });
        }else{
            if(interval_run == 1){
                clearInterval(auto_scroll_chapter);
            }
            interval_run = 0;
        }
    }
}



