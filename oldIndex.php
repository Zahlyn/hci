<?php include 'partials/html-head.php'; ?>
    <h1>Hi!</h1>
    <p>Now time for testing</p>
    <button type="button" id="loadData">Load JSON</button>
    <div id="output"></div>
    <script>
        $(function(){
            $('#loadData').click(function(){
                var url = 'https://script.google.com/macros/s/AKfycbx5zKAL58XAs8GAWrIP0XHQsIbmSusaYtWDS6Y8-u9kB_09h7Y/exec';
                $.getJSON(url,function(data){
                    var html ='<h3>Google Sheet Data</h3>';
                    $.each(data, function(key,val){
                        for(var x = 0; x < val.length; x++){
                            html += val[x] + '';
                        }
                        html += '<br>';
                    })
                    $('#output').html(html);
                })
            })
        })
    </script>
<?php include 'partials/html-footer.php'; ?>