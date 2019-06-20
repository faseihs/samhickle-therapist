

function delSevice(id){
    var loading = $.notify("Loading....",{
        autoHide: false,
        style:'bootstrap',
        className:'info'
    });
    $.ajax({
        type: 'DELETE',
        url:'/therapist/service/'+id,
        data:{
            _token:csrf
        },
        headers: {"_method": "DELETE"}
    }).done(function () {
        $('.notifyjs-wrapper').trigger('notify-hide');
        $.notify("Deleted Successfully....","success")
        $('#service'+id).remove();
    }).fail(function () {
        $.notify("Delete Failed....","error")
    });
}

$('.add-service').click(function () {
    $('#pricing-list-container').append(`
            <tr class="pricing-list-item">
                        <td>

                                <div class="row">
                                 <div class="col-md-1">
                                            <input class="form-control" style="background:white;" value="&pound;" readonly type="text">
                                        </div>
                                      
                                      <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="number" name="newPrices[]" step="any" class="form-control s-price"  placeholder="Price">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                            <input class="form-control" style="background:white;" value="Mins" readonly type="text">
                                        </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <input type="text"  name="newMinutes[]" class="form-control s-title" placeholder="Per Minutes">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <div class="form-group">
<!--
                                            <button type="button" class="btn btn-sm btn-success btn-circle addService"><i class="fa fa-fw fa-check"></i></button>
-->
                                           <<!--button class="btn btn-sm btn-danger removeRow" type="button">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>-->
                                           </div>
                                    </div>
                                </div>

                        </td>
                    </tr>
            `)
    $('.removeRow').bind('click',function () {
        $(this).parent().parent().parent().parent().parent().remove();
    });
    $('.addService').bind('click',function () {

        var button = $(this);
        var td = button.parent().parent().parent();
        var sTitle=td.find('.s-title');
        var sPrice=td.find('.s-price');
        if(sTitle.val().length<1 || sPrice.val().length<1){
            $.notify('Fill Details','error');
            return;
        }
        var loading = $.notify("Loading....",{
            autoHide: false,
            style:'bootstrap',
            className:'info'
        });
        $.ajax({
            type: 'POST',
            url:'/therapist/service',
            data:{
                _token:csrf,
                service:sTitle.val(),
                price:sPrice.val()
            }
        }).done(function (data) {
            $('.notifyjs-wrapper').trigger('notify-hide');
            $.notify("Added Successfully....","success")
            window.location.reload(true);
        }).fail(function () {
            $.notify("Delete Failed....","error")
            $('.notifyjs-wrapper').trigger('notify-hide');

        });


    });
});

$('.addService').bind('click',function () {

    var button = $(this);
    var td = button.parent().parent().parent();
    var sTitle=td.find('.s-title');
    var sPrice=td.find('.s-price');
    if(sTitle.val().length<1 || sPrice.val().length<1){
        $.notify('Fill Details','error');
        return;
    }
    var loading = $.notify("Loading....",{
        autoHide: false,
        style:'bootstrap',
        className:'info'
    });
    $.ajax({
        type: 'POST',
        url:'/therapist/service',
        data:{
            _token:csrf,
            service:sTitle.val(),
            price:sPrice.val()
        }
    }).done(function (data) {
        $('.notifyjs-wrapper').trigger('notify-hide');
        $.notify("Added Successfully....","success")
        window.location.reload(true);
    }).fail(function () {
        $.notify("Delete Failed....","error")
        $('.notifyjs-wrapper').trigger('notify-hide');

    });


});

function updateService(id) {

    var tr=$('#service'+id);
    var sTitle=tr.find('.s-title');
    var sPrice=tr.find('.s-price');
    if(sTitle.val().length<1 || sPrice.val().length<1){
        $.notify('Fill Details','error');
        return;
    }

    var loading = $.notify("Loading....",{
        autoHide: false,
        style:'bootstrap',
        className:'info'
    });
    $.ajax({
        type: 'PUT',
        url:'/therapist/service/'+id,
        data:{
            _token:csrf,
            service:sTitle.val(),
            price:sPrice.val(),
        }
    }).done(function (data) {
        $('.notifyjs-wrapper').trigger('notify-hide');
        $.notify("Updated Successfully....","success")
    }).fail(function () {
        $.notify("Update Failed....","error")
        $('.notifyjs-wrapper').trigger('notify-hide');

    });
}

