/**
 * Created by barmotinvladimir on 04/01/2017.
 */
$(window).ready(function() {
    $.ajax({
        method: 'GET',
        url: '/api/v1/rutracker/forums'
    }).done(function(data){
        $('[name=type_id]').append('<option value="">all</option>');
        for(var i in data) {
            $('[name=type_id]').append('<option value="'+data[i].id+'">'+data[i].title+'</option>');
        }
    });
    $('#rutracker_search').submit(function(){
        $.ajax({
            method: 'GET',
            url: '/api/v1/rutracker/search?'+$(this).serialize()
        }).done(function (data) {
            var result = $('#search_result');
            result.empty();
            for(var i in data) {
                result.append(
                    '<div class="rutracker_row">'+
                        '<div class="download_button"><button class="download" data-topic_id="'+data[i].id+'">Download</button></div>'+
                        '<span class="theme_name>">'+data[i].theme+'</span>'+
                    '</div>'
                );
                result.append('<hr/>')
            }
            $('.download').click(function(){
                var id = $(this).data('topic_id');
                $.ajax({
                    method: 'GET',
                    url: '/api/v1/rutracker/download?id='+id
                }).done(function (data) {
                    window.location.port = 9091;
                });
            });
        });
        return false;
    });
});