module.exports = {
    darkMode: ['class', '[data-theme="dark"]'],
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./app/**/*.php",
        "./config/*.php"
    ],
    theme: {
        extend: {
            animation: {
                'ringing': 'ringing 2s ease 1s infinite',
                'bounceInDown': 'bounceInDown 0.7s ease 1 forwards;'
              },
              keyframes: {
                ringing: {
                    '0%': {transform:"rotate(-15deg)"},
                    '2%': {transform:'rotate(15deg)'},
                    '4%, 12%': {transform:'rotate(-18deg)'},
                    '6%, 14%': {transform:'rotate(18deg)'},
                    '8%': {transform:'rotate(-22deg)'},
                    '10%': {transform:'rotate(22deg)'},
                    '16%': {transform:'rotate(-12deg)'},
                    '18%': {transform:'rotate(12deg)'},
                    '20%': {transform:'rotate(0deg)'}
                },
                bounceInDown: {
                    '0%': {
                        opacity: 0,
                        transform: "translateY(20px)"
                    },
                    '100%': {
                        opacity: 1,
                        transform: "translateY(0)"
                    }
                }
            }
        },

        fontFamily: {
            'xetaravel': ['"Miriam Libre"'],
            'ubuntu': ['"Ubuntu, sans-serif']
        },
        container: {
            center: true
        }
    },
    plugins: [
        require('@tailwindcss/typography'),
        require('@tailwindcss/line-clamp'),
        require("daisyui")
    ],

    daisyui: {
        themes: [
            {
                light: {
                    ...require("daisyui/src/colors/themes")["[data-theme=light]"],
                    primary: "#f4645f",
                    "--rounded-box": "0.375rem",
                    "--rounded-btn": "0.25rem",
                    "--bc": "215 19% 35%",
                    "--pf": "2 87% 66%"
                }
            },
            {
                dark: {
                    ...require("daisyui/src/colors/themes")["[data-theme=dark]"],
                    primary: "#f4645f",
                    "--rounded-box": "0.375rem",
                    "--rounded-btn": "0.25rem",
                    "--bc": "213 27% 84%",
                    "--pf": "2 87% 66%"
                }
            }
        ],
    },

    // BYPASS TO COMPILE FULL CLASSES FOR DEV
    /*safelist: [
        {
          pattern: /./,
        }
    ],*/
}
