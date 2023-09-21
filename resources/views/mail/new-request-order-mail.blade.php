<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

    <title>Deliveboo</title>
</head>

<body>
    <div id="request-order">
        <header>
            <img src="../../../public/storage/images/Logo_DeliveBoo_fff8E8.png">
        </header>
        <div class="container">
            <h1 class="text-light">
                Hello <span>{{ $user->restaurant_name }}</span>
            </h1>
            <br>
            <p>
                A new order for you...
            </p>
            <br>

            <div class="txt">
                <div>
                    <b>Client: </b>
                    {{ $newOrder->customer_name }}
                </div>
                <div>
                    <b>Delivery address: </b>
                    {{ $newOrder->customer_address }}
                </div>
                <div>
                    <b>Phone number: </b> {{ $newOrder->phone_number }}
                </div>
                <div>
                    <b>Email: </b>{{ $newOrder->email }}
                </div>
                <br>
                <b>Order details: </b>
                <ul>
                    @foreach ($newOrder['dishes'] as $dish)
                        <li>
                            {{ $dish->pivot->amount }}
                            {{ $dish->dish_name }}
                        </li>
                    @endforeach
                </ul>
                <b>Total: </b> {{ $newOrder->total_price }}
                <br>
            </div>
        </div>
    </div>

</body>

</html>
