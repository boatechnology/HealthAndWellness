$(function() {
   mydate = new Date();

   $('.mytable tr').popover({
       placement: 'top',
       trigger: 'hover'
   });
   
   $('#filter-form input, #filter-form select').change(function(){
       $("#filter-form").submit();
    });
    
   mydate = new Date();
   if (mydate.getMonth() <= 0) {
       mymonth = 0;
   }else{
       mymonth = (mydate.getMonth()-1);
   }   
  
   $('.date').pickadate({
        'min' : mindate,
        'max' : maxdate,
        'format': 'mmm d'        
    }).click(function() {
        return false;
    });
    
    $('.date-unlimited').pickadate({
        'format': 'mmm d'
    }).click(function() {
        return false;
    });
   
    $('textarea[maxlength]').keyup(function(){
        var max = parseInt($(this).attr('maxlength'));
        if($(this).val().length > max){
            $(this).val($(this).val().substr(0, $(this).attr('maxlength')));
        }
        $(this).parent().find('.charsRemaining').html('<span class="badge">' + (max - $(this).val().length) + '</span> '+hw.lang.hw_js_chars);
    });

    $('.onload-show').show();
    
    // Bind x-editable to hidden elements when the become visible
    $('#accordion .panel').bind('show.bs.collapse', function(e) {
        $(e.currentTarget).find('.editable').editable({
            viewformat: 'm/d',
            toggle: 'click',
            pk : $(this).attr('id'),
            success : function(response,newValue) {
                
            },
            error: function(response,newValue) {
                
            }
        });
    });
   
    $('.delete-me').click(function() {
        if (!window.processsing){
            window.processsing = true;
            doit = confirm(hw.lang.hw_js_delete_goal);
            if (doit) {
                window.post_data = {idgoals: $(this).attr('id')};
                $.ajax({
                    type: "POST",
                    url: '/index.php/ajax/delete_goal',               
                    data: window.post_data,
                    dataType: 'json',
                    success: function(resp) {
                        if(resp.data == window.post_data.idgoals) {
                            $("#"+resp.data).parents('.panel').hide();
                        }else{
                            alert(hw.lang.hw_error_delete_goal+'\n'+resp.msg);
                        }
                    },
                    error: function(resp) {
                        alert(hw.lang.hw_error_delete_goal+'\n'+resp.responseJSON.msg);
                    }
                });
            }
            window.processsing = false;
        }
    });
    
    $('#feedback-form [name="feedbacker"]').change(function () {
        if ($(this).is(':checked')) {
            $('#feedback-form p').hide();
        }else{
            $('#feedback-form p').show();
        }
    });

    $("#feedback-anonymous").click(function() {
        if (this.checked){
            $('#feedback-name').hide('400');
            $('#feedbacker').prop('disabled', true);
        }else{
             $('#feedback-name').show('400');
             $('#feedbacker').prop('disabled', false);
        }
    });

    $('#feedback-send').click(function() {
        feedback_data = $("#feedback-form").serialize();
        if (!window.processsing){
            window.processsing = true;
            ftext = $("#feedback-form [name='feedback']").val();
            if (ftext == '') {
                alert(hw.lang.hw_js_empty_feedback);
                $("#feedback-form [name='feedback']").focus();
                window.processsing = false;
            }else{
                $.post('/index.php/ajax/add_feedback',
                    feedback_data,
                    function(data) {
                        if (data.error == '0') {
                            alert(hw.lang.hw_js_feedback_sent);
                            $('#feedback-modal').modal('hide');
                            $("#feedback-form [name='feedback']").val('');
                        }else{
                            alert(hw.lang.hw_js_error_feedback);
                        }
                    },
                    'json'
                )
                .complete(function() {
                    window.processing = false;
                });
            }
        }
    });

    $('#activity_classes').change(function() {
        window.data = {class: $(this).val()};
        $('#activity-log-form input[name=quantity]').val('').attr('readonly', false);
        $('#activity-log-form input[name=comments]').val('');
        $.post('/index.php/ajax/activity_dropdown',
            window.data,
            function(d) {
                if (d.error == '0') {
                    $('#activity_dropdown').html(d.data);
                    activityDropdownHandler();
                }else{
                    alert(d.msg);
                }
            },
            'json'
        );
    });
    activityDropdownHandler();
    addHandlers();
});

function activityDropdownHandler() {
    $('[name=idactivities]').change(function() {
            $('#activity-log-form input[name=quantity]').val('');
            $('#activity-log-form input[name=comments]').val('');
            window.activity_id = $(this).val();
            $.ajax({
                 type: "POST",
                 url: '/index.php/ajax/get_activity',               
                 data: {idactivity: window.activity_id},
                 dataType: 'json',
                 success: function(r) {
                     activity = $.parseJSON(r.data);
                     if (activity.onequantitylimit == 1){
                         $('#activity-log-form input[name=quantity]').val('1').attr('readonly', true);
                     }else{
                         $('#activity-log-form input[name=quantity]').val('').attr('readonly', false);
                     }
                     newstring = activity.points+' '+hw.lang.hw_points+'/'+activity.factor+"";
                     $('#factor-txt').text(newstring);
                 },
                 error: function(data) {
                     $('#factor-txt').text(hw.lang.hw_js_no_points);
                 }
            });
       });
}

