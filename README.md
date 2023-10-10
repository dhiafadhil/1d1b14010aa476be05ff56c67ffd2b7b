# 1d1b14010aa476be05ff56c67ffd2b7b
This repo for test levartech

## First Step

- Clone repository
  ``` git clone https://github.com/dhiafadhil/1d1b14010aa476be05ff56c67ffd2b7b.git ```
- Install dependencies
```bash
composer install
```
- Api server
```bash
sh start.sh
```
- To run event handler go to directiory standalone
```bash
sh email_event_handler.sh
```

## API Doc

#### Register Client

```
  POST /api/client.php
```
#### GET Client

```
  GET /api/client.php
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `id` | `String` | Client ID |

#### Auth

```
  POST /api/auth.php
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `client_id` | `String` | **Required** Client ID |
| `client_secret` | `String` | **Required** Client Secret |


#### Get all mails

```
  GET /api/mail.php
```

| Header | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `token` | `String` | Token get from auth api |

```
  POST /api/mail
```

| Body | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `to`      | `String` | **Required**. Destination email address |
| `cc`      | `String` | Destination email address of cc|
| `subject`      | `String` | **Required**. Email subject |
| `text`      | `String` | **Required**. Text Email |
