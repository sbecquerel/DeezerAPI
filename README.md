# DeezerAPI
## Start
From root directory, first build containers (required once):  
`$ docker-compose build`

Then launch containers:  
`$ docker-compose up -d`

*Nb: the database will be automaticaly created, using sql files from sql directory.*

## Routes
| Route               | Method | Return          | Example                                                                  |
| ------------------- | ------ | ----------------| ------------------------------------------------------------------------ |
| /user               | GET    | Users           | `$ curl -v http://localhost/user`                                        |
| /user/[id]          | GET    | User            | `$ curl -v http://localhost/user/1`                                      |
| /track              | GET    | Tracks          | `$ curl -v http://localhost/track`                                       |
| /track/[id]         | GET    | Track           | `$ curl -v http://localhost/track/1`                                     |
| /favorite           | GET    | Favorites       | `$ curl -v http://localhost/favorite`                                    |
| /favorite/[id_user] | GET    | User favorites  | `$ curl -v http://localhost/favorite/1`                                  |
| /favorite           | POST   | Add favorite    | `$ curl -v -X POST -d id_user=1 -d id_track=1 http://localhost/favorite` |
| /favorite/[id]      | DELETE | Delete favorite | `$ curl -v -X DELETE http://localhost/favorite/1`                        |
