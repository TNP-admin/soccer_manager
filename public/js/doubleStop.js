$(function() {
    $('.btn-one').on('click', function() {
        //console.log($(this));
        $('.btn').prop('disabled', true);
        var num = this.name.substr(-1);
        //var length = this.name.length;
        var formname = 'form-one-' + num;
        var formnm = '.form-one-' + num;
        var formone = document.getElementsByClassName(formname);
        var Insert = document.createElement('input');
        Insert.type ='hidden';
        Insert.name =this.name.substr(0, this.name.length - 1);
        Insert.value=this.value;
        formone[0].appendChild(Insert);
        //console.log(formone);
        $(formnm).submit();
 
        // 3秒後に元に戻す
        setTimeout(function() {
            $('.btn').prop('disabled', false);
        }, 3000);
    });
});

$(function() {
    $('.btn-all').on('click', function() {
        //console.log($(this));
        $('.btn').prop('disabled', true);
        var formone = document.getElementsByClassName('form-all');
        //console.log(formone);
        var Insert = document.createElement('input');
        Insert.type ='hidden';
        Insert.name =this.name;
        Insert.value=this.value;
        formone[0].appendChild(Insert);
        //console.log(formone);
        $('.form-all').submit();
    });
});