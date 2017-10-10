# Subscribed.js
 ![Main screen](https://github.com/mingminghome/Subscribed.js/blob/master/readme-element/main.png?raw=true) 

A simple responsive subscription lightbox working with a php - MySQL backend.

You can tailor make **messages** , **button texts** & **lightbox size** by changing parameter in the plugin. 

If you have a lot of campaign running on the same time , you can divide different campaign using "**Event code**" to make sure your subscriptions are on their own list.

##### This repo contain following files
 1. Subscribed.js package (Plugin)
 2. Subscribed.js php package (Backend) - in the backend folder
 3. Subscribed.js MYSQL sql file (Database) - subscribe.sql
 4. Subscribed.js demo package (Demo) - in the demo folder


# How to use #



##### Simple usage
Call plugin css on the **&lt;HEAD&gt;** of the website
```
<link rel="stylesheet" type="text/css" href="jquery.subscribed.min.css">

```
Call plugin on the end of **&lt;body&gt;**
```
<script type="text/javascript" src="../jquery.subscribed.min.js" ></script>
```
Define a element with class for trigger
```
<a href="#" class="btn-trigger">Click Here</a>
```
Call the plugin with your customized message on the end of **&lt;body&gt;**
```javascript
<script type="text/javascript">
	$('.btn-trigger').SubscribedJS({
		event:'ABC123ab', //Event code
		title:'Your title', //Title
		desc:'Your description', // Desc
		tc:'* Your T&C', //TC
	    	succ:{ //Success msg
		    'title':'Success msg!',                                       
		    'desc':'Thanks for your application!'
	   	}
	});
</script>
```
Import MYSQL File to your database
> Import subscribed.sql

Place backend files to your server and make it can access from web

> Make sure **http: //[Your domain]/subscribe.php** can be access

Edit DB config file & fill in your DB information

> classes/db_config.php
```php
<?php
	define("DB_HOST", "localhost"); //DB Host
	define("DB_USER", ""); //User
	define("DB_PASS", ""); //Password
	define("DB_NAME", "subscribe_db"); //DB Table Name
	define("DB_PORT", "3306"); // Default SQL port
?>
```
Add a record on *[event]* table with 8 char long event ID or run the following SQL Query (Replace  8DIGCODE to your code)
```
INSERT INTO `event`(`event_key`) VALUES ('8DIGCODE')
```

##### All parameters

| Parameter | Default | Example | Desc |
| --- | --- | --- | --- |
| event | "" | **"ABC123ab"** | Event code (8 char long) |
| url | "" | **"./subscribe.php"** | Subscribe.php URL / Path |
| title | "" | **"Title"** | Title of the box |
| desc | "" | **"Description"** | Description of the box |
| width | "80%" | **"80%"** | Width of the box (% prefered) |
| top | "20%" | **"20%"** | Top padding of the box (% prefered) |
| left | "10%"	| **"10%"** | Left padding of the box (% prefered) |
| placeholder | "E-mail" | **"E-mail / Tel"** | Place holder of the input box |
| btnText | "Submit" | **"Submit"** | Submit button text |
| tc | "" | **"T&C"** | Terms and condition |
| gaEvent | "Subscribe Event" | **"Subscribe Event"** | GA Subscription event name |
| **err** | - | - | Error message |
| `01` | "May I know your E-mail address?" | - | Handle input error |
| `02` | "Please enter a valid E-mail address!" | | Email format error|
| `03` | "We found something unusual on our server! Please try again later!" | - | Server error |
| `04` | "We found something unusual on network! Please try again later!" | - | Network error |
| `05`| "You have already applied!" | - | Duplicate record error |
| **succ** | - | - | Success message display after submission |
| `title` | "(Font awesome icon)" | - | Message title |
| `desc` | "Thanks for your application!" | - | Message description |

##### Full usage example

```javascript
$('.sale_remind').SubscribedJS({
	event:'ABC123ab',
	url:'../backend/subscribe.php',
	title:'subscribeJs!',//Title on the subscription lightbox
	desc:'Create your own subscription service! Try now !',
	width : '80%',
	top: '20%',
	left: '10%',
	placeholder:'&#xf003; E-mail',
	btnText:'Submit',
	tc:'* I agree to make this plugin better ...',
	gaEvent:'Subscribe Event',
	err:{	'01':'&#xf059; May I know your E-mail address?',
		'02':'&#xf06a; Please enter a vaild E-mail address!',
		'03':'&#xf119; We found something unusual on our server! Please try again later!',
		'04':'&#xf119; We found something unusual on network! Please try again later!',
		'05':'&#xf119; You have already applied!'
	},
	succ:{
		'title':'Wooo!',
		"desc":"Thanks for your application!"
	}
});
```

# Dependencies
This plugin used **jQuery** as JavaScript Library
You can include it via https://jquery.com/ or use the CDN ( You can ref to Demo )
```
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
```
This plugin used **FontAwesome** for the icon display
You can include it via http://fontawesome.io use the CDN ( You can ref to Demo )
```
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
```


# License
MIT
