module.exports = {
	purge: [
		"./storage/framework/views/*.php",
		"./resources/**/*.blade.php",
		"./resources/**/*.js",
		"./resources/**/*.vue",
	],
	darkMode: false, // or 'media' or 'class'
	theme: {
		extend: {
			backgroundImage: {
				lunch: "url('/assets/lunchHP.jpg')",
				"control-food": "url('/assets/controlFood.jpg')",
				"manager-canteen": "url('/assets/managerCantina.jpeg')",
			},
		},
	},
	variants: {
		extend: {
			backgroundColor: ["active"],
			cursor: ["disabled"],
			opacity: ["disabled"],
		},
	},
	plugins: [],
};
