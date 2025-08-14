{{-- resources/views/checkout.blade.php --}}
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Pay</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        .sr-input,
        #card-element {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .sr-btn {
            padding: 12px 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .sr-error {
            color: #b00020;
            margin-top: 8px;
        }
    </style>
</head>

<body>
    <h1>Complete your payment</h1>

    <form id="payment-form">
        <label>
            Name on card
            <input class="sr-input" id="name" placeholder="Jane Doe" required>
        </label>
        <br><br>

        <div id="card-element"></div>
        <div id="card-errors" class="sr-error" role="alert"></div>

        <br>
        <button id="submit" class="sr-btn">Pay $19.99</button>
    </form>

    <script>
        const stripe = Stripe('{{$stripeKey}}');
        const elements = stripe.elements();
        const card = elements.create('card');
        card.mount('#card-element');

        card.on('change', ({ error }) => {
            const displayError = document.getElementById('card-errors');
            displayError.textContent = error ? error.message : '';
        });

        document.getElementById('payment-form').addEventListener('submit', async (e) => {
            e.preventDefault();

            // Example: $19.99 in USD = 1999 cents
            const payload = {
                amount: 1999,
                currency: 'USD',
                name: document.getElementById('name').value,
            };

            const res = await fetch('{{route('member.pay.stripe.intent')}}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(payload)
            });

            const { client_secret } = await res.json();

            const { error, paymentIntent } = await stripe.confirmCardPayment(client_secret, {
                payment_method: {
                    card,
                    billing_details: { name: payload.name }
                }
            });

            if (error) {
                document.getElementById('card-errors').textContent = error.message;
                return;
            }

            if (paymentIntent && paymentIntent.status === 'succeeded') {
                window.location = '{{route('member.pay.success')}}';
            }
        });
    </script>
</body>

</html>