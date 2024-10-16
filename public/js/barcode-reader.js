// import Quagga.js

class BarcodeReader {
  constructor() {
    Quagga.onProcessed(this._onProcessed.bind(this));
    Quagga.onDetected(this._onDetected.bind(this));
  }

  get config() {
    return {
      // イメージソースの定義
      inputStream: {
        // イメージを表示する場所（デフォルトはid="interactive"）
        target: '#preview',
        // Canvasのサイズ
        size: 640,
        singleChannel: false
      },
      locator: {
        patchSize: "medium",
        halfSample: true
      },
      // バーコードの種類
      decoder: {
        readers: [{
          format: "ean_reader",
          config: {}
        }]
      },
      // Web Workerの数
      numOfWorker: navigator.hardwareConcurrency || 4,
      // 画像内にバーコードを表示させる？
      locate: true,
      src: null
    };
  }

  /**
   * バーコードを読み込む
   * @param {DOMString} src イメージソース
   */
  decode(src) {
    const config = Object.assign({}, this.config, { src: src });

    return new Promise((resolve, reject) => {
      Quagga.decodeSingle(config, result => {
        resolve(result);
      });
    })
  }

  /**
   * 処理が完了したときに実行される
   */
  _onProcessed(data) {
    console.log('onProccessed', data);
    
    const ctx = Quagga.canvas.ctx.overlay;
    const canvas = Quagga.canvas.dom.overlay;

		if (!data) { return; }

    // 認識したバーコードを囲む
    if (data.boxes) {
      ctx.clearRect(0, 0, canvas.width, canvas.height);

      const hasNotRead = box => box !== data.box;
      data.boxes.filter(hasNotRead).forEach(box => {
        Quagga.ImageDebug.drawPath(box, {x:0, y:1}, ctx, {color: 'green', lineWidth: 2});
      });
    }

    // 読み取ったバーコードを囲む
    if (data.box) {
      Quagga.ImageDebug.drawPath(data.box, {x:0, y:1}, ctx, {color: 'blue', lineWidth: 2});
    }
    
    // 読み取ったバーコードに線を引く
    if (data.codeResult && data.codeResult.code) {
      Quagga.ImageDebug.drawPath(data.line, {x:'x', y:'y'}, ctx, {color: 'red', lineWidth: 3});
    }
  }

  /**
   * バーコード読み取りが成功したときに実行される
   */
  _onDetected(data) {
    console.log('onDetected', data);
  }
  
  getDataURL() {
    return Quagga.canvas.dom.image.toDataURL();
  }
}

async function barcode_reader(obj) {
  const barcodeReader = new BarcodeReader();
    const file = obj.files[0];
    const id = obj.id.substr(7, 2);
    const src = window.URL.createObjectURL(file);

    const result = await barcodeReader.decode(src);
    const isbn_code = result.codeResult.code;

    const rslt = 'isbn' + id;
    document.getElementById(rslt).value = isbn_code;
    
    isbnSearch(isbn_code, id);
}
