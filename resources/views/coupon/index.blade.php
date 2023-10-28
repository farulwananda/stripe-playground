<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <table class="table">
        <thead>
            <tr>
                <th>#ID</th>
                <th>Kode Kupon</th>
                <th>Diskon</th>
                <th>Times Reedemed</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <a href="{{ route('coupon.create') }}">Create a Coupon</a>
            @foreach ($coupons as $coupon)
                <tr>
                    <td>{{ $coupon->id }}</td>
                    <td>{{ $coupon->name }}</td>
                    <td>{{ $coupon->percent_off }}%</td>
                    <td>{{ $coupon->times_reedemed ?? '0' }}</td>
                    <td><a href="{{ route('coupon.show', $coupon->id) }}">Detail</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <hr>

    {{-- <form action="{{ route('coupon.create') }}" method="POST">
        @csrf
        <button>Create Coupon</button>
    </form> --}}
</body>

</html>
