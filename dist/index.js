"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const App_1 = require("./App");
const port = 3000;
App_1.default.listen(port, (err) => {
    if (err) {
        return console.log(err);
    }
    return console.log(`server is listening on ${port}`);
});
//# sourceMappingURL=index.js.map