// Specialization Updates

function delSpecialization(id){
    var loading = $.notify("Loading....",{
        autoHide: false,
        style:'bootstrap',
        className:'info'
    });
    $.ajax({
        type: 'DELETE',
        url:'/therapist/specialization/'+id,
        data:{
            _token:csrf
        },
        headers: {"_method": "DELETE"}
    }).done(function () {
        $('.notifyjs-wrapper').trigger('notify-hide');
        $.notify("Deleted Successfully....","success")
        $('#specialization'+id).remove();
    }).fail(function () {
        $.notify("Delete Failed....","error")
    });
}


$('.add-specialization').click(function () {
    $('#s-list-container').append(`
            <tr class="pricing-list-item">
                        <td>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text"  name="services[]" class="form-control s-title" placeholder="Specialization">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <button type="button"  class="btn btn-sm btn-success btn-circle addSpecialization"><i class="fa fa-fw fa-check"></i></button>
                                           </div>
                                    </div>
                                </div>

                        </td>
                    </tr>
            `)
    $('.addSpecialization').bind('click',function () {

        var button = $(this);
        var td = button.parent().parent().parent();
        var sTitle=td.find('.s-title');
        if(sTitle.val().length<1){
            $.notify('Fill Details','error');
            return;
        }
        var loading = $.notify("Loading....",{
            autoHide: false,
            style:'bootstrap',
            className:'info'
        });
        $.ajax({
            type: 'POST',
            url:'/therapist/specialization',
            data:{
                _token:csrf,
                specialization:sTitle.val()
            }
        }).done(function (data) {
            $('.notifyjs-wrapper').trigger('notify-hide');
            $.notify("Added Successfully....","success")
            window.location.reload(true);
        }).fail(function () {
            $.notify("Adding Failed....","error")
            $('.notifyjs-wrapper').trigger('notify-hide');

        });


    });
});

function updateSpecialization(id) {

    var tr=$('#specialization'+id);
    var sTitle=tr.find('.s-title');

    if(sTitle.val().length<1){
        $.notify('Fill Details','error');
        return;
    }

    var loading = $.notify("Loading....",{
        autoHide: false,
        style:'bootstrap',
        className:'info'
    });
    $.ajax({
        type: 'PUT',
        url:'/therapist/specialization/'+id,
        data:{
            _token:csrf,
            specialization:sTitle.val()
        }
    }).done(function (data) {
        $('.notifyjs-wrapper').trigger('notify-hide');
        $.notify("Updated Successfully....","success")
    }).fail(function () {
        $.notify("Update Failed....","error")
        $('.notifyjs-wrapper').trigger('notify-hide');

    });
}





function delEducation(id){
    var loading = $.notify("Loading....",{
        autoHide: false,
        style:'bootstrap',
        className:'info'
    });
    $.ajax({
        type: 'DELETE',
        url:'/therapist/education/'+id,
        data:{
            _token:csrf
        },
        headers: {"_method": "DELETE"}
    }).done(function () {
        $('.notifyjs-wrapper').trigger('notify-hide');
        $.notify("Deleted Successfully....","success")
        $('#education'+id).remove();
    }).fail(function () {
        $.notify("Delete Failed....","error")
    });
}

