<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Customer Email</title>
</head>

<body>
    <div style="padding-right:12.5px;padding-left:12.5px;margin-right:auto;margin-left:auto;">
        <table style="width:100%;border-collapse:collapse;">
            <tbody>
                <tr>
                    <td style="width: 20%;">Source website :</td>
                    <td style="width: 80%;">{{ $customer['soruce_website'] }}</td>
                </tr>
                <tr>
                    <td style="width: 20%;">Customer name :</td>
                    <td style="width: 80%;">{{ $customer['name'] }}</td>
                </tr>
                <tr>
                    <td style="width: 20%;">Customer phone :</td>
                    <td style="width: 80%;">{{ $customer['phone'] }}</td>
                </tr>
                <tr>
                    <td style="width: 20%;">Home location :</td>
                    <td style="width: 80%;">{{ $customer['home_location'] }}</td>
                </tr>
                <tr>
                    <td style="width: 20%;">State :</td>
                    <td style="width: 80%;">{{ $customer['home_state'] }}</td>
                </tr>
                <tr>
                    <td style="width: 20%;">Zip :</td>
                    <td style="width: 80%;">{{ $customer['home_zip'] }}</td>
                </tr>
            </tbody>
        </table>
        <hr>
        <table style="width:100%;border-collapse:collapse;">
            <tbody>
                <tr>
                    <td style="width: 30%;">
                        <h4>Floor plan chosen</h4>
                    </td>
                    <td style="width: 30%;">{{ $floorplan->plan_name }}</td>
                    <td style="width: 40%;">
                        <div style="text-align:center;height:200px">
                            <img src="{{ $floorplan->images[0]['pic_url'] }}" alt="{{ $floorplan->images[0]['pic_name'] }}" style="width:auto;height:auto;object-fit:cover;max-width:100%;max-height:100%;">
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <hr>
        <h4>Options chosen :</h4>
        <table style="width:100%;border-collapse:collapse;">
            <tbody>
                <tr>
                    <td style="width:25%;"><strong>Image</strong></td>
                    <td style="width:25%;"><strong>Group</strong></td>
                    <td style="width:25%;"><strong>Option Chosen</strong></td>
                    <td style="width:25%;"><strong>Customer Comment</strong></td>
                </tr>
                @forelse ($items as $item)
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
                @empty
                <tr>
                    <td>No chosen items</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <h6>Note :</h6>
        <p>{{ $note }}</p>
    </div>
</body>

</html>