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
| /user/[id_user]     | GET    | User            | `$ curl -v http://localhost/user/1`                                      |
| /track              | GET    | Tracks          | `$ curl -v http://localhost/track`                                       |
| /track/[id_track]   | GET    | Track           | `$ curl -v http://localhost/track/1`                                     |
| /favorite           | GET    | Favorites       | `$ curl -v http://localhost/favorite`                                    |
| /favorite/[id_user] | GET    | User favorites  | `$ curl -v http://localhost/favorite/1`                                  |
| /favorite           | POST   | Add favorite    | `$ curl -v -X POST -d id_user=1 -d id_track=1 http://localhost/favorite` |
| /favorite/[id_fav]  | DELETE | Delete favorite | `$ curl -v -X DELETE http://localhost/favorite/1`                        |

## Extension
### Output format
Default output format: **json**  
To add a new format, create a class in *class/response*, extending *Response* and define functions **sendHeader**, to set the content-type, and **sendResult**, to format output.  
To use new format, add class name as url last parameter. 

Example with a format named **xml**: http://localhost/user/xml or http://localhost/user/42/xml

### Add new objects
Procedure to add a new object *obj*
* Create a table named *obj*
* Add *obj* in the configuration file, in *entities* array and set access: get, post (creation), put (update) and delete.
* Create class *Obj* (optional) in *class/entity* directory, extending *entity* class. Set get, post (optional), put (optional) and delete (optional) functions.

### Add object new attributes
If a new column is added to the object database table, it will be automaticaly added in the reponse (@see entity class, function get).
