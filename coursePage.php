<?php include 'partials/html-head.php'; ?>
    <h1>Hi!</h1>
    <form action="myCourses.php">
        <input type="submit" value="My Courses">
    </form>
    <p>Now time for testing. Course page</p>
    <br><br><br>
    <div id="courseInfo">
    </div>
    <?php
        $searchQuery = '';
        if (!empty($_GET)) {
            $searchQuery = $_GET['courseCode'];
        }
    ?>
    <script>
        function loadJson(searchQuery, category, program) {
            $(function(){
                var url = 'https://script.google.com/macros/s/AKfycbx5zKAL58XAs8GAWrIP0XHQsIbmSusaYtWDS6Y8-u9kB_09h7Y/exec';
                $.getJSON(url,function(data){
                    var html = $('#courseInfo').html();
                    console.log(html)
                    $.each(data, function(key,val){
                        if(val.length >= 8 && searchQuery == val[6].toUpperCase() ) {
                            console.log(val[0])
                            html += '<h1>' + val[0] + '</h1>';
                            html += '<h3>' + val[6] + '</h3>';
                            html += '<p>' + val[2] + '</p>';
                            
                        }
                    })
                    $('#courseInfo').html(html);
                })
            })
        }

        function loadQuery() {
            var searchQuery = "<?php echo $searchQuery; ?>".toUpperCase();
            loadJson(searchQuery, '', '');
        }
        
        function init() {    
            loadQuery();
        }

        $(document).ready(init);
    </script>
<?php include 'partials/html-footer.php'; ?>