function addHandlers() {
    $('#myTabs').off('click').bind('click', function(e) {
        paneID = $(e.target).attr('href');
        src = $(paneID).attr('data-src');
        $(paneID+" iframe").attr("src",src);
    });
    
    $('.editme .editable').editable({
        viewformat: 'm/d',
        placement: 'bottom',
        mode: 'inline',
        toggle: 'click',
        success : function() {
        },
        error: function(response) {
            return response.responseText;
        }
    });
    
    $('table .readd-activity').off('click').click(function() {
       window.activity_data = {
           date : $(this).attr('data-date'),
           idusers : $(this).attr('data-idusers'),
           idactivities : $(this).attr('data-idactivities'),
           quantity : $(this).attr('data-quantity')           
       };
       if (!window.processsing){
            window.processsing = true;
            $.ajax({
                type: "POST",
                url: '/index.php/ajax/add_activity_log',               
                data: window.activity_data,
                dataType: 'json',
                success: function(r) {
                    $(r.data).hide()
                        .prependTo('#activity-table tbody:first')
                        .fadeIn('slow');
                    addHandlers();
                },
                error: function(o) {
                    alert(hw.lang.hw_error_add_activity+'\n'+o.responseJSON.error);
                },
                statusCode: {
                    500: function(o) {
                        alert(hw.lang.hw_error_add_activity+'\n'+o.responseJSON.error);
                    }
                }
            });
            window.processsing = false;
        }
   });
   
   $('table .delete-activity').off('click').click(function() {
       window.id_activity = $(this).attr('data-pk');
       if (!window.processsing){
            window.processsing = true;
            doit = confirm(hw.lang.hw_js_delete_activity);
            if (doit) {
                window.post_data = {id: window.id_activity};
                $.ajax({
                    type: "POST",
                    url: '/index.php/ajax/delete_activity_log',               
                    data: window.post_data,
                    dataType: 'json',
                    success: function() {
                        $('table button[data-pk="'+window.id_activity+'"]').parentsUntil('tbody').hide();
                    },
                    error: function(r) {
                        alert(hw.lang.hw_error_delete_activity+'\n'+r.responseJSON.msg);
                    }
                });
            }
            window.processsing = false;
        }
   });
   
   $('#add_activity').off('click').click(function () {
       $('#add_activity').off('click');
        doit = validateAddActivity();
        if (doit) {
            Ladda.bind(this, {timeout: 1000});
            $(this).click();
            window.post_data = $('#activity-log-form').serialize();
            $('#activity-log-form').find('input[type=text]').val('');
            $.ajax({
                type: "POST",
                url: '/index.php/ajax/add_activity_log',               
                data: window.post_data,
                dataType: 'json',
                success: function(r) {
                    $(r.data).hide().prependTo('#activity-table tbody:first').fadeIn('slow');
                    addHandlers();
                },
                error: function(o) {
                    alert(hw.lang.hw_error_add_activity+'\n'+o.responseJSON.msg);
                }
            });
        }
        addHandlers();
   });
   
   $('.public-goal-button button').click(function (e) {
       that = $(this);
       if (!that.hasClass('active')) {
            var l = Ladda.create(this);
            l.start();
            data = {'value': that.attr('data-value'),
                    'name' : that.attr('data-name'),
                    'pk'   : that.attr('data-pk') };
            $.ajax({
                type: "POST",
                url: '/index.php/ajax/goal',               
                data: data,
                dataType: 'json',
                success: function() {
                    that.addClass('active').siblings().removeClass('active');
                },
                error: function(d) {
                    alert(d.responseJSON.msg);
                }
            });
            l.stop();
       }
   });
}

function validateAddActivity() {
    valid = true;
    $('#activity-log-form input, #activity-log-form :selected').each(function() { 
        if (!$(this).is('[tabindex]') && $(this).attr('name') != 'comments') {
            if ($(this).attr('name') == 'quantity') {
                if (!$.isNumeric($(this).val())) {
                    alert(hw.lang.hw_js_add_quantity);
                    valid = false;
                    $(this).focus();
                }
            }else{
                if ($(this).val() == '') {
                    if ($(this).attr('name') !== undefined && $(this).attr('name') !== false) {
                        text = hw.lang.hw_js_please_enter+' '+$(this).attr('name');
                    }else{
                        text = hw.lang.hw_js_complete_form;
                    }
                    
                    alert(text);
                    valid = false;
                    $(this).focus();
                }
            }
        }
        return valid;
    });
    return valid;
}