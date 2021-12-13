// Root directory
const root = "views/app/";
window.onload = () => {
	app.html.app = document.getElementById("app");
	app.route.current_url();
}

// Include style
connect.style(`${root}style/style.css`);

// Including core scripts
connect.script([
	`${root}menu.js`,
	`${root}core/template.js`,
	`${root}core/request.js`,
	`${root}core/config.js`,
	`${root}core/route.js`,
	`${root}routes.js`,
]);

// Application object
let app = {
	html: {}, // object with output elements
	controllers: {}, // controller scripts
	// config object
	config: {
		menu: {} // site menu
	},
	// Route object
	route: {
		// Routes
		routes: {},
		// Route variables
		var: {},
		// Method for adding routes
		add_route: (route, controller) => {
			route = slash_check(route);
			app.route.routes[route] = controller;
			connect.script(`${root}controllers/${controller.split("@")[0]}.js`);
		},
	}
};

