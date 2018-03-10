// PROTOTYPE

import * as express from 'express'

class App {
    public express;

    constructor () {
        this.express = express();
        this.mountRoutes();

    }

    private mountRoutes (): void {
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

    private checkPrice(gameID:number):Promise<string>{
        return this.getContentFromURL(url);
    }

}

export default new App().express