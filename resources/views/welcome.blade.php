<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>to-do list</title>
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link href="{{ asset('css/font-awesome.all.css') }}" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    </head>
    <body>
    <section class="container">
        <div class="row mt-5">
            <div class="col">
                <h1 class="text-center" style="color: #edcbe4; font-size: 5rem">todos</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-8 mx-auto">
                <div class="card w-100">
                    <div class="card-body">
                        <div class="d-inline-flex w-100">
                            <i id="forCollapse" data-toggle="collapse" data-target="#list_of_todo" class="text-black-50 fas fa-angle-down mr-2"></i>
                            <input id="to_do_input" type="text" class="w-100" placeholder="What needs to be done?">
                        </div>
                        <div class="collapse show" id="list_of_todo">
                            <hr>
                            <div id="to_do_list_items">
                            </div>
                            <div class="row">
                                <div class="col-sm">
                                    <a id="item_counter" class="text-right text-black-50" href="javascript:void(0)"></a>
                                </div>
                                <div class="col-sm">
                                    <div class="row">
                                        <div class="col-sm">
                                            <a id="item_all" class="text-right text-black-50" href="javascript:void(0)">All</a>
                                        </div>
                                        <div class="col-sm">
                                            <a id="item_active" class="text-right text-black-50" href="javascript:void(0)">Active</a>
                                        </div>
                                        <div class="col-sm">
                                            <a id="item_completed" class="text-right text-black-50" href="javascript:void(0)">Completed</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <a id="clare_completed" class="float-right text-black-50 sr-only" href="javascript:void(0)">Clear Completed</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function () {
            loadData('All');
        });

        function loadData(status) {
            let count = 1;
            $('#clare_completed').addClass('sr-only');
            $('#to_do_list_items').empty();
            $('#to_do_input').val('');
            $.ajax({
                method: 'get',
                url: '{{ url('get/all/data') }}',
                success: function (result) {
                    console.log(result);
                    if (result.length === 0){
                        $('#list_of_todo').addClass('sr-only');
                        $('#forCollapse').addClass('sr-only');
                    } else {
                        $('#list_of_todo').removeClass('sr-only');
                        $('#forCollapse').removeClass('sr-only');
                    }
                    if (status === 'All'){
                        $.each(result, function (key, value) {
                            if (value.status === 'Active'){
                                let element = '<p class="all_checkbox"><input id="to_do_checkbox_'+ key +'" class="to_do_checkbox" type="checkbox" value="'+ value.id +'"><input id="to_do_item_'+ key +'" class="to_do_item editable ml-2 w-75" data-id="'+ value.id +'" type="text" value="'+ value.to_do +'" disabled></p><hr>';
                                $('#to_do_list_items').append(element);
                            } else {
                                let element = '<p class="all_checkbox"><input id="to_do_checkbox_'+ key +'" class="to_do_checkbox" type="checkbox" value="'+ value.id +'" checked><input id="to_do_item_'+ key +'" class="to_do_item noteditiable ml-2 w-75" data-id="'+ value.id +'" type="text" value="'+ value.to_do +'" disabled></p><hr>';
                                $('#to_do_list_items').append(element);
                                $('#clare_completed').removeClass('sr-only');
                            }
                            $('#item_counter').text(count++ + ' items left');
                        })
                    }
                    if (status === 'Active'){
                        $.each(result, function (key, value) {
                            if (value.status === 'Active'){
                                let element = '<p class="all_checkbox"><input id="to_do_checkbox_'+ key +'" class="to_do_checkbox" type="checkbox" value="'+ value.id +'"><input id="to_do_item_'+ key +'" class="to_do_item editable ml-2" data-id="'+ value.id +'" type="text" value="'+ value.to_do +'" disabled></p><hr>';
                                $('#to_do_list_items').append(element);
                            } else {
                                $('#clare_completed').removeClass('sr-only');
                            }
                            $('#item_counter').text(count++ + ' items left');
                        })
                    }
                    if (status === 'Completed'){
                        $.each(result, function (key, value) {
                            if (value.status === 'Active'){

                            } else {
                                let element = '<p class="all_checkbox"><input id="to_do_checkbox_'+ key +'" class="to_do_checkbox" type="checkbox" value="'+ value.id +'" checked><input id="to_do_item_'+ key +'" class="to_do_item noteditiable ml-2" data-id="'+ value.id +'" type="text" value="'+ value.to_do +'" disabled></p><hr>';
                                $('#to_do_list_items').append(element);
                                $('#clare_completed').removeClass('sr-only');
                            }
                            $('#item_counter').text(count++ + ' items left');
                        })
                    }
                },
                error: function (xhr) {
                    console.log(xhr);
                }
            });
        }
        $(document).on('keypress', '#to_do_input', function (e) {
            let toDo = $('#to_do_input').val();
            if(e.which === 13) {
                let formData = new FormData();
                formData.append('to_do', toDo);
                formData.append('_token', '{{ csrf_token() }}');
                $.ajax({
                    method: 'post',
                    data: formData,
                    url: '{{ url('todo/save') }}',
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function (result) {
                        console.log(result);
                        loadData('All');
                    },
                    error: function (xhr) {
                        console.log(xhr);
                    }
                });
            }
        });

        $(document).on('dblclick', '.editable', function () {
            $(this).removeAttr('disabled', true).addClass('edititem');
        });

        $(document).on('keypress', '.to_do_item', function (e) {
            let toDo = $(this).val();
            if(e.which === 13) {
                let formData = new FormData();
                formData.append('id', $(this).data('id'));
                formData.append('to_do', toDo);
                formData.append('_token', '{{ csrf_token() }}');
                $.ajax({
                    method: 'post',
                    data: formData,
                    url: '{{ url('todo/save') }}',
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function (result) {
                        console.log(result);
                        loadData('All');
                    },
                    error: function (xhr) {
                        console.log(xhr);
                    }
                });
            }
        });

        $(document).on('click', '.to_do_checkbox', function () {
            let id = $(this).val();
            let status;
            if ($(this).prop('checked')===true){
                status = 'Completed';
            } else {
                status = 'Active';
            }
            let formData = new FormData();
            formData.append('id', id);
            formData.append('status', status);
            formData.append('_token', '{{ csrf_token() }}');
            $.ajax({
                method: 'post',
                data: formData,
                url: '{{ url('todo/update/status') }}',
                contentType: false,
                processData: false,
                cache: false,
                success: function (result) {
                    console.log(result);
                    loadData('All');
                },
                error: function (xhr) {
                    console.log(xhr);
                }
            });
        });

        $(document).on('click', '#item_all', function () {
            loadData('All');
        });

        $(document).on('click', '#item_active', function () {
            loadData('Active');
        });

        $(document).on('click', '#item_completed', function () {
            loadData('Completed');
        });

        $(document).on('click', '#clare_completed', function () {
            $.ajax({
                method: 'get',
                url: '{{ url('todo/delete') }}',
                contentType: false,
                processData: false,
                cache: false,
                success: function (result) {
                    console.log(result);
                    loadData('Completed');
                },
                error: function (xhr) {
                    console.log(xhr);
                }
            });
        });

        $(document).on('click', '#forCollapse', function () {
            if ($(this).hasClass('fa-angle-down')){
                $(this).removeClass('fa-angle-down').addClass('fa-angle-up');
            } else {
                $(this).removeClass('fa-angle-up').addClass('fa-angle-down');
            }
        });
    </script>
    </body>
</html>
