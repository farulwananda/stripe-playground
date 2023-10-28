<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>Edit Kupon</h1>
    {{-- {{ route('coupon.update', $promotionCode->id) }} --}}
    <form action="" method="post">
        @csrf

        <input type="text" value="{{ $promotionCode->code }}" disabled>
        <select name="promotionStatus">
            <option value="true" {{ $promotionCode->active ? 'selected' : '' }}>Active</option>
            <option value="false" {{ !$promotionCode->active ? 'selected' : '' }}>Inactive</option>
        </select>
        <input type="submit" value="Simpan">
    </form>
</body>

</html>
