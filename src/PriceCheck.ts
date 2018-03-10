export class PriceCheck {
    // TODO: use Singleton pattern for this class?

    // TODO: use enums for this?
    static G2A_API_URL = 'https://www.g2a.com/marketplace/product/auctions/?id=';
    static G2A_API_LOWEST_PRICE_ATTRIBUTE = 'lowest_price';

    public getGamePrice(gameID: number):Promise<number> {
        const gameAPIURL = PriceCheck.G2A_API_URL + gameID;
        return this.getJSONFromURL(gameAPIURL).then((jsonObject:object) => {
            if (jsonObject.hasOwnProperty(PriceCheck.G2A_API_LOWEST_PRICE_ATTRIBUTE)){
                return jsonObject[PriceCheck.G2A_API_LOWEST_PRICE_ATTRIBUTE] as number;
            } else {
                throw new Error('lowest price attribute missing in JSON');
            }
        });
    }

    private getJSONFromURL(url: string):Promise<object>{
        return this.getContentFromURL(url).then(JSON.parse);
    }

    private getContentFromURL(url:string):Promise<string> {
        // return new pending promise
        return new Promise((resolve, reject) => {
            // select http or https module, depending on reqested url
            const lib = url.startsWith('https') ? require('https') : require('http');
            const request = lib.get(url, (response) => {
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
            request.on('error', (err) => reject(err))
        })
    };
}