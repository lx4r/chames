"use strict";
// PROTOTYPE
Object.defineProperty(exports, "__esModule", { value: true });
const express = require("express");
class App {
    constructor() {
        this.express = express();
        this.mountRoutes();
    }
    mountRoutes() {
        const router = express.Router();
        router.get('/', (req, res) => {
            res.json({
                html: 'Hello World!'
            });
            this.checkPrice("https://www.g2a.com/kerbal-space-program-steam-key-global-i10000014989005").then((html) => {
                var fs = require('fs');
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, "text/html");
                doc.getElementById("__schema.org");
                console.log(doc);
            });
        });
        this.express.use('/', router);
    }
    checkPrice(gameID) {
        return this.getContentFromURL(url);
    }
}
exports.default = new App().express;
//# sourceMappingURL=App.js.map