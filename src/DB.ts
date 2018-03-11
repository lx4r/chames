import {DBConstants} from "./DB_constants";
import {Game} from "./Game";

export class DB{
    // TODO: use singleton pattern for this class?

    private fs;
    private jsonObject:object;
    private maps:Map<string, Map<number,object>>;

    constructor(){
        this.fs = require('fs');
        this.getDBFromFile().then((database) => {
            this.jsonObject = database;
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

    public getObject(name:string):object{
        if (this.jsonObject.hasOwnProperty(name)){
            return this.jsonObject[name];
        } else {
            // invalid object name -> throw Error
            throw new Error("an object with the name " + name  + " does not exist in the database");
        }
    }

    public getObjectFromMap(nameOfMap: string, objectID: number):object{
        const map = this.maps.get(nameOfMap);
        if (map != undefined){
            const object = map.get(objectID);
            if (object != undefined){
                return object;
            } else {
                // object does not exist -> throw error
                throw new Error("an object with the id " + objectID + " does not exist in the map " + nameOfMap);
            }
        } else {
            // map does not exist -> throw Error
            throw new Error("a map with the name " + nameOfMap + " does not exist in the database");
        }
    }
}