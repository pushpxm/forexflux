const { log,error } = console;
const express = require('express');
const app = express();
const server = app.listen(3000,log('proxy works'));
const got = require('got');

const cors = require('cors');
//Tulind Functions
const { sma_inc, sma_inc2 } = require('./indicators');
  

app.use(cors());

app.get('/:symbol/:interval', async (req,res) => {
    try {
        const {symbol,interval} = req.params;
        const resp = await got(`https://api.binance.com/api/v3/klines?symbol=${symbol}&interval=${interval}`);
        const data = JSON.parse(resp.body);
        let klinedata = data.map((d) => ({
            time: d[0] / 1000,
            open: d[1] * 1,
            high: d[2] * 1,
            low: d[3] * 1,
            close: d[4] * 1,
          }));
          klinedata = await sma_inc(klinedata);
            klinedata = await sma_inc2(klinedata);

        
          res.status(200).send(klinedata)
    } catch (err) {
        res.status(500).send(error);
    }
})
    
