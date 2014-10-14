$(document).ready(function() {  
    $('.feed-refresh').click(function() {
        refresh();
    });

    var i = setInterval(function() {
        $('.ui-state-active').length && !$('.filter-search').val().length && refresh();
    }, 5000);
});

function refresh(){
        var feedUrl = $('.ui-state-active').attr('feed-url');
        var index = $('.ui-state-active').attr('tab');
        var curEntries = $('.entries[tab='+index+']');

        $.ajax({
            type: 'GET',
            url: '/js/buildRssFeed.php',
            data: {'url' : feedUrl},
            success: function(data) {
                curEntries.html('');
                curEntries.html(data);
            }
        });
    }