<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>to-do list</title>
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
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
            <div class="col-sm-12 col-md-6 mx-auto">
                <div class="card w-100">
                    <div class="card-body">
                        <input type="text" class="to-do-input w-100" placeholder="What needs to be done?">
                        <div id="to_do_list_items">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function () {
            console.log('ready');
        });
    </script>
    </body>
</html>
