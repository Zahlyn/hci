<?php include 'partials/html-head.php'; ?>
    <h1>Hi!</h1>
    <p>Now time for testing. Search overview</p>
    <button type="button" id="loadData" onclick="loadJson">Load JSON</button><br>
    <form id="searchForm" action="search.php" method="get">
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
        function loadJson() {
            $(function(){
                    var url = 'https://script.google.com/macros/s/AKfycbx5zKAL58XAs8GAWrIP0XHQsIbmSusaYtWDS6Y8-u9kB_09h7Y/exec';
                    $.getJSON(url,function(data){
                    var html = $('#tableBody').html();
                    console.log(html);
                    var searchQuery = "<?php echo $searchQuery; ?>";
                    $('#searchBar').val(searchQuery);
                    $.each(data, function(key,val){
                        // TODO: implement actual search function
                        // Currently only an exact match with META field works
                        if((val.length >= 8 && val[1] == searchQuery) || searchQuery == '') {
                            //console.log(val);
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

        $(document).ready(loadJson);
    </script>
<?php include 'partials/html-footer.php'; ?>