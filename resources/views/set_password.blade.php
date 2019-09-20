<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Payment Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <style>
        .form-wrap {
            display: flex;
        }

        #payment-form {
            border: 1px solid #eee;
            padding: 20px 20px 30px;
            border-radius: 10px;
            max-width: 500px;
            background: #f9f9f9;
            margin: auto;
            margin-top: 30px;
            width: 100%;
        }

        .StripeElement {
            height: 38px;
            padding: 10px 12px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            background-color: white;
            /* box-shadow: 0 1px 3px 0 #e6ebf1; */
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }


        .details-wrap {
            background: #fff;
            border-radius: 4px;
            border: 1px solid #ced4da;
            padding: 15px;
        }
    </style>
</head>

<body>

<div class="form-wrap d-flex justify-content-center align-items-center">
        <form action="{{url('/set_password')}}" method="post" id="set-password-form">
            @csrf
            <input type="hidden" name="hash" value="{{$hash}}" />

            <div class="top-wrap mb-3">
                <h3 class="text-center mb-0">Set Passowrd</h3>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input name="password" placeholder="" type="password" class="form-control" />
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input name="c_password" placeholder="" type="password" class="form-control" />
            </div>
         
            <button type="Submit" class="btn btn-primary mt-3">Set Password</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
   


</body>

</html>