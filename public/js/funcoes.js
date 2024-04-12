
$('#estado').change(function () {
    console.log(this.value);
    $.get('/buscacidade/'+this.value, function (data) {
        html = '<select name="cidade" id="cidade">';
        data.forEach(function (cidade, index) {
                console.log(cidade.id + ' - ' + cidade.nome);
                html += '<option value="'+cidade.id+'">'+cidade.nome+'</option>'
            });
        html += "</select>";
        $('#scidade').html(html);
        console.log(html);
        });
});
