
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Payment Page</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

        <style>
            .form-wrap{
                display: flex;
            }
            #payment-form{
                border: 1px solid #eee;
                padding: 30px 20px;
                border-radius: 10px;
                width: 500px;
                background: #f9f9f9;
            }
            .StripeElement {
            height: 40px;
            padding: 10px 12px;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
            }
            .successful-content-wrap{
                position: absolute;
                left: 0;
                right: 0;
                bottom: 0;
                top: 0;
            }
        </style>
    </head>
    <body>
        <div class="successful-content-wrap justify-content-center d-flex align-items-center flex-column">
           <h2 class="text-success"> Payment Successfull.</h2>
            <label class="text-muted mb-0">Please check reciept at</label>
            <a href="{{$link}}" class="text-center">{{$link}}</a>
        </div>
     </body>
</html>