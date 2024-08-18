<!DOCTYPE html>
<html>
<head>
    <title>Stripe Payment</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>

<form action="{{ route('charge') }}" method="post" id="payment-form">
    @csrf
    <div class="form-row">
        <label for="card-element">Credit or debit card</label>
        <div id="card-element">
            <!-- Stripe Element will be inserted here. -->
        </div>
        <!-- Used to display form errors. -->
        <div id="card-errors" role="alert"></div>
    </div>
    <button type="submit">Submit Payment</button>
</form>

<script>
    // Use the correct publishable key based on the environment
    var stripeKey = "{{ config('services.stripe.env') === 'production' ? config('services.stripe.live_key') : config('services.stripe.test_key') }}";
    var stripe = Stripe(stripeKey);
    var elements = stripe.elements();
    var card = elements.create('card');
    card.mount('#card-element');

    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        stripe.createToken(card).then(function(result) {
            if (result.error) {
                // Show error in #card-errors element.
                document.getElementById('card-errors').textContent = result.error.message;
            } else {
                // Send the token to your server.
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', result.token.id);
                form.appendChild(hiddenInput);

                form.submit();
            }
        });
    });
</script>

</body>
</html>
