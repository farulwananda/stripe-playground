<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    {{-- <link rel="stylesheet" href="{{ asset('stripe.css') }}"> --}}
</head>

<body>
    <div class="container">
        <div class="d-flex flex-column min-vh-100 justify-content-center align-items-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        Invoice
                    </div>
                    <div class="card-body">
                        <p>
                            {{ $customer->name }}
                        </p>
                        <p>
                            {{ $customer->email }}
                        </p>
                        <p>
                            {{ $customer->phone ?? 'N/A' }}
                        </p>
                        <table class="table">
                            <thead>
                                <th>Produk</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                            </thead>
                            <tbody>
                                @foreach ($lineItems->data as $lineItem)
                                    <tr>
                                        <td>{{ $lineItem->description }}</td>
                                        <td>${{ $lineItem->price->unit_amount / 100 }}</td>
                                        <td>{{ $lineItem->quantity }}</td>
                                        <td>${{ ($lineItem->price->unit_amount / 100) * $lineItem->quantity }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3"><b>Total</b></td>
                                    <td><b>${{ $totalPrice }}</b></td>
                                </tr>
                            </tbody>
                    </div>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="{{ $invoice }}" class="btn btn-primary">Print Invoice</a>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>
