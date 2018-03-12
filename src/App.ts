// PROTOTYPE

import * as express from 'express'
import {PriceCheck} from './PriceCheck'
import {DB} from './DB';

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
            const db = new DB();
            // db.saveObject("yay", {test1: 42, test2: 42});
            db.saveObjectInMap("object1", {test1: 42, test2: 42}, "newMap");
            console.log(db.getObjectFromMap('newMap', 'object1'));
            db.saveObject('test', {test2: "yay"});
        });
        this.express.use('/', router);
    }

}

export default new App().express