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
    checkPrice(url) {
        return this.getContent(url);
    }
    getContent(url) {
        // return new pending promise
        return new Promise((resolve, reject) => {
            // select http or https module, depending on reqested url
            const lib = url.startsWith('https') ? require('https') : require('http');
            const requestOptions = {
                hostname: "www.g2a.com",
                path: "/kerbal-space-program-steam-key-global-i10000014989005",
                headers: {
                    "Accept": "application/ld+json",
                }
            };
            const request = lib.get(requestOptions, (response) => {
                // handle http errors
                if (response.statusCode < 200 || response.statusCode > 299) {
                    reject(new Error('Failed to load page, status code: ' + response.statusCode));
                }
                // temporary data holder
                const body = [];
                // on every content chunk, push it to the data array
                response.on('data', (chunk) => body.push(chunk));
                // we are done, resolve promise with those joined chunks
                response.on('end', () => resolve(body.join('')));
            });
            // handle connection errors of the request
            request.on('error', (err) => reject(err));
        });
    }
    ;
}
exports.default = new App().express;
//# sourceMappingURL=App.js.map