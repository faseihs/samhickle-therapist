@extends('layouts.dashboard.therapist')



@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/therapist/dashboard">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Education</li>
    </ol>
    <div class="box_general padding_bottom">
        <div class="header_box version_2">
            <h2><i class="fa fa-folder"></i>Education</h2>
        </div>
        <div class="row">

            <div class="col-md-12">
                <form action="/therapist/edit-any-profile-detail" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <h6>Personal  Statement</h6>
                        </div>
                        <div class="col-md-12">
                            <textarea name="personal_statement" class="form-control"   >{{$therapist->profile->personal_statement}}</textarea>
                        </div>
                        <div class="col-md-12">
                            <h6>Education  Statement</h6>
                        </div>
                        <div class="col-md-12">
                            <textarea name="education_statement" class="form-control"   >{{$therapist->profile->education_statement}}</textarea>
                        </div>
                        <input name="redirectPath" value="/therapist/education" type="hidden">

                        <div class="col-md-12 mt-2 mb-4">
                            <button class="btn_1">Save</button>
                        </div>
                    </div>
                </form>

                <h6>Curriculum</h6>
                <table id="pricing-list-container" style="width:100%;">
                    @foreach($educations as $e)
                        <tr id="education{{$e->id}}" class="pricing-list-item">
                            <td>

                                <div  class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" value="{{$e->college}}" name="services[]" class="form-control s-title" placeholder="College">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" value="{{$e->description}}" class="form-control s-price"  placeholder="Degree">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <button onclick="delEducation({{$e->id}})" class="btn btn-sm btn-danger btn-circle"><i class="fa fa-fw fa-remove"></i></button>
                                            <button onclick="updateEducation({{$e->id}})" class="btn btn-sm btn-info btn-circle" href="#"><i class="fa fa-fw fa-edit"></i></button>
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

        $('.add-service').click(function () {
            $('#pricing-list-container').append(`
            <tr class="pricing-list-item">
                        <td>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text"  name="services[]" class="form-control s-title" placeholder="College">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text"  class="form-control s-price"  placeholder="Degree">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <button  class="btn btn-sm btn-success btn-circle addEducation"><i class="fa fa-fw fa-check"></i></button>
                                           </div>
                                    </div>
                                </div>

                        </td>
                    </tr>
            `)
            $('.addEducation').bind('click',function () {

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

        function updateEducation(id) {

            var tr=$('#education'+id);
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

    </script>
@endsection