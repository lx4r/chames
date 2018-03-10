import {DBConstants} from "./DB_constants";
import {Game} from "./Game";

export class DB{
    // TODO: use singleton pattern for this class?

    private fs;
    private jsonObject:object;
    private games:Map<number,Game>;
    private 

    constructor(){
        this.fs = require('fs');
        this.getDBFromFile().then((database) => {
            console.log(database);
        })
    }

    public get(){}

    private getDBFromFile():Promise<object>{
        return new Promise<object>((resolve, reject) => {
            this.fs.readFile(DBConstants.DBFilePath, 'utf8', (err, data) => {
                if (err) {
                    reject(err);
                } else {
                    resolve(JSON.parse(data));
                }
            });
        })
    }

    public getGame():Game{
        this.jsonObject.games
    }
}