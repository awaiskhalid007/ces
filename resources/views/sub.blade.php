<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel='stylesheet' href='css/style.css' type='text/css' />
    <link rel='stylesheet' href='fontawesome/css/all.min.css' type='text/css' />
</head>
<body>

@include('dashboard.partials.header')

<section id="wrapper">
    <div class="col-md-12">
        <div class="row">
            @include('dashboard.partials.setting-sidebar')
            <div class="col-lg-9 rightpanel">
                <form action="subscribe" method="POST" id="subscribe-form">
                    <div class="form-group">
                        <div class="row">
                            @foreach($plans as $plan)
                                <div class="col-md-4">
                                    <div class="subscription-option">
                                        <input type="radio" id="plan-silver" name="plan" value='{{$plan->id}}'>
                                        <label for="plan-silver">
                                            <span class="plan-price">{{$plan->currency}}{{$plan->amount/100}}<small> /{{$plan->interval}}</small></span>
                                            <span class="plan-name">{{$plan->product->name}}</span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <input id="card-holder-name" type="text"><label for="card-holder-name">Card Holder Name</label>
                    @csrf
                    <div class="form-row">
                        <label for="card-element">Credit or debit card</label>
                        <div id="card-element" class="form-control">
                        </div>
                        <!-- Used to display form errors. -->
                        <div id="card-errors" role="alert"></div>
                    </div>
                    <div class="stripe-errors"></div>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        </div>
                    @endif
                    <div class="form-group text-center">
                        <button  id="card-button" data-secret="{{ $intent->client_secret }}" class="btn btn-lg btn-success btn-block">SUBMIT</button>
                    </div>
                </form>
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
    flag = 0;
    $('#newPassword').keyup(function(){
        var eightletters = /^(?=.*\d).{8,}$/;
        if($('#newPassword').val().match(eightletters)) {
            $('.one i').addClass('fa fa-check');
            flag == 1

        } else {
            $('.one i').removeClass('fa fa-check');
            flag = 0;

        }

        var number_symbol = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/;
        if($('#newPassword').val().match(number_symbol)) {
            $('.two i').addClass('fa fa-check');
            flag = 1;
            $("#updatePass").attr('disabled',false);
        } else {
            $('.two i').removeClass('fa fa-check');
            flag = 0;
            $("#updatePass").attr('disabled',true);
        }

        var email = $('#email').val();
        var name = $('#name').val();

        if($('#newPassword').val().match(email) || $('#newPassword').val().match(name)) {
            $('.three i').removeClass('fa fa-check');
            flag = 0;
        } else {
            $('.three i').addClass('fa fa-check');
            flag = 1;
        }

    });
</script>


<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe = Stripe('{{ env('STRIPE_KEY') }}');
    var elements = stripe.elements();
    var style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };
    var card = elements.create('card', {hidePostalCode: true,
        style: style});
    card.mount('#card-element');
    card.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });
    const cardHolderName = document.getElementById('card-holder-name');
    const cardButton = document.getElementById('card-button');
    const clientSecret = cardButton.dataset.secret;
    cardButton.addEventListener('click', async (e) => {
        console.log("attempting");
        const { setupIntent, error } = await stripe.confirmCardSetup(
            clientSecret, {
                payment_method: {
                    card: card,
                    billing_details: { name: cardHolderName.value }
                }
            }
        );
        if (error) {
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = error.message;
        } else {
            paymentMethodHandler(setupIntent.payment_method);
        }
    });
    function paymentMethodHandler(payment_method) {
        var form = document.getElementById('subscribe-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'payment_method');
        hiddenInput.setAttribute('value', payment_method);
        form.appendChild(hiddenInput);
        form.submit();
    }
</script>
</body>
</html>
