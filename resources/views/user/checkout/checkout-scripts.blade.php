<script>
$(document).ready(function(){
    // Use the correct publishable key based on the environment
    var stripeKey = "{{ config('services.stripe.env') === 'production' ? config('services.stripe.live_key') : config('services.stripe.test_key') }}";
    var stripe = Stripe(stripeKey);
    var elements = stripe.elements();
    
    // Create an instance of the card Number Element
    var cardNumber = elements.create('cardNumber');
    cardNumber.mount('#card-number-element');

    // Create an instance of the card Expiry Element
    var cardExpiry = elements.create('cardExpiry');
    cardExpiry.mount('#card-expiry-element');

    // Create an instance of the card CVC Element
    var cardCvc = elements.create('cardCvc');
    cardCvc.mount('#card-cvc-element');
    
    // var card = elements.create('card');
    // card.mount('#card-element');

    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        stripe.createToken(cardNumber).then(function(result) {
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
})
</script>