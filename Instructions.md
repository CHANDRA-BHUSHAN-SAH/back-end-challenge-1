ModeStreet back-end challenge Solution Configuration
=======================

The solution contains all the required APIs as to add, edit, delete, view and list/search product(s).

The solution having basic authentication machanism.


## How to configure?

The configuration is very simple. You just need to follow some steps and all done.

Following are the steps:

- Configure a web server.
- Clone or download and unzip the project inside server root directory or sub-directory.
- Open the file named "env.php", which is in project home directory.
- Set the server url for constant "BASE_URL". Ex. 'http://modestreet-test.in/'
- Set the database informations as:
    - Database server name "DB_HOSTNAME". Ex. 'localhost'
    - Database name "DB_NAME". Ex. 'script_db'
    - Database username "DB_USERNAME". Ex. 'root'
    - Database password "DB_PASSWORD". Ex. 'pass'
    - To enable database result caching, set "DB_CACHE_ON" to 'TRUE' otherwise 'FALSE'
- Execute the query of file name "ModeStreetChallange.sql" for the specified database.

All Done! :)

## APIs Information

Following are the list of APIs which are required for the challenge:

### 1. Product Add API
Resource URL: <BASE_URL>product/add

Method: POST

Content-Type: application/json

Authorization: Basic dGVzdHVzZXI6UGFzc0AyMTQ=

Request Data:
```javascript
{"name":"Moda Rapido Men Grey & Black Colourblocked Round Neck T-shirt","size":"S","price":"479","descriptions":"Grey, black and maroon colourblocked T-shirt, has a round neck, long sleeves","images":"https://assets.myntassets.com/h_1440,q_100,w_1080/v1/assets/images/1829113/2018/2/6/11517896032192-Moda-Rapido-Men-Grey--Black-Colourblocked-Round-Neck-T-shirt-3821517896032055-1.jpg","category_id":1,"status":"Y"}
```

Response Data:
```javascript
{"status": true, "message": "Created Successfully", "id": 10}
```


### 2. Product Edit / Update API
Resource URL: <BASE_URL>product/update/id/{$id}         [Ex. id = 4]

Method: PUT

Content-Type: application/json

Authorization: Basic dGVzdHVzZXI6UGFzc0AyMTQ=

Request Data:
```javascript
{"size":"L","price":"249.00"}
```

Response Data:
```javascript
{"status":true,"message":"Updated Successfully","id":"4"}
```


### 3. Product Delete API
Resource URL: <BASE_URL>product/remove/id/{$id}     [Ex. id = 1]

Method: DELETE

Authorization: Basic dGVzdHVzZXI6UGFzc0AyMTQ=

Response Data:
```javascript
{"status":true,"message":"Deleted Successfully!","id":"1"}
```


### 4. Product view API
Resource URL: <BASE_URL>product/fetch/id/{$id}  [Ex. id = 4]

Method: GET

Authorization: Basic dGVzdHVzZXI6UGFzc0AyMTQ=

Response Data:
```javascript
{"status":true,"message":"success","product":{"id":"4","name":"White T-shirt","descriptions":"100 % cotton. Regural Fit","available_size":"S","price":"219.00","image":"https:\/\/i.ebayimg.com\/images\/g\/vTwAAOxydlFS-loL\/s-l300.jpg","category":"T-Shirts"}}
```


### 5. Product List / Search API
Resource URL: <BASE_URL>product/search/keyword/{$keyword}/page/{$page} [here keyword=white & page = 1]

Method: GET

Authorization: Basic dGVzdHVzZXI6UGFzc0AyMTQ=

Response Data:
```javascript
{"status":true,"message":"success","products":[{"id":"2","name":"Black n White T-shirt","available_size":"L","price":"329.00","image":null,"category":"T-Shirts"},{"id":"4","name":"White T-shirt","available_size":"L","price":"249.00","image":"https:\/\/i.ebayimg.com\/images\/g\/vTwAAOxydlFS-loL\/s-l300.jpg","category":"T-Shirts"},{"id":"6","name":"Formal Shirt","available_size":"40","price":"999.00","image":null,"category":"Shirts"}]}
```


## What's Next?
I am writing the PHPUnit Test Case for application and also implementing the elastic search.

.

---------------------------

--

__Thanks for evaluating.__


*Regards,*

**Chandra Bhushan Sah**
