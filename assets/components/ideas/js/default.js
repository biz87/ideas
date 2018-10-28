$(document).on('click', '.ideasTabsNav a', function(e){
    e.preventDefault();

    var tab = $(this).data('tab');

    $('.ideasTabsNav a').each(function(){
        if($(this).data('tab') == tab){
            $(this).addClass('active');
        }else{
            $(this).removeClass('active');
        }
    });

    $('.ideasTab').each(function(){
        if($(this).data('tab') == tab){
            $(this).addClass('active');
        }else{
            $(this).removeClass('active');
        }
    });
});


$(document).on('click', '.ideas_vote a', function(e){
    e.preventDefault();

    var post = $(this).closest('.ideasPost');
    var action = $(this).data('action');
    var post_id = $(this).data('post');

    $.ajax({
        type: "POST",
        url: "/assets/components/ideas/connector.php",
        data: {vote_action:action,post_id:post_id},
        success: function(data) {
            console.log(data);
            if(data.success === false){
            }
            if(data.success === true){
                post.find('[data-action="' + action + '"] span').text(data.count);

            }
        },
        'dataType':'json'
    });
});