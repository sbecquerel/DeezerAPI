# DeezerAPI
## Start
From root directory, first build containers (required once):  
`$ docker-compose build`

Then launch containers:  
`$ docker-compose up -d`

*Nb: the database will be automaticaly created, using sql files from sql directory.*

## Usage
GET users:  
`$ curl -v http://localhost/user`

GET user with id:  
`$ curl -v http://localhost/user/1`

GET tracks:  
`$ curl -v http://localhost/track`

GET track with id:  
`$ curl -v http://localhost/track/1`

GET favorites:  
`$ curl -v http://localhost/favorite`

GET user favorites (use user id):  
`$ curl -v http://localhost/favorite/1`

POST favorite:  
`$ curl -v -X POST -d id_user=1 -d id_track=1 http://localhost/favorite`

DELETE favorite:  
`$ curl -v -X DELETE http://localhost/favorite/1`
