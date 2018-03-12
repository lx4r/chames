import {DBConstants} from "./DB_constants";
import {Game} from "./Game";

export class DB{
    // TODO: use singleton pattern for this class?

    /*
    convention for DB storage object:
    {
        maps <- stringified maps
        objects <- stringified objects
    }
     */

    private fs;
    private objects:object;
    private maps:Map<string, Map<string,object>>;

    constructor(){
        this.fs = require('fs');
        console.log("TESSTST");
        this.readDBFromFile();
        console.log(this.objects);
        console.log(this.maps);
    }

    public getObject(name:string):object{
        if (this.objects.hasOwnProperty(name)){
            return this.objects[name];
        } else {
            // invalid object name -> throw Error
            throw new Error("an object with the name " + name  + " does not exist in the database");
        }
    }

    public getObjectFromMap(nameOfMap: string, objectID: string):object{
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

    // overwrites object if it already exist
    public saveObject(name: string, object: object){
        this.objects[name] = object;
        this.saveDBToFile();
    }

    // overwrites object if it already exists, creates map if it doesn't exist
    public saveObjectInMap(id: string, object: object, mapName: string){
        const map = this.maps.get(mapName);
        if (map != undefined){
            // map exists -> save object
            map.set(id, object);
        } else {
            // map doesn't exist -> create map, save object to new map, save map
            const newMap = new Map();
            newMap.set(id, object);
            this.maps.set(mapName, newMap);
        }
        this.saveDBToFile();
    }

    private saveDBToFile(){
        // TODO: only re-calculate the string of the object/map that has been changed
        const mapOfMapArrays:Map<string,Array<Array<any>>> = new Map();
        this.maps.forEach((map: Map<string,object>, key: string) => {
            // convert each map to an array and then convert this array to a string
            const mapAsArray = [... map];
            //const mapAsString = JSON.stringify(mapAsArray);
            // save that string in a map
            mapOfMapArrays.set(key, mapAsArray);
        });
        // convert the top level map to an array and that array to a string
        //const mapOfMapStringsAsArray = [... mapOfMapArrays];
        const mapOfMapArraysAsArray = [... mapOfMapArrays];
        //const mapString = JSON.stringify(mapOfMapStringsAsArray);
        const mapString = JSON.stringify(mapOfMapArraysAsArray);
        const databaseObject = {
            maps: mapString,
            objects: this.objects
        };
        // using writeFileSync here to prevent race conditions
        // TODO: better way to do this?
        this.fs.writeFileSync(DBConstants.DBFilePath, JSON.stringify(databaseObject), 'utf8');
    }

    private readDBFromFile(){
        // using readFileSync here to prevent race conditions
        // TODO: better way to do this?
        console.log("readDBFromFile")
        try {
            console.log("yay1");
            /* this.fs.readFileSync(DBConstants.DBFilePath, 'utf8', (err, data) => {
                console.log("yay2");
                if (err) {
                    throw err;
                } else {
                    // parse DB content
                    const topLevelJSONObject = JSON.parse(data);
                    this.objects = topLevelJSONObject.objects;
                    const topLevelMap = new Map(topLevelJSONObject.maps);
                    this.maps = new Map();
                    topLevelMap.forEach((mapArray: Array<Array<any>>, mapName: string) => {
                        const newMap = new Map(mapArray);
                        this.maps.set(mapName, newMap);
                    });
                }
            });*/
            // TODO: use async version here?
            const fileContent = this.fs.readFileSync(DBConstants.DBFilePath, 'utf8');
            // parse DB content
            const topLevelJSONObject = JSON.parse(fileContent);
            this.objects = topLevelJSONObject.objects;
            const topLevelMap = new Map(JSON.parse(topLevelJSONObject.maps));
            this.maps = new Map();
            // TODO: fix type error here
            topLevelMap.forEach((mapArray: ReadonlyArray<Array<any>>, mapName: string) => {
                const newMap = new Map(mapArray);
                this.maps.set(mapName, newMap);
            });
        } catch (e) {
            console.log("got exception");
            if (e.code === 'ENOENT') {
                // file not found -> set database to empty
                this.maps = new Map();
                this.objects = {};
            } else {
                // other kind of error -> throw error
                throw e;
            }
        }
    }
}