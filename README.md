SF-foodtrucks -  full stack
=============

<p align="justify">This project renders markers to location of all food trucks found in San Francisco. The food truck data is available on <a href="www.datasf.com">DatSF</a>: <a href="https://data.sfgov.org/Permitting/Mobile-Food-Facility-Permit/rqzj-sfat">Food Trucks</a><br/><br/>

Users can access the functioning website from the following link <a href="http://weejay.byethost13.com/">SF: Food Trucks</a><br/><br/>

I used locationDescription field from the database to provide users the choice to select a location. This field made the most sense for choosing a location. When you select a location from the dropdown list, it shows the food trucks within that block of the address you selected. By playing with different fields in the database, I found "block" to be the best combination between number of location returned and closeness to each other. When you click on the markers that is displayed, it will shown an info window with name of the food truck, its address and the distance from your current location. It calculates your current location when you load the page and calculates the distance to each marker location that is displayed in the site (an additional functionality).<br/><br/>

This project is developed using PhP (server side), Javascript (client side) and MySQL (DB). I am fairly experienced with these technologies and did not want to waste time using something new. I tried to work with Python and Backbone.js however am not an experienced programmer in python and never had any experience with Backbone and it seemed like there was a bit of learning curve with it. So stuck to what works best for me.<br/><br/>

If I had more time, I would probably organize my front end a little bit. Its fairly simple, wanted to present a list of food trucks (text) next to the map. </p>



