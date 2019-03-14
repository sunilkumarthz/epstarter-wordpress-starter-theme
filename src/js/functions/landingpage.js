var landingpage = {
	el:{
		heading: "Hello World",
		description: "This is hello world",
	},
	getFunction : function(){
		console.log(landingpage.el.heading + " - " + landingpage.el.description);
	},
	setFunction:function(){
		landingpage.el.heading = "Hey !! , This is new Title";
		landingpage.el.description = "We are still in progress to modify structure";
	},
	init:function(){
		console.log('Here we can call initial function which needs to execute');
	}
}