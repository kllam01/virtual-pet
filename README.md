# virtual-pet
The prototype system I have developed for this virtual pet style game consists of 3 API functions and a database class that connect the system to a back-end database.

Testing has been done using Postman.

The database consists of 4 tables:

1.	pet
◦	Contain information related to the pet
◦	Such as pet_id, name, type, happiness & hunger etc.

2.	player
◦	Contain information related to player
◦	Such as player_id, username etc.

3.	pet type
◦	Contain information relate the type of pets

4.	link_player_pet
◦	Contain information related to pet ownership
◦	Such as player_id, pet_id

The 3 API functions are:

•	getPlayerPets
◦	Used for showing information of the pets owned by a player
◦	Receive the player id (presumably recorded when the player login) and returns an array of data consist of the information of the pets
◦	Return false if no pet is found or player id not received.
◦	Refer to screenshot #1 & #2

•	updatePlayerPet
◦	To update to happiness and hunger of a player's pet after player has taken action (stroke/feed)
◦	Receive player id and pet id and return an array of data consist of the information of the pet (after update)
◦	Also return a 'status' to show whether the update has been successful (or failed due to condition not being met, for example feeding pet when the pet is already full)
◦	Refer to screenshot #3 & #4

•	updateAllPets
◦	Used for updating the attribute (i.e. happiness & hunger) of all the pets
◦	Refer to screenshot #5



