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
</body>

</html>
