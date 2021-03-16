<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/">
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel='stylesheet' href='css/style.css' type='text/css' />
    <link rel='stylesheet' href='fontawesome/css/all.min.css' type='text/css' />
</head>
<body id="billings">

    @include('dashboard.partials.header')

    <section id="wrapper">
        <div class="col-md-12">
            <div class="row">
                @include('dashboard.partials.setting-sidebar')
                <div class="col-lg-9 col-md-12 col-sm-12 rightpanel ">
                    <div class="container-fluid text-center p-0">
                        <h2 class="main_heading">
                            <!-- model for user btn  -->
                            <button type="button" class="btn btn-link p-0" data-toggle="modal" data-target="#myModal"
                                style="font-size: 35px;">
                                <span>
                                    <i class="far fa-credit-card"></i>
                                </span>Add your Credit Card Details
                            </button>
                            to guarantee uninterrupted access.
                        </h2>
                        <!-- Modal -->
                       
                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content text-left">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Update Credit Card</h4>
                                        <button type="button" class="close"
                                            data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    <label for=card_no>Card Number</label>
                                                    <input type="text" class="form-control" name="number" value="{{$billing[0]->number}}" 
                                                        id="card_no">
                                                    <p id="emptyError1" style="color: red;font-size: 14px;display: none;">*Credit card number is a required field.</p>
                                                    <p id="errors1" style="color: red;font-size: 14px;display: none;"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="date">Expiry</label>
                                                    <input type="date" class="form-control"
                                                        id="date" name="expiry" value="{{$billing[0]->expiry}}" placeholder="DD/MM/YY">
                                                    <p id="emptyError2" style="color: red;font-size: 14px;display: none;">*Expiry date is required.</p>
                                                    <p id="errors2" style="color: red;font-size: 14px;display: none;"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="fname">Name</label>
                                                    <input type="text" class="form-control" name="name" value="{{$billing[0]->name}}"
                                                        id="fname">
                                                    <p id="emptyError3" style="color: red;font-size: 14px;display: none;">*Name is required.</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="code">Security Code</label>
                                                    <input type="number" class="form-control"
                                                        id="code" name="cvv" value="{{$billing[0]->cvv}}" placeholder="CV">
                                                    <p id="emptyError4" style="color: red;font-size: 14px;display: none;">*Security Code is required.</p>
                                                    <p id="errors4" style="color: red;font-size: 14px;display: none;"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" id="addCard" class="btn btn-primary">Submit</button>
                                        <button class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p>Your trial expires in 12 days</p>
                    </div>

                    <div class="container-fluid mb-2 p-4 card text-center">
                        <div class="row">
                            <div class="col-md-3 col-sm-3 col-xs-3">
                                <span class="more_info">
                                    <i class="fa fa-question "></i> 
                                    More Info
                                </span>
                                <h6>Renewal Amount</h6>
                                <h6>$<?php echo 69 * (int)$user[0]->licences; ?> USD</h6>
                            </div>
                            <div class="col-md-1 col-sm-1 col-xs-1">
                                <span class="symbol"><i class="fa fa-plus my-4"></i></span>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3 question">
                                <span class="more_info">
                                    <i class="fa fa-question "></i> 
                                    More Info
                                </span>
                                <h6>Balance</h6>
                                <h6>$0 USD</h6>
                            </div>
                            <div class="col-md-1 col-sm-1 col-xs-1">
                                <span class="symbol"><i class="fa fa-equals my-4 "></i></span>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4 question">
                                <span class="more_info">
                                    <i class="fa fa-question "></i> 
                                    More Info
                                </span>
                                <h6>Upcoming Bill</h6>
                                <h6>$<?php echo 69 * (int)$user[0]->licences; ?> USD</h6>
                            </div>
                        </div>
                        <p class="text-center">Upcoming Bill of <b>$<?php echo 69 * (int)$user[0]->licences; ?> USD</b> based on <b>{{$user[0]->licences}} licence(s)</b> plus the outstanding
                            balance from licence changes during this billing period (12/12/2020 to 26/12/2020).</p>
                    </div>

                    <div class="container-fluid mb-1 p-0">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <div class="card profile" style="width: 100%">
                                    <div class="card-header wordstrong">
                                        <p class="mb-0">Credit Card</p>
                                    </div>
                                    
                                    <div class="container">
                                        <!-- model for user btn  -->
                                        @if($billing[0]->number == '' || $billing[0]->number== null)
                                        <div class="col-md-12 text-center">
                                            <button type="button" class="btn btn-lg btn-primary creditcard"
                                            data-toggle="modal" data-target="#myModal"> <span>
                                                <i class="far fa-credit-card"></i>
                                            </span> Add Card</button>
                                        </div>
                                        @else
                                            <div class="container py-2 text-left">
                                                <p><strong>Name: </strong>{{$billing[0]->name}}</p>
                                                <p><strong>Card Number: </strong>XXXX-XXXX-XXXX-<?php echo substr($billing[0]->number, -4); ?></p>
                                                <p>
                                                    <strong>Expiry: </strong>
                                                    <?php echo date('m/Y', strtotime($billing[0]->expiry)) ?>
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                    @if($billing[0]->number != '' || $billing[0]->number != null)
                                    <div class="card-header card-bottom">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#myModal"> <span>
                                                        <i class="fa fa-credit-card"></i>
                                                    </span>Update Card
                                                </button>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <form action="{{route('creditcard.remove')}}" method="POST">
                                                @csrf
                                                    <button class="bg-light remove_credit_card">
                                                        <i class="fa fa-times"></i>
                                                        &nbsp; Remove Card
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card profile" style="width: 100%">
                                    <div class="card-header wordstrong">
                                        <p class="mb-0">Billing Details</p>
                                    </div>
                                    <div class="container py-2">
                                        <p><strong>Organisation: </strong>{{$billing[0]->company}}</p>
                                        <p><strong>Name: </strong>{{$billing[0]->name}}</p>
                                        <p><strong>Email: </strong>{{$billing[0]->email}}</p>
                                        @if($errors->any())
                                            @if($errors->first() == 'billing_updated')
                                                <div class="alert alert-success">Billing details updated!</div>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="container-fluid p-0">
                                        <form action="{{route('billing.update')}}" method="POST">
                                            @csrf
                                            <div class="card-header card-bottom">
                                                <!-- model for user btn  -->
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#myModal2"> <span>
                                                        <i class="fa fa-edit"></i>
                                                    </span>Update Details</button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="myModal2" role="dialog">
                                                    <div class="modal-dialog">
                                                        <!-- Modal content-->
                                                        <div class="modal-content text-left">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Update Billing Details</h4>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal">&times;</button>

                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                        <label for="org_name">Organization Name</label>
                                                                        <input type="text" class="form-control" id="organization" name="company" value="{{$billing[0]->company}}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="email">Email</label>
                                                                            <input type="email" class="form-control"
                                                                             name="email" value="{{$billing[0]->email}}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="name">Name</label>
                                                                            <input type="text" class="form-control"
                                                                                id="name" name="name" value="{{$billing[0]->name}}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="phone">Phone</label>
                                                                            <input type="text" class="form-control"
                                                                                id="phone" name="phone" value="{{$billing[0]->phone}}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit"
                                                                    class="btn btn-primary">Submit</button>
                                                                <button class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card profile" style="width: 100%">
                        <div class="card-header wordstrong">
                            <p class="mb-0">Invoices</p>
                        </div>
                        <div class="container-fluid p-0">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Number</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <td colspan="4">
                                        <em>
                                            <p class="text-muted mb-0">We haven't issued you any invoices yet.</p>
                                        </em>
                                    </td>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="container-fluid mt-2">
                        <!-- model for user btn  -->
                        <button type="button" class="btn btn-link btn-sm" data-toggle="modal" data-target="#myModal3"
                            style="float: right;"> <span>
                                <i class="fa fa-ban"></i>
                            </span>Cancel account</button>
                        <!-- Modal -->
                        <div class="modal fade" id="myModal3" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content text-left">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Cancel Subscription</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                                    </div>
                                    <div class="modal-body">
                                        <p>In order to improve Groundplan, could you please help us understand your
                                            reason for cancellation</p>
                                        <form action="">
                                            <label for="1">
                                                <input type="radio" name="box" id="1"> Switching to another product
                                            </label>
                                            <label for="2">
                                                <input type="radio" name="box" id="2"> Had a poor experience with
                                                Customer Support / Training
                                            </label>
                                            <label for="3">
                                                <input type="radio" name="box" id="3"> Other
                                            </label> <br>
                                            <label for="Feedback" class="wordstrong">Feedback(optional):</label>
                                            <textarea name="" class="form-control" id="Feedback" cols="30"
                                                rows="4"></textarea>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger"> <span><i
                                                    class="fa fa-ban"></i></span> Cancel Subscription</button>
                                        <button type="button" class="btn btn-primary" data-dismiss="modal">Keep Using
                                            Groundplan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        </div>
    </section>

    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="fontawesome/js/all.min.js"></script>
    <script src="js/ajax.js"></script>
    <script>
        var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
         $('ul#navlinks a').each(function() {
          if (this.href === path) {
           $(this).addClass('active');
          }
         });
        let ajax = 1;
        $("#addCard").click(function(){
           
            // hiding errors
            $("#myModal p").hide();
            var regExp = /[a-zA-Z]/g;
            // Getting values
            var number = $("#myModal input[name='number']").val();
            var expiry = $("#myModal input[name='expiry']").val();
            var name = $("#myModal input[name='name']").val();
            var cvv = $("#myModal input[name='cvv']").val();
            ajax = 1;
            var d = new Date();
            var month = d.getMonth()+1;
            var day = d.getDate();
            var year = d.getFullYear();

            var current_date = year+'-'+month+'-'+day;

            // validation
            if(number == '')
            {
                $("#myModal p#emptyError1").show();
                ajax = 0;
            }
            if(expiry == '')
            {
                $("#myModal p#emptyError2").show();
                ajax = 0;
            }
            if(name == '')
            {
                $("#myModal p#emptyError3").show();
                ajax = 0;
            }
            if(name.length == 0)
            {
                ajax = 0;
            }
            if(cvv == '')
            {
                $("#myModal p#emptyError4").show();
                ajax = 0;
            }

            
            if(number.length > 0){
                if(number.length < 16 || number.length > 19)
                {
                    $("#myModal p#errors1").html('Please enter a valid card number.');
                    $("#myModal p#errors1").show();
                    ajax = 0;
                }
                if(regExp.test(number)){
                  $("#myModal p#errors1").html('Please enter a valid card number.');
                  $("#myModal p#errors1").show();
                  ajax = 0;
                }
            }

            if(new Date(expiry) <= new Date(current_date))
            {
                $("#myModal p#errors2").html('Please enter a valid expiry date.');
                $("#myModal p#errors2").show();
                ajax = 0;
            }
            if(cvv.length < 3 || cvv.length > 4 || regExp.test(cvv))
            {
                $("#myModal p#errors4").html('Please enter a valid security code.');
                $("#myModal p#errors4").show();
                ajax = 0;
            }
            console.log(ajax);
            if(ajax == 1)
            {
                var CSRF_TOKEN = $("meta[name='csrf-token']").attr('content');
                var data = {
                    number,expiry,name,cvv 
                };
                $.ajax({
                    type: 'POST',
                    url: '/setup/billing/add/creit_info',
                    data: {_token:CSRF_TOKEN, data: data},
                    success: function(res)
                    {
                        if(res == 'ok')
                        {
                            window.open('/setup/billing','_self');
                        }
                    }
                });
            }
        });
    </script>
</body>

</html>