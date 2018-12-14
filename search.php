<?php include 'partials/html-head.php'; ?>
    <h1>Hi!</h1>
    <p>Now time for testing. Search overview</p>
    <form id="searchForm" action="" method="get">
        <input type="text" id="searchBar" name="query" placeholder="Search course...">
        <input type="submit" id="searchSubmit" value="Search">
    </form>
    <table>
        <thead>
            <tr>
                <th>Course</th>
                <th>Code</th>
                <th>Units</th>
            </tr>
        </thead>
        <tbody id="tableBody">

        </tbody>
    </table>
    <?php
        $searchQuery = '';
        if (!empty($_GET)) {
            $searchQuery = $_GET['query'];
        }
    ?>
    <script>
        function loadJson(searchQuery, category, program) {
            $(function(){
                var url = 'https://script.google.com/macros/s/AKfycbx5zKAL58XAs8GAWrIP0XHQsIbmSusaYtWDS6Y8-u9kB_09h7Y/exec';
                $.getJSON(url,function(data){
                    var html = $('#tableBody').html();
                    
                    $('#searchBar').val(searchQuery);
                    $.each(data, function(key,val){
                        if(val.length >= 8 && (searchQuery == val[1].toLowerCase() 
                            || val[0].toLowerCase().search(searchQuery) != -1 
                            || searchQuery == val[6].toLowerCase() 
                            || searchQuery == '')) {

                            html += '<tr>';
                            html += '<td>' + val[0] + '</td>';
                            html += '<td>' + val[6] + '</td>';
                            html += '<td>' + val[7] + '</td>';
                            html += '</tr>';
                        }
                    })
                    $('#tableBody').html(html);
                })
            })
        }

        function loadQuery() {
            var searchQuery = "<?php echo $searchQuery; ?>".toLowerCase();
            loadJson(searchQuery, '', '');
        }

        $(document).ready(loadQuery);
    </script>
<?php include 'partials/html-footer.php'; ?>