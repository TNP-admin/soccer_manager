function isbnSearch(isbn, id) {
    console.log(isbn);
    const id_no = id.slice(-2);
    console.log(id_no)
    const title = document.getElementById('title' + id_no);
    const titlekana = document.getElementById('titlekana' + id_no);
    const series = document.getElementById('series' + id_no);
    const author = document.getElementById('author' + id_no);
    const publisher = document.getElementById('publisher' + id_no);

    fetch('https://app.rakuten.co.jp/services/api/BooksBook/Search/20170404?applicationId=1042871684315468422&formatVersion=2&isbn=' + isbn)
        .then(response => {
            console.log(response.status);
            if (!response.ok) {
                console.error("エラーレスポンス", response);
            } else {
                return response.json().then(bookInfo => {
                    console.log(bookInfo);
                    console.log(bookInfo.Items[0]);
                    const bookData = bookInfo.Items[0];
                    title.value = bookData.title;
                    titlekana.value = bookData.titleKana;
                    series.value = bookData.seriesName;
                    author.value = bookData.author;
                    publisher.value = bookData.publisherName;
                });
            }
        }).catch(error => {
            console.error(error);
        });
}
