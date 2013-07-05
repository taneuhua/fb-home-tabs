/* Facebook encapsulated functions */

function fbSetFrameHeight(height){
	FB.Canvas.setSize({ width: 760, height: height });
}

function fbSetAutoResize(){
	FB.Canvas.setAutoGrow();
}

function fbSetAutoGrow(){
	FB.Canvas.setAutoGrow();
}

function fbScrollTo(x,y){
	FB.Canvas.scrollTo(x,y);	
}

function fbAnimScrollToY(y, duration){
	FB.Canvas.getPageInfo(function(pageInfo){
		$({y: pageInfo.scrollTop}).animate(
			{y: y},
			{duration: duration, step: function(offset){
				FB.Canvas.scrollTo(0, offset);
			}
		});
    });
}

function fbInit(appId){
	FB.init({
		appId  : appId,
		status : true, // check login status
		cookie : true, // enable cookies to allow the server to access the session
		xfbml  : true  // parse XFBML
	});
}

function fbInitIE7(appId){
	FB.init({
		appId  : appId,
		status : false, // check login status
		cookie : true, // enable cookies to allow the server to access the session
		xfbml  : true  // parse XFBML
	});
}

function fbPostToWall(status, name, hyperlink, caption, description, media, action, userPrompt){
	FB.ui({
		method: 'stream.publish',
		message: status,
		attachment: {
			name: name,
			caption: caption,
			description: (description),
			media: media,
			href: hyperlink
		},
		action_links: action,
		user_message_prompt: userPrompt
	});
}

function resetFrameHeight(frame){
	var contentHeight = parseInt($(frame).height()) + 250;
	if(contentHeight < 900)
		fbSetFrameHeight(900);
	else
		fbSetFrameHeight(contentHeight);
}
