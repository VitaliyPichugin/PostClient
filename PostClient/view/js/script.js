$(document).ready(function(){

    $('#PostTable').DataTable({
        "aoColumnDefs":[{
            "aTargets": [ 0 ],
             "bSortable": false
        },{
            "aTargets":[ 2 ],
            "bSortable": false
        }]
    });

    $(':checkbox').click(function(){

        if ($(':checkbox').is(":checked")) {
            $('#del').css({'display': 'block'});
        }else{
            $('#del').css({'display': 'none'});
        }
    });

    $("#all_check").click(function () {
        if(!$("#all_check").is(":checked")){
            $(":checkbox").prop("checked", false);
            $(':checkbox').attr('checked', false);
            $('#del').css({'display': 'none'});
        }
        else{
            $(":checkbox").prop("checked", true);
            $(':checkbox').attr('checked', true);
            $('#del').css({'display': 'block'});
        }
    });

    $('.modal-form').dialog({
        autoOpen: false,
        height: 320,
        width: 400,
        show: "blind",
        modal: true,
        title: 'Отправка почты',
        buttons: {
            "Отправить": function(){
                var email = $("#email").val();
                var sub = $('#sub').val();
                var message = $('#message').val();
                var buf='';

                if(email){
                    isEmail(email);
                }
                if(sub==''){
                    sub = 'Без темы';
                }
                if(email == ''){
                    buf = 'Не заполнено поле кому ';
                    alert(buf);
                }
                else if(message == '') {
                    buf = 'Не заполнено тело письма ';
                    alert(buf);
                }
                else
                {
                    $('#email').val('');
                    $('#sub').val('');
                    $('#message').val('');
                    $('.modal-form').dialog('close');

                    $.ajax({
                        type: "POST",
                        url: "/",
                            data: "mail_to="+email+"&sub="+sub+"&msg="+message,
                        success: function(){
                            $.ajax({
                               url: 'index.php',
                                cashe: false,
                                success: function(data){
                                    var onlyBodyContent = data.split("<body")[1].split(">").slice(1).join(">").split("</body>")[0];
                                    $("body").html(onlyBodyContent);
                                }
                            });
                        },
                        error: function(){
                            alert('Error');
                            return false;
                        }

                    });
                }
            },
            "Отмена": function(){
                $('.modal-form').dialog('close');
            }
        }
    });

    $(".send").click(function() {
        $(".modal-form" ).dialog('open');
    });

    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!regex.test(email)){
            alert('Некорректный email');
        }else{
            return true;
        }
    }
});

