# Sputnik WP Theme with Webpack Front-End Configuration

## Installation

### use YARN please

> Use `yarn install` to install all dependencies.

### VS CODE EXTENSIONS

- Use VsCode snippets to write code easier. How to add: `F1 > Preferences: Configure User Snippets`.
- Use Better Comments.
- Use Es Lint.
- Use JavaScript (ES6) code snippets.

#### Snippets

```json
"Make var dump with pre": {
    "prefix": "predump",
    "body": [
        "echo '<pre>';",
        "var_dump($1);",
        "echo '</pre>';"
    ],
    "description": "Make var dump with <pre> tags."
},
"SVG icon function": {
    "prefix": "svgIcon",
    "body": [
        "function_exists('svg_icon') ? svg_icon('$1', $2) : false; ?>"
    ],
    "description": "Display svg icon when function svg_icon exists $string, $number"
},
"SVG icon function admin": {
    "prefix": "svgIconAdmin",
    "body": [
        "function_exists('svg_icon_admin') ? svg_icon_admin('$1', $2) : false; ?>"
    ],
    "description": "Display svg icon when function svg_icon_admin exists $string, $number"
},
"Echo string with translate & text-domain sputnik-wp-theme": {
    "prefix": "swpstring",
    "body": [
        "__('$1','sputnik-wp-theme'); ?>"
    ],
    "description": "Echo string with translate for sputnik-wp-theme textdomain"
},
"Create function template": {
    "prefix": "phpfunc",
    "body": [
        "if(!function_exists('$1')) {",
        "	function $1() {",
        "		$2",
        "	}",
        "}"
    ],
    "description": "Create new php function"
},
```

### Instructions

- use short php echo `<= ?>`.
- use string with translation & text domain `<?= __('', 'sputnik-wp-theme') >`.
- use all values in REM, in font-sizes, margins, paddings etc. Example: `11px => 1.1rem`. Rule example: `margin: 1rem`;
- Use responsive mixin breakpoints. Example `@include large { }`;
- If your make custom template parts structure like main banner. Please make it in `template-parts/custom/` folder.
- Please use only `Vanilla JavaScript`. Use jQuery only when it is very necessary.

#### Allow SVG

- If you want `add SVG in WordPress media library` you must prepare your svg file. `Remove IDs & change classnames` to unique class.
- Add this `<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">` to start of SVG file.

### Commands

- Use `yarn dev` to build dist folder in developer mode.
- Use `yarn build` to build dist folder with production mode.

### Tips

Sometimes jQuery not working properly with plugins in `developer mode`. Use `yarn build` to see if errors are still visible.

## TODO list

- Add autoupdater to theme.
- Own login page - modern and best ux/ui. With logo, flying labels etc.
- Custom columns with thumbnails, important informations. Easy & fast change thumbnail. Get ID.
