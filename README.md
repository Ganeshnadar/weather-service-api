# Weather Services Apis

## Prerequisite

- Php v8
- Mysql
- lumen
- composer

#### Update env

```sh
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=weather_service_api
DB_USERNAME=root
DB_PASSWORD=
OPEN_WEATHER_API_KEY=858f15fed9292cbe25c341a754c55e45
```

## Installation

Install all the dependencies and Dev dependencies 
- Composer install

## API Reference

#### Create City

```http
    POST /api/v1/city/create

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `name`    | `string` | *Required*.  Name |
```

    Response

```json
 {
    "success": true,
    "status": 200,
    "message": "City Saved",
    "error": [],
    "data": {
        "name": "chennai",
        "lat": 13.0836939,
        "lon": 80.270186,
        "country": "IN",
        "state": "Tamil Nadu",
        "updated_at": "2022-05-07T10:08:46.000000Z",
        "created_at": "2022-05-07T10:08:46.000000Z",
        "id": 4
    }
}
```

#### Get City list with Weather details

```http
    POST /api/v1/city

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `name`    | `string` |  City Name                 |
```

    Response

```json
{
    "success": true,
    "status": 200,
    "message": "City List",
    "error": [],
    "data": [
        {
            "id": 3,
            "name": "mumbai",
            "lat": "19.0759899",
            "lon": "72.8773928",
            "state": "Maharashtra",
            "country": "IN",
            "created_at": "2022-05-07T09:25:31.000000Z",
            "updated_at": "2022-05-07T09:25:31.000000Z",
            "weatherDetail": [
                {
                    "dt": 1651924800,
                    "main": {
                        "temp": 305.57,
                        "feels_like": 312.23,
                        "temp_min": 304.41,
                        "temp_max": 305.57,
                        "pressure": 1005,
                        "sea_level": 1005,
                        "grnd_level": 1004,
                        "humidity": 63,
                        "temp_kf": 1.16
                    },
                    "weather": [
                        {
                            "id": 800,
                            "main": "Clear",
                            "description": "clear sky",
                            "icon": "01d"
                        }
                    ],
                    "clouds": {
                        "all": 0
                    },
                    "wind": {
                        "speed": 5.77,
                        "deg": 299,
                        "gust": 6.74
                    },
                    "visibility": 10000,
                    "pop": 0,
                    "sys": {
                        "pod": "d"
                    },
                    "dt_txt": "2022-05-07 12:00:00"
                }
            ]
        }
    ]
}
```
