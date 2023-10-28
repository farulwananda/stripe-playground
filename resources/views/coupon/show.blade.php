<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <form action="{{ route('coupon.store') }}" method="POST">
        @csrf
        <label for="">Coupon Name</label>
        <input type="text" name="name">
        <label for="">Percent Off</label>
        <input type="text" name="percent_off">
        <button>Create Coupon</button>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>#ID</th>
                <th>Kode Kupon</th>
                <th>Diskon</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($promotionCodes as $promotionCode)
                <tr>
                    <td>{{ $promotionCode->id }}</td>
                    <td>{{ $promotionCode->code }}</td>
                    <td>{{ $promotionCode->coupon->percent_off }}%</td>
                    <td>{{ $promotionCode->active ? 'Aktif' : 'Tidak Aktif' }}</td>
                    <td><a href="{{ route('promotion.show', $promotionCode->id) }}">Detail</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
