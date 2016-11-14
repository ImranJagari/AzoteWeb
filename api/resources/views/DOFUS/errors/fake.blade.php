<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Code</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .col-centered{
            float: none;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5 col-centered">
                <div class="panel panel-danger" style="margin-top:10px;">
                    <div class="panel-heading">Erreur</div>
                    <div class="panel-body">
                        @if (isset($message)) {{ $message }} @else Une erreur est survenue @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
