<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <style>
        .container {
            padding-right: 12.5px;
            padding-left: 12.5px;
            margin-right: auto;
            margin-left: auto;
        }
    </style>
</head>

<body>
    <div style="padding-right:12.5px;padding-left:12.5px;margin-right:auto;margin-left:auto;">
        <table style="width:100%;border-collapse:collapse;">
            <tr>
                <td style="width:40%;">
                    <div style="text-align:center;height:200px">
                        <img src="{{ $floorplan->images[0]['pic_url'] }}" alt="{{ $floorplan->images[0]['pic_name'] }}" style="width:auto;height:auto;object-fit:cover;max-width:100%;max-height:100%;">
                        <p style="margin-top:10px">{{ $floorplan->pivot->is_keep_same_name == 1 ? $floorplan->plan_name : $floorplan->pivot->floor_plan_rename }}</p>
                    </div>
                </td>
                <td style="width:60%;line-height:30px;margin-top:20px;">
                    <p>{{ $values['name'] }}</p>
                    <p>{{ $values['email'] }}</p>
                    <p>{{ $values['phone'] }}</p>
                    <p>{{ $values['home_location'] }}</p>
                    <p>{{ $values['home_state'] }}</p>
                    <p>{{ $values['home_zip'] }}</p>
                </td>
            </tr>
        </table>
        <hr>
        <table style="width:100%;border-collapse:collapse;">
            <tr>
                <td style="width:25%;"><strong>Image</strong></td>
                <td style="width:25%;"><strong>Group</strong></td>
                <td style="width:25%;"><strong>Option Chosen</strong></td>
                <td style="width:25%;"><strong>Customer Comment</strong></td>
            </tr>
            @foreach ($items as $item)
            @php
            $product = App\Models\Product::find($item['product_id']);
            @endphp
            <tr>
                <td style="width:25%;">
                    <div style="text-align:center;height:100px">
                        <img src="{{ $product->images[0]['pic_url'] }}" alt="{{ $product->images[0]['pic_name'] }}" style="width:auto;height:auto;object-fit:cover;max-width:100%;max-height:100%;">
                    </div>
                </td>
                <td style="width:25%;">{{ $product->productgroup->pdt_group_name }}</td>
                <td style="width:25%;">{{ $product->pdt_name }}</td>
                <td style="width:25%;">{{ $item['comment'] }}</td>
            </tr>
            @endforeach
        </table>
    </div>
</body>

</html>