$('.add-education').click(function () {
    $('#pricing-list-container-2').append(`
            <tr class="pricing-list-item">
                        <td>

                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <input type="text"  name="newEducations[]" class="form-control e-title" placeholder="College">
                                        </div>
                                    </div>
                                    <div style="display:none;" class="col-md-4">
                                        <div class="form-group">
                                            <input type="text"  class="form-control e-price" value="none"  placeholder="Degree">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
<!--
                                            <button type="button" disabled class="btn btn-sm btn-success btn-circle addEducation"><i class="fa fa-fw fa-check"></i></button>
-->
                                          <!-- <button class="btn btn-sm btn-danger removeRow" type="button">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>-->
                                           </div>
                                    </div>
                                </div>

                        </td>
                    </tr>
            `)
    $('.removeRow').bind('click',function () {
        $(this).parent().parent().parent().parent().parent().remove();
    });
    $('.e-title').bind('change',function () {
        var thi =$(this);
        var tr= thi.parent().parent().parent();
        var btn = tr.find('.addEducation');
        console.log(btn);
        if(thi.val().length>0)
            btn.attr('disabled',false);
        else btn.attr('disabled',true);
    });
        $('.addEducation').bind('click',function () {

        var button = $(this);
        var td = button.parent().parent().parent();
        var sTitle=td.find('.e-title');
        var sPrice=td.find('.e-price');
        if(sTitle.val().length<1 || sPrice.val().length<1){
            $.notify('Fill Details','error');
            return;
        }
        var loading = $.notify("Loading....",{
            autoHide: false,
            style:'bootstrap',
            className:'info'
        });
        $.ajax({
            type: 'POST',
            url:'/therapist/education',
            data:{
                _token:csrf,
                college:sTitle.val(),
                description:sPrice.val()
            }
        }).done(function (data) {
            $('.notifyjs-wrapper').trigger('notify-hide');
            $.notify("Added Successfully....","success")
            window.location.reload(true);
        }).fail(function () {
            $.notify("Adding Failed....","error")
            $('.notifyjs-wrapper').trigger('notify-hide');

        });


    });
});


$('.e-title').bind('keyup',function () {
    var thi =$(this);
    var tr= thi.parent().parent().parent();
    var btn = tr.find('.addEducation');
    console.log(btn);
    if(thi.val().length>0)
        btn.attr('disabled',false);
    else btn.attr('disabled',true);
});

$('.addEducation').bind('click',function () {

    var button = $(this);
    var td = button.parent().parent().parent();
    var sTitle=td.find('.e-title');
    var sPrice=td.find('.e-price');
    if(sTitle.val().length<1 || sPrice.val().length<1){
        $.notify('Fill Details','error');
        return;
    }
    var loading = $.notify("Loading....",{
        autoHide: false,
        style:'bootstrap',
        className:'info'
    });
    $.ajax({
        type: 'POST',
        url:'/therapist/education',
        data:{
            _token:csrf,
            college:sTitle.val(),
            description:sPrice.val()
        }
    }).done(function (data) {
        $('.notifyjs-wrapper').trigger('notify-hide');
        $.notify("Added Successfully....","success")
        window.location.reload(true);
    }).fail(function () {
        $.notify("Adding Failed....","error")
        $('.notifyjs-wrapper').trigger('notify-hide');

    });


});


function updateEducation(id) {

    var tr=$('#education'+id);
    var sTitle=tr.find('.e-title');
    var sPrice=tr.find('.e-price');
    if(sTitle.val().length<1 || sPrice.val().length<1){
        $.notify('Fill Details','error');
        return;
    }

    var loading = $.notify("Loading....",{
        autoHide: false,
        style:'bootstrap',
        className:'info'
    });
    $.ajax({
        type: 'PUT',
        url:'/therapist/education/'+id,
        data:{
            _token:csrf,
            college:sTitle.val(),
            description:sPrice.val()
        }
    }).done(function (data) {
        $('.notifyjs-wrapper').trigger('notify-hide');
        $.notify("Updated Successfully....","success")
    }).fail(function () {
        $.notify("Update Failed....","error")
        $('.notifyjs-wrapper').trigger('notify-hide');

    });
}


$('.removeRow').bind('click',function () {
    $(this).parent().parent().parent().parent().parent().remove();
});

