$('#admins_table').dataTable({
    "paging": true,
    "searching": true,
    "responsive": true,
    "columnDefs": [
    { "responsivePriority": 1, "targets": 0 },
    { "responsivePriority": 2, "targets": -1 }
    ]
});


$('#forgot-btn').on('click',function(){

    if($("#email").val() == ''){
        $('#error_msg').text("Email field is required.").show();
        return false;
    } else {
        $('#error').hide();
    }

    var btn = $(this);

    $(btn).button('loading');
    var value = $("#forgot_form").serialize();

    $.ajax({

        url:admin_url+'forgot_password/retrieve_password',

        type:'post',

        data:value,

        dataType:'json',

        success:function(status){

            console.log(status);

            if(status.msg=='success'){
                $('#error_msg').hide();
                $('#success_msg').text(status.response).show();
                $(btn).button('reset');

            }

            else if(status.msg == 'error'){
                $('#error_msg').text(status.response).show();
                $(btn).button('reset');
            }

        }

    });

});

$(document).on('click', '.delete-btn', function (event) {

    var record_id = $(this).attr('data-id');
    var model = $(this).attr('data-model');

    swal({
        title: "Are you sure?",
        text: "You want to delete this record!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, please!",
        cancelButtonText: "No, cancel please!",
        closeOnConfirm: false,
        closeOnCancel: false
    },
    function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                url:admin_url+model+'/delete_record',
                type:'post',
                data:{ record_id : record_id },
                dataType:'json',
                success:function(status){

                    if(status.msg=='success'){
                        swal({title: "Success!", text: status.response, type: "success"},
                            function(){
                                location.reload();
                            });

                    } else if(status.msg=='error'){

                        swal("Error", status.response, "error");
                    }
                }
            });
        } else {
            swal("Cancelled", "", "error");
        }
    });
});

$('.select2').select2();


// $('.i-checks').iCheck({
//     checkboxClass: 'icheckbox_square-green',
//     radioClass: 'iradio_square-green',
// });


$(document).on('click', '.view_detail',function() {

    var record_id = $(this).attr('data-id');
    var model = $(this).attr('data-model');

    $.ajax({
      url:admin_url+model+'/get_details',
      data:{ record_id : record_id },
      type:'post',
      dataType: 'json',
      success:function(res) {

        $('#detail_modal_body').html(res.response);
        $('#detail_modal').modal('show');
    }

});

});