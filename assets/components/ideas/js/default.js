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
                var $type = 'error';
                var $message = data.message;
                var $icon = 'fa fa-exclamation-circle';
            }
            if(data.success === true){
                post.find('[data-action="' + vote_action + '"] span').text(data.count);
                var $type = 'success';
                var $message = data.message;
                var $icon = 'fa fa-check';
            }

            toastOptions = {
                class: 'iziToast-' + $type,
                message: $message,
                animateInside: false,
                position: 'topRight',
                progressBar: false,
                icon: $icon,
                timeout: 3200,
                transitionIn: 'fadeInLeft',
                transitionOut: 'fadeOut',
                transitionInMobile: 'fadeIn',
                transitionOutMobile: 'fadeOut',
                theme:'dark'
            };
            iziToast.show(toastOptions);
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
            var $type;
            var $message;
            var $icon;

            if(data.success === false){
                $type = 'error';
                $message = data.message;
                $icon = 'fa fa-exclamation-circle';
            }
            if(data.success === true){
                $type = 'success';
                $message = data.message;
                $icon = 'fa fa-check';
            }

            toastOptions = {
                class: 'iziToast-' + $type,
                message: $message,
                animateInside: false,
                position: 'topRight',
                progressBar: false,
                icon: $icon,
                timeout: 3200,
                transitionIn: 'fadeInLeft',
                transitionOut: 'fadeOut',
                transitionInMobile: 'fadeIn',
                transitionOutMobile: 'fadeOut',
                theme:'dark'
            };
            iziToast.show(toastOptions);
        },
        'dataType':'json'
    });
});

$(document).on('change', '.selectIdeasTabs', function(){
    var tab_id = $(this).val();

    $('.ideasTabsNav a').each(function(){
        if($(this).data('tab') == tab_id){
            $(this).addClass('active');
        }else{
            $(this).removeClass('active');
        }
    });

    $('.ideasTab').each(function(){
        if($(this).data('tab') == tab_id){
            $(this).addClass('active');
        }else{
            $(this).removeClass('active');
        }
    });

});