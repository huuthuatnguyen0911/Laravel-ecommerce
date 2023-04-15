$(document).ready(function () {
    $('#_1st-toggle-btn').click(function (e) {

        let check = $('.toggle_light:checkbox:checked').prop('checked');

        if (check == true) {
            $('#main_body_side_layout .sc-bg').css({
                background: '#f2f2f2'
            })
            $('#main_body_side_layout .sc-bg-body').css({
                background: '#fff'
            })
            $('#main_body_side_layout .change_light').css({
                color: '#222222'
            })
            $('#main_body_side_layout .change_light.active').css({
                color: 'var(--primary-color)'
            })
            $('#main_body_side_layout .change_bg_color_list').css({
                backgroundColor: '#fff'
            })
            $('#main_body_side_layout .box_text_message_friend').css({
                backgroundColor: '#e4e6eb',
                color: '#000',
            })
        } else {
            $('#main_body_side_layout .sc-bg').css({
                background: '#222222'
            })
            $('#main_body_side_layout .sc-bg-body').css({
                backgroundColor: '#252525'
            })
            $('#main_body_side_layout .change_light').css({
                color: '#ffffff'
            })
            $('#main_body_side_layout .change_light.active').css({
                color: 'var(--primary-color)'
            })
            $('#main_body_side_layout .change_bg_color_list').css({
                backgroundColor: '#252525'
            })
            $('#main_body_side_layout .box_text_message_friend').css({
                backgroundColor: '#3e4042',
                color: '#fff',
            })
        }
    });

    // $(document).ready(function() {
    //     // pusher 
        

        

    // })
})