$('document').ready(function(){
    render_recent_html();
});

function remove_recent_book(book_slug){
    var local_info = JSON.parse(localStorage.getItem('local_info'));
    delete  local_info[book_slug];
    localStorage.setItem('local_info', JSON.stringify(local_info));
    render_recent_html();
}

function render_recent_html(){
    var recent_html = '';
    var local_info = JSON.parse(localStorage.getItem('local_info'));
    if(!$.isEmptyObject(local_info)){
        for(var key in local_info){
            recent_html+='<div class="row"><div class="col-xs-6">';
            recent_html+= '<i class="glyphicon glyphicon-menu-right"></i>';
            recent_html+= local_info[key].bookUrl;
            recent_html+= '</div>';
            recent_html+='<div class="col-xs-5">';
            recent_html+= local_info[key].chapterUrl;
            recent_html+= '</div>';
            recent_html+= '<div class="col-xs-1"><button onclick="remove_recent_book(\'';
            recent_html+= key;
            recent_html+= '\')" class="btn btn-danger btn-xs remove-recent"><i class="glyphicon glyphicon-remove-circle"></i></button></div></div>';
        }
    }else{
        recent_html = 'Bạn chưa đọc truyện nào cả !!!';
    }
    $("#recent").html(recent_html);
}

