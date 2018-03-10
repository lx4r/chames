// PROTOTYPE

import * as express from 'express'
import {PriceCheck} from './PriceCheck'

class App {
    public express;

    constructor () {
        this.express = express();
        this.mountRoutes();

    }

    private mountRoutes (): void {
        const router = express.Router();
        router.get('/', (req, res) => {
            const priceChecker = new PriceCheck();
            priceChecker.getGamePrice(4422).then((price) => {
                res.json({
                    html: price
                });
            }, (err) => {
                console.log('Couldn\'t get the price', err);
                res.json({
                    html: 'error'
                });
            });
        });
        this.express.use('/', router);
    }

}

export default new App().express