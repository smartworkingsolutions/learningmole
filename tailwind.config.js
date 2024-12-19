module.exports = {
	content: ["**/*.{html,php,svg}", "js/custom.js"],
	theme: {
		container: {
			center: true,
			padding: {
				DEFAULT: "1.5rem",
				lg: "2rem",
				"2xl": "2rem",
			},
		},
		extend: {
			colors: {
				"primary-color-100": "var(--clr-primary-100)",
				"primary-color-200": "var(--clr-primary-200)",
				"primary-color": "var(--clr-primary)",
				"secondary-color": "var(--clr-secondary)",
				"text-color": "var(--clr-text)",
				"hover-color": "var(--clr-hover)",
				"light-color": "var(--clr-light)",
				"border-color": "var(--clr-border)",
			},
			screens: {
				"2xl": "1440px",
			},
			boxShadow: {
				'custom': '0 5px 15px rgba(0,0,0,.05)',
				'custom-big': '0px 4px 20px 0px rgba(0, 0, 0, 0.08)',
				'glass': '0 5px 15px rgba(0,0,0,.05), 0 0 0 1px rgba(0,0,0,.07), 0 0 0 5px rgba(195,239,240,.3)',
				'green': '0px 10px 10px 0px rgba(83, 176, 175, 0.47)',
				'course': '0 10px 10px 0 rgba(0,0,0,.04)',
			},
			dropShadow: {
				'white': '3px 3px 1px rgba(255,255,255,.6)',
			},
			fontSize: {
				'32': '2rem',
				'42': '2.625rem',
			},
			transitionProperty: {
				height: "height",
				spacing: "margin, padding",
			},
			letterSpacing: {
				px: "0.063rem",
			},
			backgroundImage: {
				'tick': "url('../images/icons/tick.svg')",
			},
			borderRadius: {
				'10': '0.625rem',
			},
			animation: {
				'waves': '30s cubic-bezier(.36,.45,.63,.53) infinite wave',
				'wave-swell': '30s cubic-bezier(.36,.45,.63,.53) -.3s infinite wave, 10s -1.25s infinite swell',
			},
		},
	},
	plugins: [require("@tailwindcss/forms")],
};
