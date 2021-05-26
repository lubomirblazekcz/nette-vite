import postcssImport from "postcss-import";
import postcssNesting from "postcss-nesting";
import autoprefixer from "autoprefixer";

export default {
    output: {
        dir: "www",
        scripts: "www/assets",
        styles: "www/assets"
    },
    input: {
        scripts: "src",
        styles: "src"
    },
    styles: {
        postcss: [postcssImport, postcssNesting, autoprefixer]
    }
}