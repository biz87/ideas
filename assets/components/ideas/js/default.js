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
    var vote_action = $(this).data('action');
    var post_id = $(this).data('post');

    $.ajax({
        type: "POST",
        url: "/assets/components/ideas/action.php",
        data: {action:'vote',vote_action:vote_action,post_id:post_id},
        success: function(data) {
            console.log(data);
            if(data.success === false){
            }
            if(data.success === true){
                post.find('[data-action="' + vote_action + '"] span').text(data.count);

            }
        },
        'dataType':'json'
    });
});


$(document).on('focus', '.new_idea_form input', function(){
    $(this).closest('form').find('div[hidden]').attr('hidden', false).prop('hidden', false);
});

$(document).on('click', '.new_idea_submit', function(e){
    e.preventDefault();

    var form = $(this).closest('form');

    $.ajax({
        type: "POST",
        url: "/assets/components/ideas/action.php",
        data: form.serialize(),
        success: function(data) {
            console.log(data);
            if(data.success === false){
            }
            if(data.success === true){


            }
        },
        'dataType':'json'
    });
});