<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Payment</title>
    <link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
    <script src="https://js.stripe.com/v3/"></script>
</head>

<body>
    <div class="container">
        <div id="checkout" class="d-flex flex-column min-vh-100 justify-content-center align-items-center">
            {{-- Stripe Panel --}}
        </div>
    </div>

    <script>
        const stripe = Stripe(
            "{{ env('STRIPE_KEY') }}"
        );

        initialize();

        async function initialize() {
            const response = await fetch("{{ route('payment.charge') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')['content'],
                },
            });

            const {
                clientSecret
            } = await response.json();

            const checkout = await stripe.initEmbeddedCheckout({
                clientSecret,
            });

            checkout.mount('#checkout');
        }
    </script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
</body>

</html>
