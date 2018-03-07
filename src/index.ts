import app from './App'

const port = 3000;

app.listen(port, (err) => {
    if (err) {
        return console.log(err)
    }

    return console.log(`server is listening on ${port}`)
});