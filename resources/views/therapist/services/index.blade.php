@extends('layouts.dashboard.therapist')



@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/therapist/dashboard">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Services</li>
    </ol>
    <div class="box_general padding_bottom">
        <div class="header_box version_2">
            <h2><i class="fa fa-folder"></i>Services</h2>
        </div>
        <div class="row">

            <div class="col-md-12">
                <form action="/therapist/edit-any-profile-detail" method="POST">
                    @csrf
                <div class="row">
                    <div class="col-md-12">
                        <h6>Price Statement</h6>
                    </div>
                    <div class="col-md-12">
                        <textarea name="price_statement" class="form-control" required  >{{$therapist->profile->price_statement}}</textarea>
                    </div>

                    <div class="col-md-12 mt-2 mb-4">
                        <button class="btn_1">Save</button>
                    </div>
                </div>
                </form>

            <h6>Treatments</h6>
                <table id="pricing-list-container" style="width:100%;">
                    @foreach($services as $s)
                    <tr id="service{{$s->id}}" class="pricing-list-item">
                        <td>

                                <div  class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" value="{{$s->service}}" name="services[]" class="form-control s-title" placeholder="Title">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" value="{{$s->price}}" class="form-control s-price"  placeholder="Price">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <button onclick="delSevice({{$s->id}})" class="btn btn-sm btn-danger btn-circle"><i class="fa fa-fw fa-remove"></i></button>
                                            <button onclick="updateService({{$s->id}})" class="btn btn-sm btn-info btn-circle" href="#"><i class="fa fa-fw fa-edit"></i></button>
                                        </div>
                                    </div>
                                </div>

                        </td>
                    </tr>
                    @endforeach
                </table>
                <a href="#0" class="btn_1 gray add-service"><i class="fa fa-fw fa-plus-circle"></i>Add Item</a>




            </div>
        </div>
        <!-- /row-->
    </div>

    <div class="box_general padding_bottom">
        <div class="header_box version_2">
            <h2><i class="fa fa-folder"></i>Specialization</h2>
        </div>
        <h6>Treatments</h6>
        <table id="s-list-container" style="width:100%;">
            @foreach($specializations as $s)
                <tr id="specialization{{$s->id}}" class="pricing-list-item">
                    <td>

                        <div  class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" value="{{$s->specialization}}" name="services[]" class="form-control s-title" placeholder="Title">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button onclick="delSpecialization({{$s->id}})" class="btn btn-sm btn-danger btn-circle"><i class="fa fa-fw fa-remove"></i></button>
                                    <button onclick="updateSpecialization({{$s->id}})" class="btn btn-sm btn-info btn-circle" href="#"><i class="fa fa-fw fa-edit"></i></button>
                                </div>
                            </div>
                        </div>

                    </td>
                </tr>
            @endforeach
        </table>
        <a href="#0" class="btn_1 gray add-specialization"><i class="fa fa-fw fa-plus-circle"></i>Add Item</a>

    </div>
    <style>
        .btn-circle{
            border-radius: 100% !important;
        }
    </style>
@endsection

@section('title')
    | {{$therapist->name}} |Services
@endsection
@section('scripts')
    <script src="/js/notify.min.js"></script>
    <script>
        var csrf='{{csrf_token()}}'
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text"  name="services[]" class="form-control s-title" placeholder="Title">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="number" step="any" class="form-control s-price"  placeholder="Price">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <button  class="btn btn-sm btn-success btn-circle addService"><i class="fa fa-fw fa-check"></i></button>
                                           </div>
                                    </div>
                                </div>

                        </td>
                    </tr>
            `)
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
                                            <button  class="btn btn-sm btn-success btn-circle addSpecialization"><i class="fa fa-fw fa-check"></i></button>
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

    </script>
@endsection